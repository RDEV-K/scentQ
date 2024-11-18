<?php

namespace App\Http\Controllers;

use App\Models\OrderAddress;
use Carbon\Carbon;
use Stripe\Stripe;
use App\Models\Cart;
use App\Models\Meta;
use App\Models\Page;
use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Queue;
use App\Models\Staff;
use App\Models\Coupon;
use App\Models\Gateway;
use App\Models\Product;
use App\Models\CartItem;
use Stripe\Subscription;
use App\Events\CouponUsed;
use App\Models\SocialLink;
use App\Events\OrderPlaced;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Events\UserSubscribed;
use App\Models\ShippingPolicy;
use App\Services\CouponService;
use App\Models\ProductOfTheMonth;
use Illuminate\Support\Facades\DB;
use App\Mail\SubscriptionCancelMail;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewOrderNotification;
use App\Notifications\Admin\NewOrderNotification as AdminNewOrderNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UpdatePlanNotification;
use Illuminate\Validation\ValidationException;
use App\Notifications\NewOrderPlaceNotification;
use App\Notifications\SubscriptionAddedNotification;
use App\Notifications\SubscriptionCancelNotification;
use App\Notifications\SubscriptionUpdateNotification;
use App\Traits\KlaviyoTrait;
use App\Traits\SetNameTrait;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\This;
use Laravel\Cashier\Cashier;

class SubscriptionController extends Controller
{
    use KlaviyoTrait, SetNameTrait;

    function checkPlanCart()
    {
        return redirect()->back()->withQueue('Oops! It looks like you have not selected the required number of products. Please add another product to complete your order before proceeding to checkout.Thank you!');
    }

