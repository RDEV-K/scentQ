<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Plan;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Settings;
use App\Traits\KlaviyoTrait;
use Illuminate\Http\Request;
use App\Models\PurchaseOption;
use App\Models\ShippingPolicy;
use App\Models\QueuePurchasePolicy;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Session;

class CartItemController
{
    use KlaviyoTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function index(Request $request)
    {
        /* @var User $user */
        $user = $request->user();
        $cart = Cart::query()->with('items')->firstOrCreate(['user_id' => $user->id]);
        self::shippingPolicy($cart);
        return $cart;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Cart
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'attrs' => 'nullable|array',
            'attrs.*' => 'required|string',
        ]);

        /* @var Product $product */
        $product = Product::findOrFail($request->product_id);
        if ($product->type != 'giftset') {
            $request->validate([
                'purchase_option_id' => 'required|exists:purchase_options,id',
            ]);
            /* @var PurchaseOption $purchase_option */
            $purchase_option = $product->purchase_options()->findOrFail($request->purchase_option_id);
        } else {
            $purchase_option = null;
        }

        // if form has replaceItem then find the item and delete
        if ($request->has('replaceItem') && $request->replaceItem !== null) {
            $cartItem = CartItem::where('id', $request->replaceItem)->first();
            if ($cartItem) {
                $cartItem->delete();
            }
        }

        /* @var User $user */
        $user = $request->user();
        /* @var Cart $cart */
        $cart = Cart::query()->with('items')->firstOrCreate(['user_id' => $user->id]);

        // replace product
        $replace_product = session()->get('replace_product');
        if ($replace_product) {
            $get_cart_product = $cart->items()->where('product_id', $replace_product)->where('purchase_option_type', 'subscription')->first();
            if ($get_cart_product) {
                $get_cart_product->delete();
                session()->forget('replace_product');
            }
        }
        // replace product end

        if ($cart->items->count() && $cart->items[0]?->special) {
            $cart->delete();
            $cart = $user->cart()->firstOrCreate([]);
        }

        if ($cart->items->count()) {
            // return $cart->items()->where('purchase_option_type');

            $prod_options_ids = $cart->items->pluck('purchase_option_id')->toArray();
            if (count($prod_options_ids) > 0) {
                $purchase_options = PurchaseOption::whereIn('id', $prod_options_ids)->where('type', 'subscription')->get();
                if (count($purchase_options) > 0) {

                    $subscription_items = $cart->items()->where('purchase_option_type', 'subscription')->get()->pluck('quantity')->toArray();
                    $purchase_option = PurchaseOption::where('id', $request->purchase_option_id)->where('type', 'subscription')->first();
                    $product_exist = $cart->items()->where('product_id', $product->id)
                        ->where('purchase_option_id', $request->purchase_option_id)
                        ->where('purchase_option_type', 'subscription')
                        ->first();

                    if ($product_exist) {
                        return redirect()->back()->withStatus("The product you have in your cart is available for subscription!");
                    }
                    if (!is_null($purchase_option)) {

                        // if plan come from frontend
                        if ($request->has('subscribe_plan_type') && $request->subscribe_plan_type !== null) {
                            // check plan is exist
                            $subscription_plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('id', $request->subscribe_plan_type)->first();
                            if (!$subscription_plan) {
                                $subscription_plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('is_default', true)->first();
                            }
                        } else {
                            $subscription_plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('is_default', true)->first();
                        }

                        if ($subscription_plan) {
                            if ($subscription_plan->product_count <= array_sum($subscription_items)) {
                                return redirect()->back()->withStatus("Adding more products is not possible with the current plan you have selected!");
                            }
                        }
                    }
                }
            }
        }

        if ($product->stock != -1 && $product->stock <= 0) {
            throw ValidationException::withMessages(['stock' => 'Not enough stock left']);
        }

        try {

            $purchase_options = PurchaseOption::where('id', $request->purchase_option_id)->where('type', 'subscription')->first();

            /* @var CartItem|null $existsItem */
            if ($existsItem = $cart->items->where('product_id', '==', $product->id)->where('purchase_option_id', '==', $request->purchase_option_id)->first()) {
                if ($request->attrs == $existsItem->attrs) {
                    $params = [];
                    $params['quantity'] = $existsItem->quantity + 1;
                    $params['subtotal'] = $params['quantity'] * $existsItem->amount;
                    // $params['tax'] = round($params['subtotal'] * (($product->tax ?? 0) / 100), config('misc.round')); // tax in percent
                    $res = $existsItem->update($params);
                    if (!$res) throw new \Exception('Unable to add');
                    $this->recalculateCartAndCoupon($cart);
                    return redirect()->back()->withSuccess('Added To Cart');
                }
            }

            $params = $request->only(['product_id', 'purchase_option_id', 'attrs']);
            $params['product_title'] = $product->title;
            $params['product_image'] = $product->image ? $product->image['url'] : null;
            $params['purchase_option'] = $purchase_option?->quantity_text;
            $params['purchase_option_type'] = $purchase_option?->type ?? 'one_time';

            if (!is_null($purchase_options)) {
                // if plan come from frontend
                if ($request->has('subscribe_plan_type') && $request->subscribe_plan_type !== null) {
                    // check plan is exist
                    $subscription_plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('id', $request->subscribe_plan_type)->first();
                    if (!$subscription_plan) {
                        $subscription_plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('is_default', true)->first();
                    }
                } else {
                    $subscription_plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('is_default', true)->first();
                }

                $check_sub = \DB::table('subscriptions')->where('user_id', $user->id)->first();
                // if ($plan->product_count > 1) {
                //     $price = $plan->price_par_product;
                // } else {
                $price = $subscription_plan->total_price;
                // }
                // if(is_null($check_sub)){
                //     $price = $plan->total_price/2;
                // }

                $params['amount'] = $price;
            } else {
                $params['amount'] = $purchase_option?->price ?? $product->additional_price;
                // $params['amount'] = $purchase_option?->price??$product->retail_value;
            }
            $params['quantity'] = $request->quantity ? intval($request->quantity) : 1;
            $params['subtotal'] = $params['quantity'] * $params['amount'];

            // if(is_null($purchase_options)){
            //     $params['tax'] = round($params['subtotal'] * (($product->tax ?? 0) / 100), config('misc.round')); // tax in percent
            // }

            $item = $cart->items()->create($params);

            // UPDATE DATA ACCORDING SUBS ITEM PRICE
            $subs_items = $cart->items()->where('purchase_option_type', 'subscription')->get();

            if ($subs_items->count() > 0) {
                if( Session::get('select_plan')){
                    $select_plan=Session::get('select_plan');

                    $plan = Plan::query()->with(['autoCoupon', 'freeProduct'])->where('id', $select_plan)->domain(getCurrentDomain())->first();
                }else{
                    $plan = Plan::query()->with(['autoCoupon', 'freeProduct'])->where('is_default', true)->domain(getCurrentDomain())->first();
                }


                // remove queue for this month
                $month = now()->format('m');
                $year = now()->format('Y');

                $queue = $user->queues()->where('year', $year)->where('month', $month)->with('items')->first();
                if (!$queue) {
                    $user->queues()->create([
                        'month' => $month,
                        'year' => $year
                    ]);
                }
                if ($queue) {
                    $queue->items()->delete();
                }
                $queue = $user->queues()->where('year', $year)->where('month', $month)->with('items')->first();

                foreach ($subs_items as $key => $subs_item) {
                    $queue_item = $queue->items()->create([
                        'queue_id' => $queue->id,
                        'product_id' => $subs_item->product_id,
                        'addedBy_type' => 'App\Models\User',
                        'addedBy_id' =>  $user->id,
                    ]);

                    $subs_item->update([
                        'amount' => $plan?->price_par_product ?? 0,
                        'subtotal' => $plan?->price_par_product ?? 0
                    ]);
                }
            }
            // UPDATE DATA ACCORDING SUBS ITEM PRICE END

            if (!$item) throw new \Exception('Unable to add');

            $this->recalculateCartAndCoupon($cart);

            // push data to klaviyo
            if ($product) {
                $this->addToCart($product, $user);
            }

            return redirect()->back()->withSuccess('Added To Cart');
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['cart' => $exception->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartItem $cartItem)
    {
        if ($request->quantity == 0) {
            session()->flash('status', 'Please note that the cart amount must be 1');
        }
        /* @var User $user */
        $user = $request->user();
        if ($cartItem->cart->user_id != $user->id) throw new AuthorizationException;
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        try {
            $product = $cartItem->product;
            $params = [];
            $params['quantity'] = $request->quantity;
            $params['subtotal'] = $params['quantity'] * $cartItem->amount;
            // $params['tax'] = round($params['subtotal'] * (($product->tax ?? 0) / 100), config('misc.round')); // tax in percent
            $res = $cartItem->update($params);
            if (!$res) throw new \Exception('Unable to update');
            $this->recalculateCartAndCoupon($cartItem->cart);

            return redirect()->back();
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['cart' => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Cart
     */
    public function destroy(Request $request, CartItem $cartItem)
    {
        /* @var User $user */
        $user = $request->user();
        $cart = $cartItem->cart;

        if ($cart->user_id != $user->id) throw new AuthorizationException;
        try {
            // if item has special discount then remove discount amount
            if ($cartItem->special) {
                $discount_amount = QueuePurchasePolicy::first();
                if ($discount_amount) {
                    $item_price = $cartItem->amount;
                    $discount_amount = ($discount_amount->discount / 100) * $item_price;
                    if ($cartItem->cart) {
                        $minus_amount = $cartItem->cart->policy_discount - $discount_amount;
                        if ($discount_amount) {
                            $cartItem->cart->update([
                                'policy_discount' => $minus_amount,
                            ]);
                        }
                    }
                }
            } // if item has special discount then remove discount amount end
            $res = $cartItem->delete();
            if (!$res) throw new \Exception('Unable to update');
            if (!$cart->items()->count()) {
                $cart->delete();
            } else {
                $this->recalculateCartAndCoupon($cartItem->cart);
            }
            return redirect()->back();
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['cart' => $exception->getMessage()]);
        }
    }

    /**
     * @throws ValidationException
     */
    function attachCoupon(Request $request)
    {
        /* @var User $user */
        $user = $request->user();
        /* @var Cart $cart */
        $cart = Cart::query()->with('items')->where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'code' => 'required|exists:coupons,code'
        ]);

        /* @var Coupon $coupon */
        $coupon = Coupon::query()->where('code', $request->code)->domain(getCurrentDomain())->firstOrFail();

        if (!$this->couponIsValid($cart, $coupon)) {
            return redirect()->back()->withMessages(['error' => 'The selected code is invalid']);
        }
        try {
            $cart->update([
                'coupon_id' => $coupon->id,
                'coupon_code' => $coupon->code,
                'discount' => $this->calculateCouponDiscount($cart, $coupon)
            ]);
            $this->recalculateCartAndCoupon($cart, true);
            return redirect()->back();
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['code' => 'Unable to update']);
        }
    }

    function detachCoupon(Request $request)
    {
        /* @var User $user */
        $user = $request->user();
        /* @var Cart $cart */
        $cart = Cart::query()->with('items')->where('user_id', $user->id)->firstOrFail();
        if (!$cart->coupon) throw ValidationException::withMessages(['coupon' => 'Coupon not found']);

        try {
            $cart->update([
                'coupon_id' => null,
                'coupon_code' => null,
                'discount' => 0
            ]);
            $this->recalculateCartAndCoupon($cart, true);
            return redirect()->back();
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['code' => 'Unable to update']);
        }
    }

    private function couponIsValid(Cart $cart, Coupon $coupon, $net_total = null)
    {
        $net_total = $net_total ?? $cart->net_total;

        return $coupon->isValid([
            'cart' => $cart,
            'user_id' => $cart->user_id,
            'total' => $net_total,
        ]);
    }

    function calculateCouponDiscount(Cart $cart, Coupon $coupon, $net_total = null)
    {
        $net_total = $net_total ?? $cart->net_total;
        $items = $cart->items()->get();
        $couponProducts = $coupon->products()->pluck('products.id')->toArray();
        $cartProducts = $items->pluck('product_id')->toArray();
        if ($coupon->discount_type == 2) {
            $intersection = array_intersect($couponProducts, $cartProducts);
            if (count($intersection) > 0) {
                return $coupon->amount;
            }
        }

        $on = $net_total;
        if (count($couponProducts)) {
            $on = 0;
            /* @var CartItem $item */
            foreach ($items as $item) {
                if (in_array($item->product_id, $couponProducts)) {
                    $on += $item->subtotal;
                }
            }
        }
        $discount = ($on * $coupon->amount) / 100;
        if ($coupon->upto != -1 && is_numeric($coupon->upto)) {
            if ($discount > $coupon->upto) {
                $discount = $coupon->upto;
            }
        }

        if ($discount > $net_total) {
            $discount = $net_total;
        }

        return round($discount, config('misc.round'));
    }

    public static function shippingPolicy(Cart $cart)
    {
        /* @var User $user */
        $user = $cart->user;
        $cartTotal = $cart->net_total;
        return self::calculateShippingPolicy($user, ['total' => $cartTotal]);
    }

    static function calculateShippingPolicy(User $user, $data = [])
    {
        $shippingAddress = $user->addresses->where('type', 'shipping')->first();
        if (!$shippingAddress) return config('misc.default_shipping');
        $cartTotal = $data['total'];
        $shippingPolicies = ShippingPolicy::with('metas')->orderBy('charge', 'asc')->get();
        $maybeEligiblePolicies = $shippingPolicies->filter(function (ShippingPolicy $shippingPolicy) use ($shippingAddress) {
            if (!$shippingPolicy->metas->count()) return true;
            $metaWithCountry = $shippingPolicy->metas->filter(function ($meta) {
                return $meta->name === 'country';
            });
            if (!$metaWithCountry->count()) return true;
            $metaWithMyCountry = $shippingPolicy->metas->filter(function ($meta) use ($shippingAddress) {
                return $meta->name === 'country' && $meta->content === $shippingAddress->country;
            });
            if (!$metaWithMyCountry->count()) return false;
            $metaWithState = $shippingPolicy->metas->filter(function ($meta) {
                return $meta->name === 'state';
            });
            if (!$metaWithState->count()) return true;
            $metaWithMyState = $shippingPolicy->metas->filter(function ($meta) use ($shippingAddress) {
                return $meta->name === 'state' && $meta->content === $shippingAddress->state;
            });
            if (!$metaWithMyState->count()) return false;
            return true;
        });

        $matchable = $maybeEligiblePolicies->filter(function (ShippingPolicy $shippingPolicy) use ($cartTotal) {
            return ($shippingPolicy->minimum_amount == -1 || $shippingPolicy->minimum_amount <= $cartTotal) && ($shippingPolicy->maximum_amount == -1 || $shippingPolicy->maximum_amount >= $cartTotal);
        });
        $exact = isset($matchable[0]) ? $matchable[0] : null;

        $promoable = $maybeEligiblePolicies->filter(function (ShippingPolicy $shippingPolicy) use ($cartTotal, $exact) {
            if ($exact && $exact->charge < $shippingPolicy->charge) return false;
            if ($exact && $exact->id == $shippingPolicy->id) return false;
            return $shippingPolicy->minimum_amount > $cartTotal;
        });
        $promo = isset($promoable[0]) ? $promoable[0] : null;

        return ['exact' => $exact, 'promo' => $promo];
    }

    function recalculateCartAndCoupon(Cart $cart, $skipCoupon = false, $select_plan = null)
    {
        $params = [];
        $net_total = $cart->items()
            ->where(function ($query) {
                $query->where('purchase_option_type', '!=', 'subscription')
                    ->orWhereNull('purchase_option_type');
            })
            ->sum('subtotal');
        // $tax_total = $cart->items()->sum('tax');
        $discount = $cart->discount ?? 0;
        $gross_total = $net_total;
        // $gross_total = $net_total+$tax_total;
        if (!$skipCoupon) {
            $coupon_id = null;
            $coupon_code = null;
            if ($cart->coupon) {
                try {
                    if ($this->couponIsValid($cart, $cart->coupon, $net_total)) { // Check Coupon Is Still Valid
                        $coupon_id = $cart->coupon_id;
                        $coupon_code = $cart->coupon_code;
                        $discount = $this->calculateCouponDiscount($cart, $cart->coupon, $net_total);
                    }
                } catch (\Exception $exception) {
                }
            }
            $params['coupon_id'] = $coupon_id;
            $params['coupon_code'] = $coupon_code;
        }

        $gross_total -= $discount;
        $params['discount'] = $discount;
        if ($cart->policy_discount) {
            $gross_total -= $cart->policy_discount;
        }

        // $params['tax_total'] = $tax_total;

        $check_if_subscription = false;

        foreach ($cart->items()->get() as $item) {
            if ($item->purchase_option_type == 'subscription') {
                $check_if_subscription = true;
            }
        }

        $subscription_first_disc = 0;
        $plan_total_price = 0;

        if ($check_if_subscription) {

            // if plan come from frontend
            if ($select_plan) {
                // check plan is exist
                $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('id', $select_plan)->first();
                if (!$plan) {
                    $plan = $this->getDefaultPlan();
                }
            } else {
                if( Session::get('select_plan')){
                    $select_plan=Session::get('select_plan');

                    $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('id', $select_plan)->first();
                }else{
                    $plan = $this->getDefaultPlan();
                }

            }

            $check_sub = \DB::table('subscriptions')->where('user_id', $cart->user_id)->first();

            $setting = Settings::first();

            if (is_null($check_sub) && $setting?->first_month_subscribe_discount_status) {

//                $originalAmount = $plan->price_par_product;
                $totalAmount = $plan->total_price;
                $discountedAmount = $setting?->first_month_subscribe_discount_percentage;

                // Convert the percentage to a decimal representation
                // $discountFactor = $discountPercentage / 100;

                // Calculate the discounted amount
                // $discountedAmount = $originalAmount * $discountFactor;

                // Subtract the discount from the original amount
                $resultAmount = $totalAmount - $discountedAmount;

                $subscription_first_disc = $resultAmount ?? 0;
                $plan_total_price = $plan->total_price;
                Session::put('first_discount',$discountedAmount);
            } else {
                $plan_total_price = $plan->total_price;
                $subscription_first_disc =  $plan->total_price;
            }
        }

        $params['net_total'] = $net_total + $plan_total_price;
        $params['gross_total'] = $gross_total + $subscription_first_disc;


        $cart->update($params);
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
}
