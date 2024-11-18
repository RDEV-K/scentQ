<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAddress;
use DateTime;
use Carbon\Carbon;
use App\Models\Faq;
use App\Models\Meta;
use App\Models\Page;
use App\Models\Plan;
use App\Models\User;
use App\Models\Review;
use App\Models\Address;
use App\Models\Product;
use App\Models\PrivateSale;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\Models\ProductOfTheMonth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use Stripe\Subscription as StripeSubscription;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function index($gen = 'women')
    {
        /* @var User $user */
        $user = auth('web')->user();
        $sub = $user->subscription('personal');
        /**
         * Check the user gender male or female.
         * Default using women
         * In case of female use $gen as women,
         * In case or male use $gen as male
         */
        $gen = $user->gender == 'male' ? 'men' : 'women';
        $page = Page::query()->with('metas')->where('slug', $gen . '-home')->firstOrFail();
        return inertiaWithMeta($page, compact('gen'));
    }

    function subscriptionInfo(Request $request)
    {
        /* @var User $user */
        $user = $request->user();

        try {
            $subscription = $user->subscription('personal');

            throw_if(!$subscription, 'Not Subscribed');

            $subscriptionFromStripe = (clone $subscription)->asStripeSubscription();
            $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();

            $status = 'Active';

            if ($subscription->canceled()) {
                $status = 'Canceled';
            }

            if ($subscription->active() && !$subscription->canceled()) {
                $status = 'Active';
            }

            return [
                'status' => $status,
                'bill_date' => Carbon::createFromTimestamp($subscriptionFromStripe->current_period_end)->format('d M Y'),
                'subscribed_on' => Carbon::createFromTimestamp($subscriptionFromStripe->created)
                    ->format('d M Y'),
                'frequency' => $plan?->interval_count . ' Month',
                'plan' => $plan?->product_count . ' product(s)/month',
                'subscribe_end_on' => date('d M Y', $subscriptionFromStripe['cancel_at']),
            ];
        } catch (\Throwable $th) {
            return [
                'status' => __('Not Subscribed'),
                'bill_date' => '',
                'subscribed_on' => '',
                'frequency' => '0 Month',
                'plan' => '0 product(s)/month',
                'subscribe_end_on' => '',
            ];
        }
    }

    public function remainingMonths()
    {
        // Get the current date
        $currentDate = Carbon::now();

        // Get the end of the current year
        $endOfYear = Carbon::now()->endOfYear();

        // Calculate the remaining months (add 1 to include the current month)
        $remainingMonths = $currentDate->diffInMonths($endOfYear) + 1;

        return $remainingMonths;
    }

    function queue(Request $request)
    {
        $user = Auth()->user();

        $currentDate = Carbon::now();

        // Initialize data array
        $data = [];

        // Loop to generate 12 months
        for ($i = 0; $i < 12; $i++) {

            // Get the current month and year
            $currentMonth = $currentDate->format('F');
            $currentMonth2 = $currentDate->format('m');
            $currentYear = $currentDate->format('Y');


            $start_date_o =  Carbon::parse('01-' . $currentMonth2 . '-' . $currentYear)->startOfMonth();
            $end_date_o = Carbon::parse('01-' . $currentMonth2 . '-' . $currentYear)->endOfMonth();

            // Add the current month to the data array
            $data[$currentYear][] = [
                'month_name' => $currentMonth,
                'order_created' => $this->checkCurrentMonthOrderIsPlaced($start_date_o, $end_date_o),
                'queues_count' => $this->getItemsCount($user, $currentYear, $currentMonth2),
                'remaining_to_be_added' => $this->remainingToBeAdded($user, $currentYear, $currentMonth2),
                'subscription_order_empty' => $this->checkSubscriptionOrderIsEmpty($user, $start_date_o),
                'queue' => $this->getItems($user, $currentYear, $currentMonth2),
            ];

            // Move to the next month
            $currentDate->addMonth();
        }
















        // dd($this->generateMonthList());

        // $remaining_months = $this->remainingMonths();
        // $years = [];
        // $current_year = Carbon::now()->format('Y');

        // if ($remaining_months < 12) {

        //     $next_year = Carbon::now()->addYear(1)->format('Y');
        //     $years = [$current_year, $next_year];
        // } else {
        //     $years = [$current_year];
        // }


        // $queues = [];

        // if (count($years) > 1) {
        // } else {

        //     foreach ($years as $key => $year) {
        //         $month = date('n');

        //         $next_months = 13 - $month;

        //         for ($i = 0; $i < $next_months; $i++) {

        //             $month  = intval(Carbon::now()->format('m')) + $i;
        //             $dateObj   = DateTime::createFromFormat('!m', $month);
        //             $month_name = $dateObj->format('F');

        //             $start_date_o =  Carbon::parse('01-' . $month . '-' . $year)->startOfMonth();
        //             $end_date_o = Carbon::parse('01-' . $month . '-' . $year)->endOfMonth();

        //             $data = [
        //                 '2023' => [
        //                     [
        //                         'month_name' => 'december',
        //                         'queues' => '', //my data,
        //                     ],
        //                 ],
        //                 '2024' => [
        //                     [
        //                         'month_name' => $month_name,
        //                         'queues' => '', //my data,
        //                     ],
        //                     [
        //                         'month_name' => $month_name,
        //                         'queues' => '', //my data,
        //                     ]
        //                 ],
        //             ];
        //             array_push($queues, $data);

        //             // $after_month_product_is_available = $this->checkAfterMonthProductIsAvailable($user, $month);
        //             // if (!$this->getItemsCount($user, $year, $month) && !$after_month_product_is_available) {
        //             //     break;
        //             // }
        //             // if (!$this->getItemsCount($user, $year, $month)) {
        //             //     break;
        //             // }
        //         }
        //     }
        // }


















        // $month = date('n');
        // $year = date('Y');

        // $current_month_queues = [];
        // $remaining_months = $this->remainingMonths();

        // if ($remaining_months < 12) {

        //     $next_year = Carbon::now()->addYear(1);
        //     $next_year = Carbon::now()->addYear(1);

        //     $data = [
        //         'year' => $year,
        //         'order_created' => true,
        //         'queues_count' => $this->getItemsCount($user, $year, $month),
        //         'queues' => $this->getItems($user, $year, $month),
        //     ];

        //     dd($data);
        // } else {
        // }

        // $data = [
        //     'year' => $year,
        //     'order_created' => true,
        //     'queues_count' => $this->getItemsCount($user, $year, $month),
        //     'queues' => $this->getItems($user, $year, $month),
        // ];
        // array_push($current_month_queues, $data);

        // $next_months = 13 - $month;
        // $queues = [];
        // for ($i = 0; $i < $next_months; $i++) {

        //     // $month  = intval(Carbon::now()->format('m'));
        //     $month  = intval(Carbon::now()->format('m')) + $i;
        //     $dateObj   = DateTime::createFromFormat('!m', $month);
        //     $month_name = $dateObj->format('F');

        //     $start_date_o =  Carbon::parse('01-' . $month . '-' . $year)->startOfMonth();
        //     $end_date_o = Carbon::parse('01-' . $month . '-' . $year)->endOfMonth();

        //     $data = [
        //         'year' => $year,
        //         'month_name' => $month_name,
        //         'order_created' => $this->checkCurrentMonthOrderIsPlaced($start_date_o, $end_date_o),
        //         'queues_count' => $this->getItemsCount($user, $year, $month),
        //         'remaining_to_be_added' => $this->remainingToBeAdded($user, $year, $month),
        //         'subscription_order_empty' => $this->checkSubscriptionOrderIsEmpty($user, $start_date_o),
        //         'queues' => $this->getItems($user, $year, $month),
        //     ];
        //     array_push($queues, $data);

        //     // $after_month_product_is_available = $this->checkAfterMonthProductIsAvailable($user, $month);
        //     // if (!$this->getItemsCount($user, $year, $month) && !$after_month_product_is_available) {
        //     //     break;
        //     // }
        //     // if (!$this->getItemsCount($user, $year, $month)) {
        //     //     break;
        //     // }
        // }

        return inertia('User/Queue', compact('data'))->title(__('My Queue'));
    }

    public function checkSubscriptionOrderIsEmpty($user, $date)
    {
        $subscription_order = $user->orders()
            ->whereMonth('created_at', $date)
            ->whereNotNull('queue_id')
            ->first();

        $subscription =  $user->subscription('personal');
        if ($subscription) {
            $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();
            $product_count = $plan->product_count ?? 1;
        } else {
            $product_count = 1;
        }

        if ($subscription_order) {
            $items_count = $subscription_order->items()->count();
            if ($items_count == 0) {
                return true;
            }

            if ($items_count < $product_count) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function pushToOrder()
    {
    }

    public function checkCurrentMonthOrderIsPlaced(string $start_date, string $end_date)
    {
        $order = auth()->user()->orders()
            ->whereNotNull('queue_id')
            ->where('created_at', '>=', $start_date)
            ->where('created_at', '<=', $end_date)
            ->first();

        return $order ? true : false;
    }

    public function checkAfterMonthProductIsAvailable($user, $month)
    {
        $left_months = [];
        $next_months = 13 - $month;
        $year = date('Y');
        for ($i = 0; $i < $next_months; $i++) {

            array_push($left_months, $month + $i);
        }

        $queues = $user->queues()->where('year', $year)->withCount('items')->whereIn('month', $left_months)->get()->map(function ($item) {
            return $item->items_count;
        })->toArray();

        if (in_array(1, $queues)) {
            return true;
        } else {
            return false;
        }
    }

    public function getItems($user, $year, $month)
    {

        $items = $user->queues()->where('year', $year)->where('month', $month)
            ->with(['order', 'items' => function ($q) {
                $q->with(['product' => function ($q2) {
                    $q2->with('brand');
                }])->whereNotNull('addedBy_type');
            }])
            ->first();

        $this_month_product = ProductOfTheMonth::where('year', $year)->where('month', $month)->first();
        if ($this_month_product) {
            $this_month_full_product = Product::where('id', $this_month_product->product_id)->with('brand')->first();
        }

        // $no_items = [
        //     "items" => [
        //         [
        //             'this_month_product_available' => $this_month_product ? true : false,
        //             "product" => $this_month_product ? $this_month_full_product : '',
        //             "year" => $year,
        //             "month" => $month,
        //         ]

        //     ]
        // ];


        // if ($items && count($items->items) > 0) {
        return $items;
        // } else {
        //     return $no_items;
        // }
    }

    public function getItemsCount($user, $year, $month)
    {
        // $items = $user->queues()->where('year', $year)->where('month', $month)
        //     ->with(['order', 'items' => function ($q) {
        //         $q->with(['product' => function ($q2) {
        //             $q2->with('brand');
        //         }])->whereNotNull('addedBy_type');
        //     }])
        //     ->first();
        $items = $user->queues()
            ->with([
                'order',
                'items.product.brand'
            ])
            ->where('year', $year)
            ->where('month', $month)
            ->whereHas('items', fn ($q) => $q->whereNotNull('addedBy_type'))
            ->first();

        if ($items && count($items->items) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function remainingToBeAdded($user, $year, $month)
    {

        $remaining = 0;
        $product_count = 1;

        $subscription =  $user->subscription('personal');
        if ($subscription) {
            $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();
            $product_count = $plan->product_count ?? 1;
        } else {
            $product_count = 1;
        }



        $queue = $user->queues()->where('year', $year)->where('month', $month)
            ->withCount(['items'])
            ->first();

        if (!$queue) { // create queue
            $user->queues()->create([
                'month' => $month,
                'year' => $year
            ]);
        }

        $queue = $user->queues()->where('year', $year)->where('month', $month)
            ->withCount(['items'])
            ->first();

        if ($queue) {
            $remaining = $product_count - $queue->items_count;
        }

        if ($remaining < 0) {
            return 0;
        } else {
            return $remaining;
        }
    }

    public function address(Request $request, $type = 'billing')
    {
        /* @var User $user */
        try {
            $user = $request->user('web');
            $shipping_addresses = null;
            $intent_client_secret = null;
            $stripePublicKey = null;
            $countries = [];
            $states = [];
            if ($type === 'shipping') {
                $order = Order::where('user_id', $user->id)->latest()->first();
                if ($order) {
                    $shipping_addresses = OrderAddress::where('order_id', $order->id)->get();
                } else {
                    $shipping_addresses = collect();
                }

                $countries = config('countries');
                $states = config('states');
            } else {
                $stripePublicKey = config('services.stripe.key');
                $intent_client_secret = $user->createSetupIntent()->client_secret;
            }
            return inertia('Address', compact('countries', 'states', 'stripePublicKey', 'type', 'shipping_addresses', 'intent_client_secret'))
                ->title(ucfirst('update ' . $type));
        } catch (\Throwable $th) {
            throw ValidationException::withMessages(['error' => $th->getMessage()]);
        }
    }

    public function addressUpdate(Request $request, $type = 'billing')
    {
        /* @var User $user */
        $user = $request->user('web');

        if ($type === 'billing') {
            $request->validate([
                'payment_method' => 'required'
            ]);

            try {
                $user->updateDefaultPaymentMethod($request->payment_method);
                $user->updateDefaultPaymentMethodFromStripe();
                return redirect()->back()->withSuccess('Billing updated');
            } catch (\Exception $exception) {
                throw ValidationException::withMessages(['error' => $exception->getMessage()]);
            }
        } else {
            $request->validate([
                'name' => 'required|string|max:191',
                'email' => 'required|email|max:191',
                'line1' => 'required|string|max:191',
                'line2' => 'nullable|string|max:191',
                'country' => 'required|string|max:191',
                'state' => 'nullable|string|max:191',
                'city' => 'required|string|max:191',
                'postal_code' => 'required|string|max:191',
                'phone' => 'required|string|regex:/^[0-9+\-\(\) ]*$/',
            ]);

            try {
                if ($request->new_add) {
                    $order = Order::where('user_id', $user->id)->latest()->first();
                    if ($order) {
                        $order->addresses()->create([
                            'name' => $request->name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'country' => $request->country,
                            'state' => $request->state,
                            'city' => $request->city,
                            'line1' => $request->line1,
                            'line2' => $request->line2,
                            'postal_code' => $request->postal_code,
                            'type' => 'shipping'
                        ]);
                    } else {
                        return back()->with('error', 'No order exists to add an address.');
                    }
                } else {
                    $orderAddress=OrderAddress::where('id',$request->id)->first();
                    if ($orderAddress) {
                        $orderAddress->update([
                            'name' => $request->name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'country' => $request->country,
                            'state' => $request->state,
                            'city' => $request->city,
                            'line1' => $request->line1,
                            'line2' => $request->line2,
                            'postal_code' => $request->postal_code,
                        ]);
                    }
                }

                $msg = $request->new_add ? 'Shipping Added Successfully' : 'Shipping Updated Successfully';
                return redirect()->back()->withSuccess(__($msg));
            } catch (\Throwable $th) {
                return redirect()->back()->withError(__($th->getMessage()));
            }
        }
    }
    public function manageSubscription(Request $request, $type = 'fragrance')
    {
        /* @var User $user */
        try {
            $user = $request->user('web');
            $subscription = $user->subscription('personal');
            if (!$subscription) {
                return redirect()->route('subscribe')->withError(__("You don't have an active subscription. Please subscribe to access this service."));
            }
            $plans = Plan::query()->orderBy('product_count', 'asc')->where('type', 'personal')->with('autoCoupon')->domain(getCurrentDomain())->get();
            $status = 'Canceled';

            if ($subscription->canceled()) {
                $status = 'Canceled';
            }

            if ($subscription->active() && !$subscription->canceled()) {
                $status = 'Subscribed';
            }

            return inertia('User/ManageSubscription', compact('user', 'plans', 'subscription', 'status'))->title(__('Manage Subscription'));
        } catch (\Throwable $th) {
            return redirect()->back()->withError(__($th->getMessage()));
        }
    }

    public function faqs()
    {
        $faqs = Cache::remember('scentq_faqs', now()->addWeek(1), fn () => Faq::all());
        return response()->json($faqs);
    }

    public function addressDestroy(OrderAddress $orderAddress)
    {
        try {
            $orderAddress->delete();
            return redirect()->back()->withSuccess(__('Address Deleted Successfully '));
        } catch (\Throwable $th) {
            return redirect()->back()->withSuccess($th->getMessage());
        }
    }

    public function fetchTestimonial()
    {
        // $testimonials = Review::with('user')->where('rate', '>', 4)->latest()->take(16)->get();

        // $testimonials = Cache::remember(
        //     'testimonials',
        //     now()->addHours(6),
        //     fn () => Review::with('user')
        //         ->where('rate', '>', 4)
        //         ->latest()
        //         ->take(16)
        //         ->get()
        // );
        $testimonials = Testimonial::oldest('index')
            ->take(16)
            ->get();
        return response()->json($testimonials);
    }
}
