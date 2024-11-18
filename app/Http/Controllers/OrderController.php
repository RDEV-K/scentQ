<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrderAddress;
use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Staff;
use App\Models\Coupon;
use App\Models\Gateway;
use App\Models\CartItem;
use App\Models\Taxonomy;
use App\Models\QueueItem;
use App\Events\CouponUsed;
use App\Events\OrderPlaced;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Events\UserSubscribed;
use App\Models\Settings;
use App\Models\ShippingPolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Notifications\Admin\NewOrderNotification;
use App\Traits\KlaviyoTrait;
use App\Traits\SetNameTrait;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    use KlaviyoTrait, SetNameTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request, $type = 'orders')
    {
        /* @var User $user */
        $user = $request->user();
        $query = $user->orders()->latest()->with(['items' => function ($q) use ($user) {
            $q->with(['metas', 'product' => function ($q2) use ($user) {
                $q2->with(['brand', 'reviews' => function ($q3) use ($user) {
                    $q3->where('reviews.user_id', $user->id);
                }]);
            }]);
        }, 'queue']);
        $orders = $query->where('status', '!=', Order::$STATUS_NO_ENTRY)->where('queue_id', null)->paginate(10);

        $year = Carbon::now()->format('Y');

        $subscription_query = $user->orders()->latest()->with(['queue']);
        $subscription_orders = $subscription_query->with(['items.product.brand'])->where('status', '!=', Order::$STATUS_NO_ENTRY)->where('queue_id', '!=', null)->paginate(10);

        return inertia('User/OrderHistory', compact('orders', 'type', 'subscription_orders', 'year'))->title('My Order');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Inertia\Response
     */

    public function create(Request $request)
    {

        if( Session::get('select_plan')){
            $select_plan=Session::get('select_plan');
            $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('id', $select_plan)->first();
        }
        else{
            $plan = $this->getDefaultPlan();
        }

        /* @var User $user */
        $user = $request->user();

        $sub_discount = 0;
        $subscription_dis = \DB::table('subscriptions')->where('user_id', $user->id)->first();
        $setting = Settings::first();
        if (is_null($subscription_dis) && $setting?->first_month_subscribe_discount_status) {
            $sub_discount = 1;
        }

        $cart = $user->cart()->with('items')->first();
        if (!$cart) return redirect($user->home)->withErrors('No cart available');
        if (!$cart->items->count()) return redirect($user->home)->withErrors('Empty Cart');
        $countries = config('countries');
        $states = config('states');
        $stripePublicKey = config('services.stripe.key');
        $intent_client_secret = $user->createSetupIntent()->client_secret;
        $order=Order::where('user_id', $user->id)->latest()->first();
        if ($order){
            $shipping_addresses = OrderAddress::where('order_id', $order->id)->get();
        }else{
            $shipping_addresses = $user->addresses()->where('type', 'shipping')->get();
        }
        $gateways = Gateway::query()->select(['id', 'name', 'image'])->get();

        $this->startedCheckout($cart?->items?->count() ?? 0, $user);

        return inertia('User/Checkout', compact('gateways', 'shipping_addresses', 'intent_client_secret', 'stripePublicKey', 'countries', 'states', 'sub_discount','plan'))->title('Checkout');
    }

    public function getDefaultPlan()
    {
        $user = auth()->user();
        try {
            if ($user->subscription('personal')) {
                $sub = $user->subscription('personal');
                $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('stripe_id', $sub?->stripe_price)->first();
            } else {
                $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('is_default', true)->first();
            }
        } catch (\Throwable $th) {
            $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('is_default', true)->first();
        }

        return $plan;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $params = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'line1' => 'required|string|max:191',
            'line2' => 'nullable|string|max:191',
            'country' => 'required|string|max:191',
            'state' => 'nullable|string|max:191',
            'city' => 'required|string|max:191',
            'postal_code' => 'required|string|max:191',
            'phone' => 'required|string|regex:/^[0-9+\-\(\) ]*$/',
            'gateway_id' => 'required|exists:gateways,id',
            'payment_method' => 'required_if:gateway_id,1',
        ]);

        $user = $request->user();
        $cart = $user->cart()->with('items')->firstOrFail();

        // update user name
        $this->setName($user, $request->name);

        $subscription_price = 0;
        $checkSubscriptionExists = 0;

        foreach ($cart->items()->get() as $item) {
            if ($item->purchase_option_type == 'subscription') {

                $checkSubscriptionExists = 1;

                // new explain code start
                if( Session::get('select_plan')){
                    $select_plan=Session::get('select_plan');

                    $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->where('id', $select_plan)->first();
                }else{
                    $plan = Plan::query()->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->first();
                }
                // new explain code end
                // previous code start
                // if (is_null($plan)) {
                //     $plan = Plan::query()->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->first();
                // }
                   // previous code end

                try {
                    DB::beginTransaction();
                    $shippingAddress = $user->addresses()->updateOrCreate(
                        ['type' => 'shipping'],
                        $request->only(['name', 'email', 'phone', 'country', 'state', 'city', 'line1', 'line2', 'postal_code'])
                    );
                    if (!$user->subscription('personal')) {
                        if (cache()->has('subscribe-extra-coupon-' . auth()->id())) {
                            $coup = cache()->get('subscribe-extra-coupon-' . auth()->id());
                        } elseif ($plan->autoCoupon) {
                            $coup = $plan->autoCoupon;
                        }
                        $subscriptionBuilder = $user->newSubscription('personal', $plan->stripe_id);

                        $check_sub = \DB::table('subscriptions')->where('user_id', $user->id)->first();
                        if (is_null($check_sub)) {
                            // $subscription_price = $plan->total_price/2;
                            // $subscriptionBuilder->withCoupon('NlYxQcv5');
                        } else {
                            $subscription_price = $plan->total_price;
                        }

                        if (isset($coup) && $coup instanceof Coupon) {
                            $subscriptionBuilder->withCoupon($coup->strip_coupon);
                        }
                        $subscription = $subscriptionBuilder->create($request->payment_method);
                        if (isset($coup) && $coup instanceof Coupon) {
                            event(new CouponUsed($coup));
                            cache()->forget('subscribe-extra-coupon-' . $user->id);
                        }

                        event(new UserSubscribed($user, $plan));
                    } else if ($user->subscription('personal')->hasIncompletePayment()) {
                        $user->updateDefaultPaymentMethod($request->payment_method);
                        $user->updateDefaultPaymentMethodFromStripe();
                    } else if ($user->subscription('personal')->canceled()) {
                        $user->updateDefaultPaymentMethod($request->payment_method);
                        $user->updateDefaultPaymentMethodFromStripe();
                        $user->subscription('personal')->resume();
                    }
                    DB::commit();
                    // return redirect($user->home)->withSuccess(__('Subscribed Successfully'));
                } catch (\Exception $exception) {
                    DB::rollBack();
                    throw ValidationException::withMessages(['name' => $exception->getMessage()]);
                }
            }
        }

        if (count($cart->items()->get()) == 1 && $checkSubscriptionExists == 1) {

            Cart::where('id', $cart->id)->delete();
            return redirect($user->home)->withSuccess(__('Subscribed Successfully'));
        }


        /* @var User $user */
        $user = $request->user();
        /* @var Cart $cart */
        $cart = $user->cart()->with('items')->firstOrFail();
        if (!$cart->items->count()) throw ValidationException::withMessages(['cart' => 'Empty Cart']);
        $shipping = CartItemController::shippingPolicy($cart);
        $shipping_policy_id = null;
        $shipping_cost = config('misc.default_shipping');

        if (isset($shipping['exact']) && $shipping['exact'] instanceof ShippingPolicy) {
            $shipping_policy_id = $shipping['exact']->id;
            $shipping_cost = $shipping['exact']->charge;
        }
        try {
            DB::beginTransaction();
            /* @var Order $order */
            $order = Order::create([
                'user_id' => $user->id,
                'shipping_policy_id' => $shipping_policy_id,
                'shipping_cost' => $shipping_cost,
                'coupon_id' => $cart->coupon_id,
                'coupon_code' => $cart->coupon_code,
                'net_total' => $cart->net_total,
                // 'tax_total' => $cart->tax_total,
                'discount' => $cart->discount,
                'policy_discount' => $cart->policy_discount ?? 0,
                'gross_total' => ($cart->gross_total - $subscription_price) + $shipping_cost,
                'curreny' => config('misc.currency_code'),
                'converted_price' => currencyConvert(($cart->gross_total - $subscription_price) + $shipping_cost) ?? 0,
            ]);
            // data push to klaviyo
            $this->orderPlaced($order, $user);
            $line_items_params = $cart->items->map(function (CartItem $cartItem) {
                return $cartItem->only(['product_id', 'purchase_option_id', 'product_title', 'product_image', 'purchase_option', 'amount', 'quantity', 'subtotal', 'attrs']);
            })->toArray();
            $order->items()->createMany($line_items_params);
            $order->addresses()->updateOrCreate(['type' => 'shipping'], Arr::except($params, ['gateway_id', 'payment_method']));

            // user address save process
            if ($request->address_status == 'edit') {
                $this->addressEditOrSave($request, $user, 'edit');
            }
            if ($request->address_status == 'add_new') {
                $this->addressEditOrSave($request, $user, 'add_new');
            }

            if ($cart->coupon) {
                event(new CouponUsed($cart->coupon));
            }
            DB::commit();
            event(new OrderPlaced($order));

            Session::forget('select_plan');


            return PaymentController::order($order, $request->gateway_id, ['payment_method' => $request->payment_method]);
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function addressEditOrSave($request, $user, $action)
    {
        try {
            if ($request->address_status == 'edit') {
                $address = $user->addresses()->where('id', $request->address_id)->first();
                if ($address) {
                    $address->update([
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
            if ($request->address_status == 'add_new') {
                $user->addresses()->create([
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
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Inertia\Response
     */
    public function show(Request $request, $order)
    {
        $user = $request->user('web');
        $order = Order::with('coupon', 'queue', 'items.product.reviews') // Eager load relationships
            ->withCount(['items', 'queue'])
            ->where('id', $order)
            ->orWhere('order_no', $order)
            ->firstOrFail(); // Use firstOrFail() to throw 404 if order not found

        // Check if the authenticated user is authorized to view this order
        if ($order->user_id != $user->id) {
            throw new AuthorizationException;
        }

        // Append the 'html_status' attribute to the order
        $order->append('html_status');

        // Load shipping address
        $shipping = $order->addresses()->where('type', 'shipping')->first();

        // Eager load taxonomies with their terms and reviews count
        $taxonomies = Taxonomy::with(['terms' => function ($query) {
            $query->withCount('reviews');
        }])->get();

        // Return the view with data
        return inertia('User/Track', compact('order', 'shipping', 'taxonomies'))
            ->title(__('Track Order'));
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
        //
    }
}
