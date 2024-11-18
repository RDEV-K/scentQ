<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Meta;
use App\Models\Plan;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Cashier\Cashier;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Plan::query()->domain(getCurrentDomain());
            $table = datatables($query);
            $table->addColumn('action', function (Plan $Plan) {
                return '<div class="d-flex"><a href="' . route('staff.plan.edit', $Plan->id) . '" class="btn btn-warning btn-edit btn-sm"><i class="fas fa-edit"></i></a><button class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1" data-id="' . $Plan->id . '"><i class="fas fa-trash"></i></button></div>';
            });
            $table->editColumn('free_shipping', function (Plan $Plan) {
                return $Plan->free_shipping == 1 ? '<span class="badge badge-success">'.__('Yes').'</span>' : '<span class="badge badge-danger">'.__('No').'</span>';
            });
            $table->editColumn('price_par_product', function (Plan $plan){
                return '<span class="badge badge-primary text-light">'.currencyConvertWithSymbol($plan->price_par_product) .'</span>';
            });
            $table->editColumn('total_price', function (Plan $plan){
                return '<span class="badge badge-primary text-light">'.currencyConvertWithSymbol($plan->total_price).'</span>';
            });
            // $table->editColumn('tax', function (Plan $plan){
            //     return '<span class="badge badge-primary text-light">'.$plan->tax .' '.'%</span>';
            // });
            // $table->rawColumns(['action', 'free_shipping', 'price_par_product', 'total_price', 'tax']);
            $table->rawColumns(['action', 'free_shipping', 'price_par_product', 'total_price']);
            return $table->make(true);
        }
        return view('staff.plan.plans');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::query()->select(['id', 'title'])->get();
        $coupons = Coupon::query()->select(['id', 'code'])->where('system_added', false)->domain(getCurrentDomain())->get();
        return view('staff.plan.createPlan', compact('products', 'coupons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'interval_count' => 'required_if:type,personal|numeric|gte:1',
            'first_discount' => 'nullable|numeric',
            'stripe_coupon' => 'nullable|string',
            'free_product_id' => 'nullable|exists:products,id',
            'first_time_coupon_id' => 'nullable|exists:coupons,id',
            'product_count' => 'required|numeric',
            'price_par_product' => 'required|numeric',
            'total_price' => 'required_if:type,personal|numeric',
            'type' => 'required|string|in:personal,gift',
            'badge_text' => 'nullable|string|max:191',
            // 'tax' => 'nullable|numeric',
            'gift_month_count' => 'required_if:type,gift|numeric',
            'gift_total' => 'required_if:type,gift|numeric',
            'gift_save' => 'nullable|numeric',
            'features' => 'nullable|array',
            'features.*' => 'required|string',
            'gift_personal_receive' => 'nullable|numeric',
        ]);
        // 'tax'
        $params = $request->only(['name', 'interval_count', 'product_count','price_par_product','type','badge_text','gift_month_count','gift_total','gift_save','features','gift_personal_receive', 'first_discount', 'stripe_coupon', 'free_product_id', 'total_price', 'first_time_coupon_id']);
        if($request->free_shipping) {
            $params['free_shipping'] = true;
        } else {
            $params['free_shipping'] = false;
        }
        if($request->is_default) {
            $params['is_default'] = true;
        } else {
            $params['is_default'] = false;
        }

        $domain = request()->getHost();
        $params['domain'] = $domain;

        try {
            DB::beginTransaction();
            $plan = Plan::create($params);
            if (!$plan) throw new \Exception('Unable to create plan');
            if ($plan->type == 'personal') {

                // $stripeProduct = Meta::query()->where('name', 'cashier_stripe_fragrance_subscription')->first();

                // if (!$stripeProduct) throw new \Exception('Please seed stripe first');

                $price = Cashier::stripe()->prices->create([
                    'currency' => config('misc.currency_code'),
                    'product' => getStripeProduct(),
                    'unit_amount_decimal' => ($plan->total_price*100),
                    'nickname' => 'Plan #' . $plan->id . ' (' . $plan->name . ')',
                    'billing_scheme' => 'per_unit',
                    'recurring' => [
                        'interval' => 'month',
                        'interval_count' => $plan->interval_count,
                    ]
                ]);
                $plan->update([
                    'stripe_id' => $price->id
                ]);
            }
            DB::commit();
            return redirect()->route('staff.plan.index')->withSuccess(__('Plan Added'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['name' => $exception->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit($plan)
    {
        $plan = Plan::findOrFail($plan);
        $products = Product::query()->select(['id', 'title'])->get();
        $coupons = Coupon::query()->select(['id', 'code'])->where('system_added', false)->domain(getCurrentDomain())->get();
        return view('staff.plan.editPlan', compact('plan', 'products', 'coupons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $plan)
    {
        $plan = Plan::findOrFail($plan);

        $request->validate([
            'name' => 'required|string',
            'interval_count' => 'required_if:type,personal|numeric|gte:1',
            'first_discount' => 'nullable|numeric',
            'stripe_coupon' => 'nullable|string',
            'free_product_id' => 'nullable|exists:products,id',
            'first_time_coupon_id' => 'nullable|exists:coupons,id',
            'product_count' => 'required|numeric',
            'price_par_product' => 'required|numeric',
            'total_price' => 'required_if:type,personal|numeric',
            'type' => 'required|string|in:personal,gift',
            'badge_text' => 'nullable|string|max:191',
            // 'tax' => 'nullable|numeric',
            'gift_month_count' => 'required_if:type,gift|numeric',
            'gift_total' => 'required_if:type,gift|numeric',
            'gift_save' => 'nullable|numeric',
            'features' => 'nullable|array',
            'features.*' => 'required|string',
            'gift_personal_receive' => 'nullable|numeric',
        ]);
        // 'tax'
        $params = $request->only(['name', 'interval_count', 'product_count','price_par_product','type','badge_text','gift_month_count','gift_total','gift_save','features','gift_personal_receive', 'first_discount', 'stripe_coupon', 'free_product_id', 'total_price', 'first_time_coupon_id','stripe_id']);
        if($request->free_shipping) {
            $params['free_shipping'] = true;
        } else {
            $params['free_shipping'] = false;
        }
        if($request->is_default) {
            $params['is_default'] = true;
        } else {
            $params['is_default'] = false;
        }

        try {
            $res = $plan->update($params);

            // $stripeProduct = Meta::query()->where('name', 'cashier_stripe_fragrance_subscription')->first();

            // if (!$stripeProduct) throw new \Exception('Please seed stripe first');

            // $price = Cashier::stripe()->prices->create([
            //     'currency' => config('misc.currency_code'),
            //     'product' => getStripeProduct(),
            //     'unit_amount_decimal' => ($plan->total_price*100),
            //     'nickname' => 'Plan #' . $plan->id . ' (' . $plan->name . ')',
            //     'billing_scheme' => 'per_unit',
            //     'recurring' => [
            //         'interval' => 'month',
            //         'interval_count' => $plan->interval_count,
            //     ]
            // ]);
            // $plan->update([
            //     'stripe_id' => $price->id
            // ]);

            if (!$res || !$plan) throw new \Exception(__('Unable to update Plan'));
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
        return redirect()->back()->withSuccess(__('Plan updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Plan $plan)
    {
        try {
            $planId= $plan->id;
            $stripeId = $plan->stripe_id;
            $res = $plan->delete();
            if ($plan->type == 'personal') {
                Cashier::stripe()->prices->update($stripeId, [
                    'nickname' => 'Deleted Plan #' . $planId
                ]);
            }
            $res = $plan->delete();
            if (!$res) throw new \Exception('Unable to delete This Plan');
            return redirect()->back()->withSuccess(__('Plan deleted successfully'));
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
}
