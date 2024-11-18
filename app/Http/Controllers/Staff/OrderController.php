<?php

namespace App\Http\Controllers\Staff;

use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderInvoiceToCustomer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTableAbstract;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = Order::query()->with(['addresses']);

            if ($request->type == 'orders') {
                $query->whereDoesntHave('queue');
            }

            if ($request->type == 'queue') {
                $clo = null;
                if (is_numeric($request->year) || is_numeric($request->month)) {
                    $year = $request->year;
                    $month = $request->month;
                    $clo = function ($q) use ($year, $month) {
                        if ($year) {
                            $q->where('year', $year);
                        }
                        if ($month) {
                            $q->where('month', $month);
                        }
                    };
                }
                $query->whereHas('queue', $clo);
            }

            if ($request->keyword && $request->keyword != null) {
                $query->where(function ($q) use ($request) {

                    $order_no = str_replace('#', '', $request->keyword);

                    $q->where('order_no', $order_no)

                        ->orWhereHas('user', function ($user) use ($request) {
                            $user->where('first_name', 'LIKE', "%$request->keyword%")
                                ->orWhere('email', $request->keyword);
                        });
                });
            }

            if ($request->has('status') && $request->status != null) {
                if ($request->status == 'processing') {
                    $query->whereIn('status', ['processing', 'no_entry', 'pending']);
                } else {
                    $query->where('status', $request->status);
                }
            }

            if ($request->start_date) {
                $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date);
                $query->whereDate('created_at', '>=', $startDate);
            }
            if ($request->end_date) {
                $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date);
                $query->whereDate('created_at', '<=', $endDate);
            }

            /* @var DataTableAbstract $table */
            $table = datatables($query);
            $table->addColumn('order', function (Order $order) {
                $shipping = $order->addresses->where('type', 'shipping')->first();
                return sprintf('<a href="%s">#%s %s</a>', route('staff.order.show', $order->id), $order->order_no ?? $order->id, $shipping?->name);
            });
            $table->editColumn('gross_total', function (Order $order) {
                return currencyConvertWithSymbol($order->gross_total);
            });
            $table->filterColumn('order', function ($query, $keyword) {
                /* @var Builder $query */
                $query->where('id', $keyword)->orWhereHas('addresses', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%$keyword%")->orWhere('email', 'LIKE', "$keyword%")->orWhere('phone', 'LIKE', "$keyword%");
                });
            });
            $table->editColumn('created_at', function (Order $order) {
                return optional($order->created_at)->format('M d, Y');
            });
            $table->editColumn('status', function (Order $order) {
                return $order->html_status;
            });
            $table->addColumn('action', function (Order $order) {
                return '
                <div class="d-flex">
                    <button class="btn btn-danger btn-delete btn-sm ml-1" data-id="' . $order->id . '"><i class="fas fa-trash"></i></button>
                </div>
                ';
            });
            $table->rawColumns(['order', 'status', 'action']);
            return $table->make(true);
        }
        $searchParams = [
            'type' => $request->type,
            'year' => $request->year,
            'month' => $request->month,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'keyword' => $request->keyword
        ];

        $processing_orders = Order::whereIn('status', ['processing', 'no_entry', 'pending'])->count();
        $in_transit =  Order::where('status', 'in_transit')->count();
        $completed = Order::where('status', 'completed')->count();
        $canceled = Order::where('status', 'canceled')->count();
        $all_orders = Order::count();

        return view('staff.order.index', compact(
            'searchParams',
            'processing_orders',
            'in_transit',
            'completed',
            'canceled',
            'all_orders'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Order $order)
    {
        $shipping = $order->addresses()->where('type', 'shipping')->first();
        $payments = $order->payments()->orderByDesc('id')->get();
        $gateways = Gateway::all();
        $order->load(['coupon', 'items' => function ($q) {
            $q->with(['metas', 'product', 'product.brand:id,name,slug']);
        }]);

        $subscription = $order?->user?->subscription('personal');
        $subscriptionFromStripe = $subscription ? (clone $subscription)->asStripeSubscription() : '';
        $subscribed_on = Carbon::createFromTimestamp($subscriptionFromStripe?->created ?? '')->format('d M Y');

        return view('staff.order.show', compact('order', 'shipping', 'payments', 'gateways', 'subscribed_on'));
    }

    public function editAddress(OrderAddress $orderAddress)
    {
        return view('staff.order.address-edit', compact('orderAddress'));
    }

    public function updateAddress(Request $request, OrderAddress $orderAddress)
    {
        try {
            DB::beginTransaction();
            $orderAddress->update($request->all());
            DB::commit();
            return redirect()->back()->with('success', 'Address has been updated');
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['title' => $exception->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return redirect()->back()->withSuccess('Order deleted.');
        } catch (\Exception $exception) {
            return redirect()->back()->withSuccess($exception->getMessage());
        }
    }

    public function postAction(Request $request, Order $order)
    {
        if (!$order) return abort(404);

        $order->load(['queue', 'items', 'user', 'coupon']);

        $request->validate([
            'action' => 'required|in:1,2'
        ]);
        $shippingAddress = $order->addresses()->where('type', 'shipping')->first();
        if (!$shippingAddress instanceof OrderAddress) {
            throw ValidationException::withMessages(['action' => 'Not Found']);
        }

        if ($request->action == 1) {
            // Send Invoice To Customer
            $shippingAddress->notify(new OrderInvoiceToCustomer($order, $shippingAddress));
        } elseif ($request->action == 2) {
            // Send New Order Notification To Customer
            $shippingAddress->notify(new NewOrderNotification($order, $shippingAddress));
        }
        return redirect()->back()->withSuccess('Action executed successfully');
    }

    public function updateStatus(Request $request, $id = null)
    {
        // return $request;
        $request->validate([
            'status' => 'required',
            "tracking_code" => $request->status == 'in_transit' ? 'required' : '',
            "tracking_url" => $request->status == 'in_transit' ? 'required' : '',
        ], [
            'status.*' => 'Invalid status'
        ]);

        $orders = [];
        if ($order = Order::find($id)) {
            $orders[] = $order;
        } else {
            $orders = Order::query()->whereIn('id', (is_array($request->orders) ? $request->orders : []))->get();
        }
        try {
            foreach ($orders as $order) {
                $from = $order->status;
                $r = $order->update([
                    'status' => $request->status,
                    'tracking_no' => $request->tracking_code,
                    'tracking_url' => $request->tracking_url,
                    'delivery_completed_date' => $request->status == 'completed' ? Carbon::now() : null,
                ]);

                $order->load(['items',]);
                $order->append(['html_status']);
                if ($r) {
                    event(new OrderStatusUpdated($order, $from, $request->status));
                }
            }
        } catch (\Exception $exception) {
            return redirect()->back()->withSuccess($exception->getMessage());
        }
        return redirect()->back()->withSuccess('Status updated successfully');
    }

    public function courierDetailsUpdate(Request $request, Order $order)
    {
        $order->update([
            "tracking_no" => $request->tracking_code,
            "tracking_url" => $request->tracking_url,
        ]);

        return redirect()->back()->withSuccess('Courier Tracking Details Updated!');
    }
}
