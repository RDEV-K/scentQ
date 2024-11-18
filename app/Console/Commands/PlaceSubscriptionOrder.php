<?php

namespace App\Console\Commands;

use App\Events\OrderPlaced;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\PaymentController;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Product;
use App\Models\ProductOfTheMonth;
use App\Models\PurchaseOption;
use App\Models\Queue;
use App\Models\QueueItem;
use App\Models\ShippingPolicy;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlaceSubscriptionOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scentq:subscription_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::query()->with([
            'subscriptions',
            'addresses',
            'queues' => function ($q) {
                /* @var Builder $q */
                $q->with(['items' => function ($q2) {
                    /* @var Builder $q2 */
                    $q2->with('product', function ($q3) {
                        $q3->with('purchase_options', function ($q4) {
                            $q4->where('type', 'subscription');
                        });
                    });
                }])->whereDoesntHave('order');
            }
        ])->whereHas('subscriptions')->get();

        /* @var User $user */
        /* @var Carbon $last_ordered_at */
        foreach ($users as $user) {
            $max_count = 1;
            $last_order = $user->orders()->whereNotNull('queue_id')->orderByDesc('id')->first();
            if ($user->subscribed('personal')) {
                $subscription = $user->subscription('personal');
                $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();
                if ($plan) {
                    $max_count = $plan->product_count;
                }
                if ($last_order) {
                    $last_ordered_at = $last_order->created_at;
                } else {
                    $last_ordered_at = $subscription->created_at;
                }
            }
            if (isset($last_ordered_at) && $last_ordered_at->addMonth()->lte(now())) {
                /* @var Queue $queue */
                $queue = $user->queues()->where('month', date('n'))->where('year', date('Y'))->first();
                if ($queue) {
                    $items = $queue->items->map(function (QueueItem $item) {
                        /* @var PurchaseOption $purchase_option */
                        $purchase_option = $item->product->purchase_options[0];
                        $params = [
                            'product_id' => $item->product_id,
                            'purchase_option_id' => $purchase_option?->id,
                            'product_title' => $item->product?->title,
                            'product_image' => $item->product?->image?->thumb_url ?? '',
                            'purchase_option' => $purchase_option?->quantity_text,
                            'amount' => $purchase_option?->price ?? 0,
                            // 'amount' => $purchase_option?->price??$item->product->retail_value,
                            'quantity' => 1,
                            'additional_price' => $item->product->additional_price ?? 0
                        ];
                        $params['subtotal'] = $params['quantity'] * $params['amount'];
                        // $params['tax'] = round($params['subtotal'] * (($item->product->tax ?? 0) / 100), config('misc.round')); // tax in percent
                        return $params;
                    });
                } else {
                    // No Queue, Find Product Of The Months
                    $previousPM = ProductOfTheMonth::query()
                        ->selectRaw('*, (year+(month/12)) as cyear')
                        ->with('product', function ($q) {
                            $q->with('purchase_options', function ($q2) {
                                $q2->where('type', 'subscription');
                            });
                        })->take($max_count)->orderByDesc('cyear')->get();
                    $items = $previousPM->map(function (ProductOfTheMonth $productOfTheMonth) {
                        /* @var PurchaseOption $purchase_option */
                        $purchase_option = $productOfTheMonth->product->purchase_options[0];
                        $params = [
                            'product_id' => $productOfTheMonth->product_id,
                            'purchase_option_id' => $purchase_option?->id,
                            'product_title' => $productOfTheMonth->product?->title,
                            'product_image' => $productOfTheMonth->product?->image?->thumb_url ?? '',
                            'purchase_option' => $purchase_option?->quantity_text,
                            'amount' => $purchase_option?->price ?? 0,
                            // 'amount' => $purchase_option?->price ?? $productOfTheMonth->product->retail_value,
                            'quantity' => 1,
                            'additional_price' => $productOfTheMonth->product->additional_price ?? 0
                        ];
                        $params['subtotal'] = $params['quantity'] * $params['amount'];
                        // $params['tax'] = round($params['subtotal'] * (($productOfTheMonth->product->tax ?? 0) / 100), config('misc.round')); // tax in percent
                        return $params;
                    });
                }
                if ($user->subscribed('case')) {
                    $caseProduct = Product::query()->with('purchase_options', function ($q4) {
                        $q4->where('type', 'subscription');
                    })->where('is_case', true)->inRandomOrder()->first();
                    if ($caseProduct) {
                        /* @var PurchaseOption $purchase_option */
                        $purchase_option = $caseProduct->purchase_options[0];
                        $params = [
                            'product_id' => $caseProduct->id,
                            'purchase_option_id' => $purchase_option?->id,
                            'product_title' => $caseProduct->title,
                            'product_image' => $caseProduct->image?->thumb_url,
                            'purchase_option' => $purchase_option?->quantity_text,
                            'amount' => $purchase_option?->price ?? 0,
                            // 'amount' => $purchase_option?->price ?? $caseProduct->retail_value,
                            'quantity' => 1,
                            'additional_price' => $caseProduct->additional_price ?? 0
                        ];
                        $params['subtotal'] = $params['quantity'] * $params['amount'];
                        // $params['tax'] = round($params['subtotal'] * (($caseProduct->tax ?? 0) / 100), config('misc.round')); // tax in percent
                        $items->push($params);
                    }
                }
                $orderExtras = $items->reduce(function ($accumulator, $curItem) {
                    return [
                        'net' => ($accumulator['net']+$curItem['subtotal']),
                        // 'tax' => ($accumulator['tax']+$curItem['tax']),
                        'additional' => ($accumulator['additional']+$curItem['additional_price']),
                    ];
                }, ['net' => 0, 'additional' => 0]); // 'tax' => 0
                $shippingAddress = $user->addresses->where('type', 'shipping')->first();
                $shipping = CartItemController::calculateShippingPolicy($user, ['total' => $orderExtras['net']]);
                $shipping_policy_id = null;
                $shipping_cost = config('misc.default_shipping');
                if (isset($shipping['exact']) && $shipping['exact'] instanceof ShippingPolicy) {
                    $shipping_policy_id = $shipping['exact']->id;
                    $shipping_cost = $shipping['exact']->charge;
                }
                // $gross = $orderExtras['net']+$orderExtras['tax'];
                $gross = $orderExtras['net'];
                try {
                    DB::beginTransaction();
                    /* @var Order $order */
                    $order = $user->orders()->create([
                        'queue_id' => isset($queue) ? $queue->id : null,
                        'source_type' => Queue::class,
                        'source_id' => isset($queue) ? $queue->id : null,
                        'shipping_policy_id' => $shipping_policy_id,
                        'shipping_cost' => $shipping_cost,
                        'net_total' => $orderExtras['net'],
                        // 'tax_total' => $orderExtras['tax'],
                        'gross_total' => $gross+$shipping_cost,
                    ]);
                    $order->items()->createMany($items->except(['additional_price']));
                    $order->addresses()->updateOrCreate(['type' => 'shipping'], $shippingAddress->toArray());
                    $paymentMethod = $user->defaultPaymentMethod()->asStripePaymentMethod();
                    if ($orderExtras['additional'] > 0) {
                        $user->charge($orderExtras['additional'], $paymentMethod->id);
                    }
                    DB::commit();
                    event(new OrderPlaced($order));
                    PaymentController::queueOrder($order);
                } catch (\Exception $exception) {
                    DB::rollBack();
                    Log::error($exception, ['subscription_order_user' => $user->id]);
                }
            }
        }
        return 0;
    }
}
