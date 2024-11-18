<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Queue;
use App\Models\Product;
use App\Models\Settings;
use App\Models\QueueItem;
use App\Traits\KlaviyoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class QueueController extends Controller
{
    use KlaviyoTrait;

    /**
     * @throws ValidationException
     */
    function push(Request $request)
    {
        $request->validate([
            'productId' => 'required'
        ]);

        if (auth()->check()) {
            //check product is already exist on user queue
            $user =  auth()->user();
            $check_product_is_exist = $user->queues()->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->productId);
            })->first();

            if ($check_product_is_exist) {
                session()->flash('queue', 'Product is exist on your queue !');
                return redirect()->back();
            }

            // else product not exist do insert
            $month = date('n');
            $year = date('Y');
            $added = true;
            $added_item = '';

            $currentDate = Carbon::now();

            for ($i = 0; $i < 12; $i++) {

                // Get the current month and year
                $current_month = $currentDate->format('m');
                $current_full_month = $currentDate->format('F');
                $year = $currentDate->format('Y');;

                //check queue | if queue not then create new one
                $check_queue = $user->queues()->where('year', $year)->where('month', $current_month)->first();
                if (!$check_queue) {
                    $user->queues()->create([
                        'month' => $current_month,
                        'year' => $year
                    ]);
                }

                // then get queue again with items
                $queue = $user->queues()->where('year', $year)->where('month', $current_month)->first();
                $items = $queue->items()->count();

                // check user plan product qty
                $subscription =  $user->subscription('personal');
                if ($subscription) {
                    $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();
                    $product_count = $plan->product_count ?? 1;
                } else {
                    $product_count = 1;
                }


                // if items 0 then create item and go back or next process

                //and check this month items qty is lower then plan product qty == true ? then create
                if (intval($product_count) != intval($items) && intval($product_count) > intval($items)) {

                    if ($month == $current_month) {
                        if (!$this->checkThisMonthOrderIsCreated()) {
                            $added_item = $queue->items()->create([
                                'queue_id' => $queue->id,
                                'product_id' => $request->productId,
                                'addedBy_type' => 'App\Models\User',
                                'addedBy_id' =>  $user->id,
                            ]);
                            $month_name = $current_full_month;
                            $added = true;
                            break;
                        }
                    } else {
                        $added_item = $queue->items()->create([
                            'queue_id' => $queue->id,
                            'product_id' => $request->productId,
                            'addedBy_type' => 'App\Models\User',
                            'addedBy_id' =>  $user->id,
                        ]);
                        $month_name = $current_full_month;
                        $added = true;
                        break;
                    }
                }

                // else{ // extra added
                //     $added = false;
                // }

                // else run next
                // $added = false;

                // Move to the next month
                $currentDate->addMonth();
            }

            $item = null;

            if ($added && $added_item) {
                $this_item = QueueItem::with(['product', 'queue'])->where('id', $added_item['id'])->first();

                // push data to klaviyo
                if ($this_item?->product) {
                    $this->addToQueue($this_item?->product, $user);
                }

                $item = [
                    'image_url' => $this_item->product?->image['url'] ?? '',
                    'title' => $this_item->product?->title,
                    'month_name' => $this_item?->queue?->month_name,
                    'year' => $this_item?->queue?->year,
                ];

                session()->flash('queue_added', $item);
            } else {
                session()->flash('queue', 'Your queue is full . Product not added!');
            }

            if ($added && $added_item) {
                // cart sync
                $toady_m = now()->format('m');
                $toady_y = now()->format('Y');
                if ($this_item?->queue?->month === $toady_m && $this_item->queue->year === $toady_y) {
                    $this->syncCart($user);
                }
            }

            if ($item !== null && !$request->user()->subscription('personal') || $item !== null && $request->user()?->is_card_denied) {
                return redirect()->route('subscribe');
            }

            return redirect()->back();


            // self::pushProductToQueue($request->productId);
            // return redirect()->back();
        } else {
            // return 343434;
            $tempQueue = [];
            if (session()->has('scentq_queue')) {
                $tempQueue = session()->get('scentq_queue', []);
                if (!is_array($tempQueue)) {
                    $tempQueue = [];
                }
            }
            if (!in_array($request->productId, $tempQueue)) {
                $tempQueue[] = $request->productId;
            }

            $product = Product::where('id', $request->productId)->first();

            $item = [
                'image_url' => $product?->image['url'],
                'title' => $product?->title,
                'month_name' => Carbon::now()->format('F'),
                'year' => Carbon::now()->format('Y'),
            ];

            session()->put('scentq_queue', $tempQueue);

            // session()->flash('queue_added', $item);
            return redirect()->route('register', ['subscribe' => 1]);
        }
    }

    public function syncCart(User $user)
    {
        $toady_m = now()->format('m');
        $toady_y = now()->format('Y');

        $queue = $user->queues()->where('year', $toady_y)->where('month', $toady_m)->with('items')->first();
        $queue_items = $queue->items()->get();

        $cart = $user->cart;

        // remove subs items from cart
        $subs_items = $cart->items()->where('purchase_option_type', 'subscription')->get();
        if ($subs_items) {
            foreach ($subs_items as $key => $item) {
                $item->delete();
            }
        }

        foreach ($queue_items as $key => $queue_i) {

            $product = Product::where('id', $queue_i->product_id)->first();

            $params['product_id'] = $product->id;
            $params['product_title'] = $product->title;
            $params['product_image'] = $product->image ? $product->image['url'] : null;
            $params['purchase_option_type'] = 'subscription';
            $params['quantity'] = 1;

            $item = $cart->items()->create($params);
        }

        // $this->recalculateCartAndCoupon($cart);
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
                $plan = $this->getDefaultPlan();
            }

            $check_sub = \DB::table('subscriptions')->where('user_id', $cart->user_id)->first();

            $setting = Settings::first();

            if (is_null($check_sub) && $setting?->first_month_subscribe_discount_status) {

                $originalAmount = $plan->total_price;
                $discountedAmount = $setting?->first_month_subscribe_discount_percentage;

                // Convert the percentage to a decimal representation
                // $discountFactor = $discountPercentage / 100;

                // Calculate the discounted amount
                // $discountedAmount = $originalAmount * $discountFactor;

                // Subtract the discount from the original amount
                $resultAmount = $originalAmount - $discountedAmount;

                $subscription_first_disc = $resultAmount ?? 0;
                $plan_total_price = $plan->total_price;
            } else {
                $plan_total_price = $plan->total_price;
                $subscription_first_disc =  $plan->total_price;
            }
        }

        $params['net_total'] = $net_total + $plan_total_price;
        $params['gross_total'] = $gross_total + $subscription_first_disc;

        // dd($params);
        unset($params['shipping']);
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

    function pushCustom(Request $request, $toastr = true)
    {
        $request->validate([
            'productId' => 'required',
            'month' => 'required',
            'year' => 'required',
        ]);

        DB::beginTransaction();
        try {
            if (auth()->check()) {
                // check product is already exist on user queue
                $user =  auth()->user();

                // // else product not exist do insert
                $convert = date_parse($request->month);
                $month = $convert['month'];
                $year = $request->year;

                // then get queue again with items
                $queue = $user->queues()->where('year', $year)->where('month', $month)->first();

                if (!$queue) {
                    $user->queues()->create([
                        'month' => $month,
                        'year' => $year
                    ]);
                }

                $queue = $user->queues()->where('year', $year)->where('month', $month)->first();

                $items = $queue->items()->count();
                // check user plan product qty
                $subscription =  $user->subscription('personal');
                if ($subscription) {
                    $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();
                    $product_count = $plan->product_count ?? 1;
                } else {
                    $product_count = 1;
                }

                // return $items;
                //and check this month items qty is lower then plan product qty == true ? then create
                if (intval($product_count) <= intval($items)) {
                    session()->flash('queue', 'Product not added !');
                    return redirect()->back();
                }

                //check product is already exist on user queue
                $check_product_is_exist = $user->queues()->whereHas('items', function ($q) use ($request) {
                    $q->where('product_id', $request->productId);
                })->first();

                if ($check_product_is_exist) {
                    session()->flash('queue', 'Product is exist on your queue !');
                    return redirect()->back();
                }

                //check queue | if queue not then create new one
                $check_queue = $user->queues()->where('year', $year)->where('month', $month)->first();
                if (!$check_queue) {
                    $user->queues()->create([
                        'month' => $month,
                        'year' => $year
                    ]);
                }

                // then get queue again with items
                $queue = $user->queues()->where('year', $year)->where('month', $month)->first();

                $added_item = $queue->items()->create([
                    'queue_id' => $queue->id,
                    'product_id' => $request->productId,
                    'addedBy_type' => 'App\Models\User',
                    'addedBy_id' =>  $user->id,
                ]);

                $this_item = QueueItem::with(['product', 'queue'])->where('id', $added_item['id'])->first();

                $product_added_into_order = $this->pushProductIntoOrder($user, $year, $month, $request->productId);

                DB::commit();

                if ($product_added_into_order) {
                    session()->flash('success_alert', 'The product is locked exclusively for your order #' . $product_added_into_order->order_no . ' in ' . ucfirst($request->month) . '.');
                } else {

                    $item = [
                        'image_url' => $this_item->product?->image['url'],
                        'title' => $this_item->product?->title,
                        'month_name' => $this_item?->queue?->month_name,
                        'year' => $this_item?->queue?->year,
                    ];

                    session()->flash('queue_added', $item);
                }

                // cart sync
                $toady_m = now()->format('m');
                $toady_y = now()->format('Y');


                if (number_format($this_item?->queue?->month) == number_format($toady_m) && $this_item->queue->year == $toady_y) {
                    $this->syncCart($user);
                }

                if ($request->has('from') && $request->from != null && $request->from == 'order') {
                    return redirect()->route('order', ['subscription']);
                }

                // push data to klaviyo
                if ($this_item?->product) {
                    $this->addToQueue($this_item?->product, $user);
                }

                return redirect()->back();
            } else {
                $tempQueue = [];
                if (session()->has('scentq_queue')) {
                    $tempQueue = session()->get('scentq_queue', []);
                    if (!is_array($tempQueue)) {
                        $tempQueue = [];
                    }
                }
                if (!in_array($request->productId, $tempQueue)) {
                    $tempQueue[] = $request->productId;
                }
                session()->put('scentq_queue', $tempQueue);
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('warning_alert', $th->getMessage());
            return back();
        }
    }

    public function pushProductIntoOrder($user, $year, $month, $product_id)
    {
        $date =  Carbon::parse('01-' . $month . '-' . $year)->startOfMonth();
        $emptyStatus = (new HomeController())->checkSubscriptionOrderIsEmpty($user, $date);

        if ($emptyStatus) {

            $subscription_order = $user->orders()
                ->whereMonth('created_at', $date)
                ->whereNotNull('queue_id')
                ->first();

            if ($subscription_order) {

                $get_plan = $user->subscription('personal');
                if ($get_plan && $get_plan->stripe_price) {

                    $plan = Plan::where('stripe_id', $get_plan->stripe_price)->first();
                    $product =  Product::where('id', $product_id)->first();

                    if ($plan && $product) {

                        $dd = $subscription_order->items()->create([
                            'product_id' => $product_id,
                            'purchase_option_id' => null,
                            'product_title' => $product->title ?? '',
                            'product_image' => $product->image['url'] ?? '',
                            'purchase_option' => null,
                            'amount' => $plan ? $plan->price_par_product : $product->additional_price ?? 0,
                            'subtotal' => $plan ? $plan->price_par_product : $product->additional_price ?? 0,
                            'quantity' => 1,
                            'additional_price' => ''
                        ]);
                        return $subscription_order;
                    }
                }
            }
        }

        return false;
    }

    function pop(Request $request, QueueItem $queueItem)
    {
        $user = $request->user();
        QueueItem::query()->whereHas('queue', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('id', $queueItem->id)->whereNotNull('addedBy_type')->delete();
        return $queueItem;
    }

    function destroy(Request $request, QueueItem $queueItem)
    {
        $user = $request->user();

        try {
            // check this exist on cart
            $cart = $user->cart;
            $subs_items = $cart->items()->where('purchase_option_type', 'subscription')->where('product_id', $queueItem->product_id)->first();
            if ($subs_items) {
                $subs_items->delete();
            }


            QueueItem::query()->whereHas('queue', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('id', $queueItem->id)->whereNotNull('addedBy_type')->delete();

            $subs_items_more = $cart->items()->where('purchase_option_type', 'subscription')->where('product_id', $queueItem->product_id)->get();
            if(is_null($subs_items_more) ||$subs_items_more->isEmpty()){
                $cart->delete();
            }

            return back();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function convertMonth($value)
    {
        $full_month = date_parse($value);
        $month = $full_month['month'];

        return $month;
    }

    function sort(Request $request)
    {
        $user = auth()->user();

        // Validate the request
        $request->validate([
            'from_month' => 'required',
            'from_year' => 'required',
            'replace_id' => 'required',
            'to_month' => 'required',
            'to_year' => 'required',
            'item_id' => 'required',
        ]);

        $from_queue = $user->queues()->where('year', $request->from_year)->where('month', $this->convertMonth($request->from_month))->first();
        $to_queue = $user->queues()->where('year', $request->to_year)->where('month', $this->convertMonth($request->to_month))->first();

        // Check if queues exist
        if (!$from_queue || !$to_queue) {
            return response()->json(['error' => 'Invalid queue or year/month.'], 400);
        }

        $from_item = QueueItem::findOrFail($request->replace_id);
        $to_item = QueueItem::findOrFail($request->item_id);

        try {
            // Update queue IDs for swapping
            $from_item->update(['queue_id' => $from_queue->id]);
            $to_item->update(['queue_id' => $to_queue->id]);

            session()->flash('status', 'Queue updated.');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Add to queue from subscribe page
     * @param Object $request
     */
    function addToQueueFromSub(Request $request)
    {
        $year = date('Y');
        $month = $request->to_month;

        $plan = Plan::where('type', 'personal')->where('is_default', true)->domain(getCurrentDomain())->first();
        if ($plan) {
            $product_count = $plan->product_count;
        } else {
            $product_count = 1;
        }

        // count old items
        $old_queue_count = auth()->user()->queues()->where('year', $year)->where('month', $month)->first();

        if ($request->remove_id) {
            $old_item_check = QueueItem::where('id', $request->remove_id)->first();
            if ($old_item_check) {
                $old_item_check->delete();
            }
        }

        if ($old_queue_count) {

            $old_queue_items_count = $old_queue_count->items()->count();
            if ($old_queue_items_count) {
                if (intval($product_count) <= intval($old_queue_items_count)) {
                    session()->flash('status', 'Please remove item from your queue to add new item.');
                    return back();
                }
            }
        }

        // insert
        $queue = auth()->user()->queues()->where('year', $year)->where('month', $month)->first();
        if (!$queue) {

            $new_queue = auth()->user()->queues()->create([
                'month' => $month,
                'year' => Carbon::now()->format('Y')
            ]);
            $new_queue->items()->create([
                'queue_id' => $new_queue->id,
                'product_id' => $request->item_id,
                'addedBy_type' => 'App\Models\User',
                'addedBy_id' =>  auth()->id()
            ]);
        } else {
            $queue->items()->create([
                'queue_id' => $queue->id,
                'product_id' => $request->item_id,
                'addedBy_type' => 'App\Models\User',
                'addedBy_id' =>  auth()->id()
            ]);
        }

        session()->flash('status', 'Queue updated.');
        return redirect()->back();
    }

    static function pushProductToQueue($productId)
    {
        /* @var User $user */
        $user = auth()->user();

        $cyear_now = (float)date('Y') + ((float)date('n') / 12);

        $existsIn6Month = $user->queues()->whereHas('items', function ($q) use ($productId) {
            $q->where('product_id', $productId)->whereNotNull('addedBy_type');
        })->whereRaw('(' . $cyear_now . '-(year+(month/12))) <= (6/12)')->exists();


        if ($existsIn6Month) {
            throw ValidationException::withMessages(['exists' => true]);
        }

        $maxCountAllowed = 1;
        if ($user->subscribed('personal')) {
            $subscription = $user->subscription('personal');
            $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();
            $maxCountAllowed = $plan->product_count;
        }

        $currentCalculatedMonth = (float)date('Y') + ((float)date('n') / 12);

        // Check Existing Months
        $existingMonth = $user->queues()->whereDoesntHave('order')->withCount(['items' => function ($q) {
            /* @var Builder $q */
            $q->whereNotNull('addedBy_type');
        }])->having('items_count', '<', $maxCountAllowed)->first();

        $existingMonthCalculatedMonth = $existingMonth ? ($existingMonth->year + ($existingMonth->month / 12)) : 0;

        if ($existingMonth && $currentCalculatedMonth <= $existingMonthCalculatedMonth) {
            $existingMonth->items()->create([
                'product_id' => $productId,
                'addedBy_type' => get_class($user),
                'addedBy_id' => $user->id,
            ]);
            $result = $existingMonth;
        } else {
            /* @var Queue $lastItem */
            $lastItem = $user->queues()->whereDoesntHave('order')->withCount(['items' => function ($q) {
                /* @var Builder $q */
                $q->whereNotNull('addedBy_type');
            }])->orderByDesc('id')->first();

            $lastItemCalculatedMonth = $lastItem ? ($lastItem->year + ($lastItem->month / 12)) : 0;

            if ($lastItem && $currentCalculatedMonth <= $lastItemCalculatedMonth) {
                if ($lastItem->items_count < $maxCountAllowed) {
                    $lastItem->items()->create([
                        'product_id' => $productId,
                        'addedBy_type' => get_class($user),
                        'addedBy_id' => $user->id,
                    ]);
                    $result = $lastItem;
                } else {
                    // Add New Queue
                    $newMonth = $lastItem->month + 1;
                    $year = $lastItem->year;
                    if ($newMonth > 12) {
                        $newMonth = $newMonth - 12;
                        $year++;
                    }
                    try {
                        DB::beginTransaction();
                        /* @var Queue $queue */
                        $queue = $user->queues()->create([
                            'month' => $newMonth,
                            'year' => $year,
                        ]);
                        $queue->items()->create([
                            'product_id' => $productId,
                            'addedBy_type' => get_class($user),
                            'addedBy_id' => $user->id,
                        ]);
                        DB::commit();
                        $result = $queue;
                    } catch (\Exception $exception) {
                        DB::rollBack();
                        throw ValidationException::withMessages(['error' => $exception->getMessage()]);
                    }
                }
            } else {
                try {
                    DB::beginTransaction();
                    $today = today();
                    /* @var Queue $queue */
                    $queue = $user->queues()->create([
                        'month' => $today->format('n'),
                        'year' => $today->format('Y'),
                    ]);
                    $queue->items()->create([
                        'product_id' => $productId,
                        'addedBy_type' => get_class($user),
                        'addedBy_id' => $user->id,
                    ]);
                    DB::commit();
                    $result = $queue;
                } catch (\Exception $exception) {
                    DB::rollBack();
                    throw ValidationException::withMessages(['error' => $exception->getMessage()]);
                }
            }
        }

        if ($result->items()->whereNotNull('addedBy_type')->count() == $maxCountAllowed) {
            $newMonth = $result->month + 1;
            $year = $result->year;
            if ($newMonth > 12) {
                $newMonth = $newMonth - 12;
                $year++;
            }
            if (!$user->queues()->where('month', $newMonth)->where('year', $year)->exists()) {
                $user->queues()->create([
                    'month' => $newMonth,
                    'year' => $year,
                ]);
            }
        }
        $image = null;
        $product = Product::find($productId);
        if ($product && is_array($product->images)) {
            $image = $product->images[0]['thumb_url'];
        }
        session()->flash('queue', ['date' => [$result->month, $result->year], 'image' => $image]);
        return [$result->month, $result->year];
    }

    static function pushProductBySystem(User $user, $productId)
    {
        if ($productId) {
            /* @var Queue $lastQueue */
            $lastQueue = $user->queues()->whereDoesntHave('order')->orderByDesc('id')->first();
            $currentCalculatedMonth = (float)date('Y') + ((float)date('n') / 12);
            $lastQueueCalculatedMonth = $lastQueue ? ($lastQueue->year + ($lastQueue->month / 12)) : 0;

            if ($lastQueue && $currentCalculatedMonth <= $lastQueueCalculatedMonth) {
                $lastQueue->items()->create([
                    'product_id' => $productId
                ]);
            } else {
                try {
                    DB::beginTransaction();
                    $today = today();
                    /* @var Queue $queue */
                    $queue = $user->queues()->create([
                        'month' => $today->format('n'),
                        'year' => $today->format('Y'),
                    ]);
                    $queue->items()->create([
                        'product_id' => $productId
                    ]);
                    DB::commit();
                } catch (\Exception $exception) {
                    DB::rollBack();
                    throw ValidationException::withMessages(['error' => $exception->getMessage()]);
                }
            }
        }
    }

    public function checkThisMonthOrderIsCreated()
    {
        $user = auth()->user();
        $order = $user->orders()
            ->whereNotNull('queue_id')
            ->whereMonth('created_at', Carbon::now()->month)
            ->first();
        if ($order) {
            return true;
        } else {
            return false;
        }
    }
}