    function subscribe($select_plan = null)
    {

        // if plan come from frontend
        if ($select_plan) {

            Session::put('select_plan', $select_plan);
            // check plan is exist
            $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('id', $select_plan)->first();
            if (!$plan) {

                $plan = $this->getDefaultPlan();

            }
        } else {
            if( Session::get('select_plan')){
                $select_plan=Session::get('select_plan');

                $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('id', $select_plan)->first();
            }
            else{

                $plan = $this->getDefaultPlan();


            }

        }

        // get plan list to show list
        $all_plans = Plan::query()->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->get();

        $countries = config('countries');
        $states = config('states');
        $user = auth()->user('web');

        $month = (int)date('n');
        $year = date('Y');

        // for downgrade condition added
        if ($queue_items_count = $user->queues()->where('year', $year)->where('month', $month)->withCount('items')->first()) {

            if ($queue_items_count && $plan?->product_count < $queue_items_count->items_count) {
                return redirect()->back()->withQueue('Your queue has more than ' . $plan?->product_count . ' product!
                <br>
                Please remove the extra product and try again!');
            }
        }

        // for null plan check
        // if ($queue_items_count = $user->queues()->where('year', $year)->where('month', $month)->withCount('items')->first()) {
        //     if ($plan === null) {
        //         // If plan is null, invalid subscription error message
        //         return redirect()->back()->withQueue('Unable to find a valid subscription plan. Please contact support.');
        //     } elseif ($plan->product_count < $queue_items_count->items_count) {
        //         // If plan exists but product count is less than items in queue
        //         return redirect()->back()->withQueue('Your queue has more than ' . $plan->product_count . ' product(s)!<br>Please remove the extra product and try again.');
        //     }
        // }

        // product add to auth user queue for current month
        $cart = $user->cart()->with('items')->first();

        // check subscription is items has more then plan product count amount , if that then remove extra product from cart
        $subscription_items = $cart->items()->where('purchase_option_type', 'subscription')->get()->pluck('quantity')->toArray();

        if ($plan->product_count < array_sum($subscription_items)) {
            $remove_amount = array_sum($subscription_items) - $plan->product_count;
            $remove_items = $cart->items()->where('purchase_option_type', 'subscription')->take($remove_amount)->get();
            foreach ($remove_items as $key => $item) {
                $item->delete();
            }
        }
        // check subscription is items has more then plan product count amount , if that then remove extra product from cart  END

        if ($cart->subscribe_items < 1) {

            $check_queue_items = $user->queues()->where('year', $year)->where('month', $month)->with('items')->first();

            $queue_items = $queue_items_count->items_count ?? 0;

            if ($queue_items > 0) {

                foreach ($check_queue_items->items as $key => $item) {

                    $get_product = Product::where('id', $item->product_id)->first();
                    $purchase_option = $get_product->purchase_options()->where('type', 'subscription')->first();

                    $cart->items()->create([
                        'cart_id' => $cart->id,
                        'product_id' => $item->product_id,
                        'purchase_option_id' => $purchase_option ? $purchase_option->id : null,
                        'product_title' => $get_product->title ?? null,
                        'product_image' => $get_product->image ? $get_product->image['thumb_url'] : null,
                        'purchase_option_type' => 'subscription',
                        'amount' => $plan->total_price,
                        'quantity' => 1,
                        'subtotal' => $plan->total_price,
                    ]);

                    // if ($item->purchase_option_type == 'subscription') {
                    //     array_push($product_ids, $item->product_id);
                    // }
                }

                // UPDATE DATA ACCORDING SUBS ITEM PRICE
                $subs_items = $cart->items()->where('purchase_option_type', 'subscription')->get();

                if ($subs_items->count() > 1) {
                    foreach ($subs_items as $key => $subs_item) {
                        $subs_item->update([
                            'amount' => $plan?->price_par_product ?? 0,
                            'subtotal' => $plan?->price_par_product ?? 0
                        ]);
                    }
                }
                // UPDATE DATA ACCORDING SUBS ITEM PRICE END

            } else {

                //
                // return redirect('/')->withStatus('There are no products in your cart available for subscription.');
            }
        }

        $product_ids = [];
        foreach ($cart->items as $key => $item) {
            if ($item->purchase_option_type == 'subscription') {
                array_push($product_ids, $item->product_id);
            }
        }

        $subscribe_items = Product::whereIn('id', $product_ids)->get();

        // product add to auth user queue for current month END

        $check_sub = DB::table('subscriptions')->where('user_id', auth()->id())->first();

        $first_time_subscribe = false;
        $total_price = $plan->total_price ?? 0;

        $setting = Settings::first();

        if (is_null($check_sub) && $setting?->first_month_subscribe_discount_status) {

            $plans = json_decode($plan, true);


//            $originalAmount = $plan->price_par_product;
            $totalAmount = $plan->total_price;
            $discountedAmount = $setting?->first_month_subscribe_discount_percentage;

            // Convert the percentage to a decimal representation
            // $discountFactor = $discountPercentage / 100;

            // Calculate the discounted amount
            // $discountedAmount = $originalAmount * $discountFactor;

            $resultAmount = $totalAmount - $discountedAmount;


            $plans['original_price'] = $plan->total_price;
            $plans['total_price'] = $resultAmount;
            $plan = (object)$plans;
            $first_time_subscribe = true;
        } else {
            $plans = json_decode($plan, true);
            $plans['original_price'] = $plan->total_price;
            $plans['total_price'] = $plan->total_price;
            $plan = (object)$plans;
            $first_time_subscribe = false;
        }

        $coup = null;
        if (cache()->has('subscribe-extra-coupon-' . auth()->id())) {
            $coup = cache()->get('subscribe-extra-coupon-' . auth()->id());
        }

        $stripePublicKey = config('services.stripe.key');
        /* @var User $user */
        $user = auth()->user();

        $last_queue = $user->queues()->with(['items' => function ($q) {
            $q->with(['product' => function ($q2) {
                $q2->with('brand');
            }]);
        }])->whereHas('items')->where('year', $year)->where('month', $month)->orderBy('id')->first();

        $intent_client_secret = $user->createSetupIntent()->client_secret;

        $some_latest_products = Product::latest()->with('brand')->limit(20)->get();

        // finally cart cal
        $full_cart = $user->cart()->with('items')->first();
        (new CartItemController())->recalculateCartAndCoupon($full_cart, false, $select_plan);

        // if not subscribed then add subscribe item in card end
        $month_name = Carbon::now()->format('F');
        $order=Order::where('user_id', $user->id)->latest()->first();
        if ($order){
            $shipping_addresses = OrderAddress::where('order_id', $order->id)->get();
        }else{
            $shipping_addresses = $user->addresses()->where('type', 'shipping')->get();
        }
        $gateways = Gateway::query()->select(['id', 'name', 'image'])->get();
        $user_cart = $user->cart()->with('items')->first();
        $user_with_cart = User::with('cart.items.product.brand')->where('id', auth()->id())->first();
        $item_count = $user_cart->items->count();

        return inertia('User/Subscribe', compact(
            'plan',
            'countries',
            'states',
            'stripePublicKey',
            'intent_client_secret',
            'coup',
            'last_queue',
            'shipping_addresses',
            'gateways',
            'some_latest_products',
            'month',
            'first_time_subscribe',
            'total_price',
            'subscribe_items',
            'month_name',
            'user_cart',
            'user_with_cart',
            'all_plans',
            'select_plan'
        ))
            ->title(__('Subscribe'));
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

    // resubscription
    // function resubscribe($select_plan = null)
    // {
    //     // if plan come from frontend
    //     if ($select_plan) {
    //         // check plan is exist
    //         $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('id', $select_plan)->first();
    //         if (!$plan) {
    //             $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('is_default', true)->first();
    //         }
    //     } else {
    //         $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('is_default', true)->first();
    //     }

    //     // get plan list to show list
    //     $all_plans = Plan::query()->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->get();

    //     $countries = config('countries');
    //     $states = config('states');
    //     $user = auth()->user('web');

    //     $month = (int)date('n');
    //     $year = date('Y');

    //     // for downgrade condition added
    //     if ($queue_items_count = $user->queues()->where('year', $year)->where('month', $month)->withCount('items')->first()) {

    //         if ($queue_items_count && $plan?->product_count < $queue_items_count->items_count) {
    //             return redirect()->back()->withQueue('Your queue has more than ' . $plan?->product_count . ' product!
    //             <br>
    //             Please remove the extra product and try again!');
    //         }
    //     }
    //     // for downgrade condition added

    //     // product add to auth user queue for current month
    //     $cart = $user->cart()->with('items')->first();

    //     // check subscription is items has more then plan product count amount , if that then remove extra product from cart
    //     $subscription_items = $cart->items()->where('purchase_option_type', 'subscription')->get()->pluck('quantity')->toArray();

    //     if ($plan->product_count < array_sum($subscription_items)) {
    //         $remove_amount = array_sum($subscription_items) - $plan->product_count;
    //         $remove_items = $cart->items()->where('purchase_option_type', 'subscription')->take($remove_amount)->get();
    //         foreach ($remove_items as $key => $item) {
    //             $item->delete();
    //         }
    //     }
    //     // check subscription is items has more then plan product count amount , if that then remove extra product from cart  END

    //     if ($cart->subscribe_items < 1) {

    //         $check_queue_items = $user->queues()->where('year', $year)->where('month', $month)->with('items')->first();

    //         $queue_items = $queue_items_count->items_count ?? 0;

    //         if ($queue_items > 0) {

    //             foreach ($check_queue_items->items as $key => $item) {

    //                 $get_product = Product::where('id', $item->product_id)->first();
    //                 $purchase_option = $get_product->purchase_options()->where('type', 'subscription')->first();

    //                 $cart->items()->create([
    //                     'cart_id' => $cart->id,
    //                     'product_id' => $item->product_id,
    //                     'purchase_option_id' => $purchase_option ? $purchase_option->id : null,
    //                     'product_title' => $get_product->title ?? null,
    //                     'product_image' => $get_product->image ? $get_product->image['thumb_url'] : null,
    //                     'purchase_option_type' => 'subscription',
    //                     'amount' => $plan->total_price,
    //                     'quantity' => 1,
    //                     'subtotal' => $plan->total_price,
    //                 ]);

    //                 // if ($item->purchase_option_type == 'subscription') {
    //                 //     array_push($product_ids, $item->product_id);
    //                 // }
    //             }

    //             // UPDATE DATA ACCORDING SUBS ITEM PRICE
    //             $subs_items = $cart->items()->where('purchase_option_type', 'subscription')->get();

    //             if ($subs_items->count() > 1) {
    //                 foreach ($subs_items as $key => $subs_item) {
    //                     $subs_item->update([
    //                         'amount' => $plan?->price_par_product ?? 0,
    //                         'subtotal' => $plan?->price_par_product ?? 0
    //                     ]);
    //                 }
    //             }
    //             // UPDATE DATA ACCORDING SUBS ITEM PRICE END

    //         } else {

    //             //
    //             // return redirect('/')->withStatus('There are no products in your cart available for subscription.');
    //         }
    //     }

    //     $product_ids = [];
    //     foreach ($cart->items as $key => $item) {
    //         if ($item->purchase_option_type == 'subscription') {
    //             array_push($product_ids, $item->product_id);
    //         }
    //     }

    //     $subscribe_items = Product::whereIn('id', $product_ids)->get();

    //     // product add to auth user queue for current month END

    //     $check_sub = \DB::table('subscriptions')->where('user_id', auth()->id())->first();

    //     $first_time_subscribe = false;
    //     $total_price = $plan->total_price ?? 0;

    //     $setting = Settings::first();

    //     if (is_null($check_sub) && $setting?->first_month_subscribe_discount_status) {

    //         $plans = json_decode($plan, true);

    //         $originalAmount = $plan->total_price;

    //         $plans['original_price'] = $plan->total_price;
    //         $price = $plan->total_price - 9.99; // minus 9.99
    //         $plans['total_price'] = $price;
    //         $plan = (object)$plans;
    //         $first_time_subscribe = true;

    //     }else{
    //         $plans = json_decode($plan, true);
    //         $plans['original_price'] = $plan->total_price;
    //         $plans['total_price'] = $plan->total_price;
    //         $plan = (object)$plans;
    //         $first_time_subscribe = false;
    //     }

    //     $coup = null;
    //     if (cache()->has('subscribe-extra-coupon-' . auth()->id())) {
    //         $coup = cache()->get('subscribe-extra-coupon-' . auth()->id());
    //     }

    //     $stripePublicKey = config('cashier.key');
    //     /* @var User $user */
    //     $user = auth()->user();

    //     $last_queue = $user->queues()->with(['items' => function ($q) {
    //         $q->with(['product' => function ($q2) {
    //             $q2->with('brand');
    //         }]);
    //     }])->whereHas('items')->where('year', $year)->where('month', $month)->orderBy('id')->first();

    //     $intent_client_secret = $user->createSetupIntent()->client_secret;

    //     $some_latest_products = Product::latest()->with('brand')->limit(20)->get();

    //     // finally cart cal
    //     $full_cart = $user->cart()->with('items')->first();
    //     (new CartItemController())->recalculateCartAndCoupon($full_cart, false, $select_plan);

    //     // if not subscribed then add subscribe item in card end
    //     $month_name = Carbon::now()->format('F');
    //     $shipping_addresses = $user->addresses()->where('type', 'shipping')->get();
    //     $gateways = Gateway::query()->select(['id', 'name', 'image'])->get();
    //     $user_cart = $user->cart()->with('items')->first();
    //     $user_with_cart = User::with('cart.items.product.brand')->where('id', auth()->id())->first();

    //     return inertia('User/ReSubscribe', compact(
    //         'plan',
    //         'countries',
    //         'states',
    //         'stripePublicKey',
    //         'intent_client_secret',
    //         'coup',
    //         'last_queue',
    //         'shipping_addresses',
    //         'gateways',
    //         'some_latest_products',
    //         'month',
    //         'first_time_subscribe',
    //         'total_price',
    //         'subscribe_items',
    //         'month_name',
    //         'user_cart',
    //         'user_with_cart',
    //         'all_plans',
    //         'select_plan'
    //     ))
    //         ->title(__('ReSubscribe'));
    // }

    function personalUpgradeDetails(Request $request)
    {
        /* @var User $user */
        $user = $request->user();
        $balance = $user->balance();
        $effectDate = Carbon::createFromTimestamp($user->subscription('personal')->asStripeSubscription()->current_period_end)->format('M d');
        return response()->json(compact('balance', 'effectDate'));
    }

    function subscribeCouponCheck(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);
        $user = $request->user();
        if ($coupon = $this->couponIsValid($user, $request->code)) {
            cache()->put('subscribe-extra-coupon-' . $user->id, $coupon);
            return redirect()->back();
        }
        throw ValidationException::withMessages(['code' => __('Invalid Coupon')]);
    }

    function subscribeCouponRemove(Request $request)
    {
        $user = $request->user();
        cache()->forget('subscribe-extra-coupon-' . $user->id);
        return redirect()->back();
    }

    function subscribeStore(Request $request)
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
            'payment_method' => 'required',
            'plan' => 'required',
        ]);

        /* @var User $user */
        $user = $request->user();
        $cart = $user->cart()->with('items')->first();

        // update user name
        $this->setName($user, $request->name);

        $month = date('n'); // current month
        $year = date('Y'); // current year

        $check_queue_is_exist = $user->queues()->where('year', $year)->where('month', $month)->first();
        if (!$check_queue_is_exist) {
            $user->queues()->create([
                'month' => $month,
                'year' => $year
            ]);
        }

        $queue = $user->queues()->where('year', $year)->where('month', $month)->first();
        foreach ($queue->items as $key => $item) {
            $item->delete();
        }
        $is_purchase_from_subscription = false;
        foreach ($cart->items as $key => $item) {
            if ($item->purchase_option_type == 'subscription') {
                $queue->items()->create([
                    'queue_id' => $queue->id,
                    'product_id' => $item->product_id,
                    'addedBy_type' => 'App\Models\User',
                    'addedBy_id' => $user->id
                ]);
                $is_purchase_from_subscription = true;
            }
        }

        // check product is available in user queue for this month with calculate plan product qty


        if( Session::get('select_plan')){
            $select_plan=Session::get('select_plan');

            $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('id', $select_plan)->first();
        }else{
            $plan = Plan::query()->with('autoCoupon')->where('stripe_id', $request->plan)->firstOrFail();
        }
        if($plan->product_count == 1){
            /* @var CartItem|null $existsItem */
            if ($existsItem = $cart->items->sortByDesc('id')->first()) {
                    $params = [];
                    $params['quantity'] = $plan->product_count;
                    $params['amount'] = $plan->product_count * $plan->price_par_product;
                    $params['subtotal'] = $plan->total_price;
                    $res = $existsItem->update($params);
            }

        }
        // $check_queue = $user->queues()->where('year', $year)->where('month', $month)->first();

        // if ($check_queue) {
        //     $items_count = $check_queue->items()->count();

        //     if ($items_count < $plan->product_count) {
        //         $need_product = $plan->product_count - $items_count;
        //         return redirect()->back()->withStatus('Please add ' . $need_product . ' more product to your cart for this month.');
        //     }
        // } else {
        //     return redirect()->back()->withStatus('Please add product to your cart for this month.');
        // }
        // check product is available in user queue for this month with calculate plan product qty END

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


                $subscriptionBuilder = $user->newSubscription('personal', $request->plan);

                $shipping_cost = config('misc.default_shipping');

                if($shipping_cost > 0){
                    if (!$user->stripe_id) {
                        $user->createOrGetStripeCustomer();
                    }
                    Cashier::stripe()->invoiceItems->create([
                        'customer' => $user->stripe_id,
                        'amount' => $shipping_cost * 100,
                        'currency' => 'usd',
                        'description' => 'Shipping Charge',
                    ]);
                }


                // apply 50% Off coupon
                $check_sub = \DB::table('subscriptions')->where('user_id', $user->id)->first();
                $setting = Settings::first();

                if (is_null($check_sub) && $setting?->first_month_subscribe_discount_status) {

                    // $check_coupon_is_exist = Coupon::where('code', '50% Off')->domain(getCurrentDomain())->first();

                    // if (!$check_coupon_is_exist) {
                    //     (new CouponService())->fiftyPercentOffCoupon();
                    // }
                    // $get_coupon = Coupon::where('code', '50% Off')->domain(getCurrentDomain())->first();
                     $get_coupon = Coupon::latest()->first();
                     $subscriptionBuilder->withCoupon($get_coupon->strip_coupon);
                }
                // apply 50% Off coupon END

                if (isset($coup) && $coup instanceof Coupon) {
                    $subscriptionBuilder->withCoupon($coup->strip_coupon);
                }
                $subscription = $subscriptionBuilder->create($request->payment_method);
                 // Retrieve the latest invoice for this subscription
                 $invoice = $subscription->latestInvoice();

                 // Get the PaymentIntent ID (transaction ID)
                 $paymentIntentId = $invoice->payment_intent;

                 // Retrieve the PaymentIntent details
                 $paymentIntent = $user->findPayment($paymentIntentId);

                 // Get the payment method used for this subscription
                 $paymentMethod = $paymentIntent->payment_method;

                 // Get transaction ID (stripe's PaymentIntent ID)
                 $transactionId = $paymentIntent->id;

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
            session()->flash('subscribed', 'Your subscription successfully added.');
            $user->notify(new SubscriptionAddedNotification($plan));


             // clear subscribe item from cart
             foreach ($cart->items as $key => $item) {
                if ($item->purchase_option_type == 'subscription') {
                    $item->delete();
                }
            }

            Session::forget('first_discount');
            Session::forget('select_plan');

            $message = sprintf(__('Your order has placed successfully'));
            return redirect(route("order"))->with(["success" => $message]);

            // (new CartItemController())->recalculateCartAndCoupon($cart);
            // clear subscribe item from cart


            // | one time order process |
            $cartAgain = $user->cart()->with('items')->firstOrFail();
            if ($cartAgain->items->count() > 0) {

                $shipping = CartItemController::shippingPolicy($cartAgain);
                $shipping_policy_id = null;
                $shipping_cost = config('misc.default_shipping');
                if (isset($shipping['exact']) && $shipping['exact'] instanceof ShippingPolicy) {
                    $shipping_policy_id = $shipping['exact']->id;
                    $shipping_cost = $shipping['exact']->charge;
                }

                try {
                    DB::beginTransaction();
                    /* @var Order $order */
                    $discount = Session::get('first_discount') ?? $cartAgain->discount;
                    $order = Order::create([
                        'user_id' => $user->id,
                        'queue_id' => isset($queue) ? $queue->id : null,
                        'source_type' => Queue::class,
                        'source_id' => isset($queue) ? $queue->id : null,
                        'order_type' => $is_purchase_from_subscription ? 'Subscription' : null,
                        'shipping_policy_id' => $shipping_policy_id,
                        'shipping_cost' => $shipping_cost,
                        'coupon_id' => $cartAgain->coupon_id,
                        'coupon_code' => $cartAgain->coupon_code,
                        'net_total' => $cartAgain->net_total,
                        // 'tax_total' => $cart->tax_total,
                        'discount' => $discount,
                        'policy_discount' => $cartAgain->policy_discount ?? 0,
                        'gross_total' => ($cartAgain->gross_total) + $shipping_cost,
                    ]);
                    $line_items_params = $cartAgain->items->map(function (CartItem $cartItem) {
                        return $cartItem->only(['product_id', 'purchase_option_id', 'product_title', 'product_image', 'purchase_option', 'amount', 'quantity', 'subtotal', 'attrs']);
                    })->toArray();
                    $order->items()->createMany($line_items_params);
                    $order->addresses()->updateOrCreate(['type' => 'shipping'], $request->only(['name', 'email', 'phone', 'country', 'state', 'city', 'line1', 'line2', 'postal_code']));
                    if ($cartAgain->coupon) {
                        event(new CouponUsed($cartAgain->coupon));
                    }
                    DB::commit();
                    Session::forget('first_discount');

                    SubscriptionPaymentController::order($order, $request->gateway_id, ['payment_method' => $request->payment_method],$paymentMethod,$transactionId);

                    $shippingAddress = '';
                    if ($order->addresses) {
                        $shippingAddress = $order->addresses()->where('type', 'shipping')->first();
                    }
                    $user->notify(new NewOrderNotification($order, $shippingAddress));
                    if (checkMailConfig()) {
                        $staffs = Staff::all();
                        foreach ($staffs as $key => $staff) {
                            $staff->notify(new AdminNewOrderNotification($order));
                        }
                    }

                    // data push to klaviyo
                    $this->orderPlaced($order, $user);
                } catch (\Exception $exception) {
                    DB::rollBack();
                }
            }
            // | one time order process end  |

            // user address save process
            try {
                DB::beginTransaction();
                if ($request->address_status == 'edit') {
                    (new OrderController())->addressEditOrSave($request, $user, 'edit');
                }
                // if ($request->address_status == 'add_new') {
                //     (new OrderController())->addressEditOrSave($request, $user, 'add_new');
                // }
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
            }

            // clear subscribe item from cart
            foreach ($cart->items as $key => $item) {
                if ($item->purchase_option_type == 'subscription') {
                    $item->delete();
                }
            }
            Session::forget('select_plan');
            if ($request->show_modal) {

                return redirect()->route('order', ['subscription', 'order' => 'creating', 'show_modal' => 'show_true'])->withSuccess(__('Subscribed Successfully'));
            }
            return redirect()->route('order', ['subscription', 'order' => 'creating'])->withSuccess(__('Subscribed Successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();

            session()->flash('warning_alert', $exception->getMessage());
            return redirect()->back();
        }
    }

    function subscribeUpdate(Request $request)
    {
        $request->validate([
            'stripe_price' => 'required|exists:plans,stripe_id'
        ]);
        /* @var User $user */
        $user = $request->user();
        $subscription = $user->subscription('personal');
        if ($request->stripe_price == $subscription->stripe_price) return abort(404);
        try {
            $user->subscription('personal')->swap($request->stripe_price);
            return redirect()->back()->withSuccess(__('Plan upgraded successfully'));
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }

    private function couponIsValid(User $user, string $code)
    {
        /* @var Coupon $coupon */
        $coupon = Coupon::query()->where('code', $code)->domain(getCurrentDomain())->first();
        if (!$coupon) throw ValidationException::withMessages(['code' => 'Invalid Coupon']);
        return $coupon->isValid(['user_id' => $user->id, 'email' => $user->email]) ? $coupon : null;
    }

    function fragranceCancel(Request $request)
    {
        /* @var User $user */
        $user = $request->user('web');
        $subscription = $user->subscription('personal');
        $asStripe = $subscription->asStripeSubscription();
        $endDate = Carbon::createFromTimestamp(
            $asStripe->current_period_end
        );
        $subscription->cancel();

        if (checkMailConfig()) {
            $social_media = SocialLink::orderBy('order', 'ASC')->get();
            $view = new SubscriptionCancelMail($user, $endDate?->format('d/m/Y'), $social_media);
            Mail::to($user->email)->send($view);
        }

        return redirect()->back()->withSuccess('Will be canceled at ' . $endDate?->format('d M, Y h:i a'));
    }

    function fragranceResume(Request $request)
    {
        /* @var User $user */
        $user = $request->user('web');
        $subscription = $user->subscription('personal');
        if ($subscription->onGracePeriod()) {
            $subscription->resume();
        }
        return redirect()->back()->withSuccess('Subscription resumed successfully');
    }

    /**
     * Upgrade User Subscription From Current Subscription
     */
    public function updateSubscription(Request $request)
    {
        $plan = Plan::domain(getCurrentDomain())->where('stripe_id', $request->plan)->first();
        if (!$plan) {
            session()->flash('status', 'Plan Not Found !');
            return redirect()->back();
        }

        try {
            $user = auth()->user();
            $current_subscription = $user->subscription('personal');

            $current_plan = '';
            $current_plan_product = '';

            if ($current_subscription) {
                $current_plan = Plan::domain(getCurrentDomain())->where('stripe_id', $current_subscription->stripe_price)->first();
            }
            if ($current_plan) {
                $current_plan_product = $current_plan->product_count;
            }

            $text = 'Updated';
            $upgraded = false;
            if ($plan->product_count >= $current_plan_product) {
                $text = 'Upgraded';
                $upgraded = true;
            }
            if ($plan->product_count <= $current_plan_product) {
                $text = 'Downgraded';
            }

            // for downgrade condition added
            $downgrade_status = $this->subscriptionDowngradePolicy($plan->product_count);
            if (!$downgrade_status) {
                return redirect()->back()->withQueue('Your queue has more than ' . $plan->product_count . ' product!
                <br>
                Please remove the extra product and try again!');
            }
            // for downgrade condition added

            // return 222;
            // define upcoming item
            $upcoming_item_price = $plan->stripe_id;

            // define data
            $current_sub = $user->subscription('personal');
            $current_sub_item = $current_sub ? $current_sub->items()->first() : '';
            $current_sub_id = $current_sub ? $current_sub->stripe_id : '';
            $current_item_id = $current_sub_item ? $current_sub_item->stripe_id : '';

            // get stripe credentials

            // 1st update stripe subscription data
            Stripe::setApiKey(config('services.stripe.secret'));
            $sub = Subscription::update($current_sub_id, [
                'items' => [
                    [
                        'id' => $current_item_id,
                        'price' => $upcoming_item_price,
                    ],
                ],
                "proration_behavior" => "none",
            ]);

            // 2nd step update website data
            $current_sub->update([
                'stripe_price' => $upcoming_item_price
            ]);
            $current_sub_item->update([
                'stripe_price' => $upcoming_item_price
            ]);

            $user->notify(new SubscriptionUpdateNotification($plan, $text));
            session()->flash('success', 'Plan Upgraded !');
            if ($upgraded) {
                return redirect()->back()->withSuccessAlert('You will now receive ' . $plan->product_count . ' products per month. <br> Please add ' . $plan->product_count . ' products to your queue!');
            } else {
                return redirect()->back()->withSuccessAlert('Your plan has been successfully downgraded.');
            }
        } catch (\Throwable $th) {
            throw ValidationException::withMessages(['error' => $th->getMessage()]);
        }
    }

    public function subscriptionDowngradePolicy(string $product_count)
    {
        $user = auth()->user();
        $downgrade_status = true;
        $month = Carbon::now()->format('F');
        $year = Carbon::now()->format('Y');

        $queues = $user->queues()
            ->where('year', $year)
            ->withCount('items')->get();
        $re = [];


        foreach ($queues as $key => $queue) {

            $date = $year . '-' . $queue->month . '-05';
            $after_five_date = Carbon::parse($date)->endOfDay();
            $current_day_start = Carbon::now()->endOfDay();
            $after_five_date_time = strtotime($after_five_date);
            $current_day_start_time = strtotime($current_day_start);

            if ($queue->month_name == $month) {
                if ($current_day_start_time < $after_five_date_time) {
                    array_push($re, [
                        'queue->items_count' => $queue->items_count > $product_count,
                        'count' => $product_count,
                    ]);

                    if ($queue->items_count > $product_count) {
                        $downgrade_status = false;
                    }
                }
            } else {
                array_push($re, [
                    'queue->items_count' => $queue->items_count > $product_count,
                    'count' => $product_count,
                ]);

                if ($queue->items_count > $product_count) {
                    $downgrade_status = false;
                }
            }
        }

        return $downgrade_status;
    }
}
