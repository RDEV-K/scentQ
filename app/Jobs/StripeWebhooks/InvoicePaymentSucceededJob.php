<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Staff;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Product;
use App\Mail\NewOrderMail;
use App\Models\SocialLink;
use App\Traits\KlaviyoTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use App\Models\ProductOfTheMonth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Notifications\OrderIsEmptyNotification;
use App\Notifications\Admin\NewOrderNotification;
use App\Notifications\SubscriptionNewOrderNotification;

class InvoicePaymentSucceededJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, KlaviyoTrait;

    /** @var \Spatie\WebhookClient\Models\WebhookCall */
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
        $succeeded_payment = $this->webhookCall->payload['data']['object'];


        $year = date('Y');
        $month = date('m');

        $customer_id = $succeeded_payment['customer'];
        $user = '';
        $queue_items = '';
        $user_queue = '';
        $amount = intval($succeeded_payment['amount_paid']) / 100;
        $transaction_id = $succeeded_payment['payment_intent'];
        $order = '';
        $shipping_cost = config('misc.default_shipping');
        $user_address = '';
        $payment_data = [];
        $plan = '';

        $coupon_id = null;
        $coupon_code = null;
        $coupon_discount = 0;
        $subtotal = intval($succeeded_payment['subtotal']) / 100 ?? '';

        // check coupon is used
        $coupon = $succeeded_payment['discount'] ? $succeeded_payment['discount']['coupon'] : '';
        if ($coupon && $coupon['id']) {
            $get_coupon = Coupon::where('strip_coupon', $coupon['id'])->first();
            if ($get_coupon) {
                $coupon_id = $get_coupon->id;
                $coupon_code = $get_coupon->code;
                $coupon_discount = $get_coupon->amount;
            }
        }
        // check coupon is used end

        if ($customer_id) {
            $user = User::where('stripe_id', $customer_id)->first();
        }

        // get user queue items part
        if ($user) { // if user find

            // check user queue is available
            $check_queue = $user->queues()->where('year', $year)->where('month', $month)->first();
            if (!$check_queue) { // create queue
                $user->queues()->create([
                    'month' => $month,
                    'year' => Carbon::now()->format('Y')
                ]);
            }
            // get user plan
            $get_plan = $user->subscription('personal');
            if ($get_plan && $get_plan->stripe_price) {
                $plan = Plan::where('stripe_id', $get_plan->stripe_price)->first();
            }
            // get user queue
            $queue = $user->queues()->where('year', $year)->where('month', $month)->first();
            $user_queue = $queue;

            if ($queue) { // if queue is available

                // get queue items
                $get_queue_items = $queue->items()->count();

                // if queue items not available
                // if ($get_queue_items == 0) {

                //     // then insert item from the month of product table
                //     $this_month_products = ProductOfTheMonth::where('year', $year)->where('month', $month)->get()->map(function ($q) {
                //         return $q->product_id;
                //     });

                //     if ($this_month_products) {
                //         foreach ($this_month_products as $key => $this_month_product) {
                //             $queue->items()->create([
                //                 'queue_id' => $queue->id,
                //                 'product_id' => $this_month_product,
                //                 'addedBy_type' => 'App\Models\User',
                //                 'addedBy_id' =>  $user->id
                //             ]);
                //         }
                //     }
                //     // then insert item from the month of product table End
                // }
                if ($plan && $plan->product_count && $plan->product_count > 0) {
                    $queue_items = $queue->items()->take($plan->product_count)->get()->map(function ($q) {
                        return $q->product_id;
                    });
                } else {
                    $queue_items = $queue->items()->get()->map(function ($q) {
                        return $q->product_id;
                    });
                }
            }
        }
        // get user queue items part end

        // shipping address find
        if ($user) {
            $user_address = $user->addresses()->where('type', 'shipping')->first();
        }
        // shipping address find end

        // order create part under  payment
        if ($user) {
            $created_order = Order::create([
                'user_id' => $user->id,
                'queue_id' => $user_queue->id,
                'source_type' => null,
                'source_id' => null,
                'shipping_policy_id' => null,
                'shipping_cost' => $shipping_cost ?? 0,
                'coupon_id' => $coupon_id ?? null,
                'coupon_code' => $coupon_code ?? null,
                'discount' => $coupon_discount ?? 0,
                'policy_discount' => 0,
                'net_total' => $subtotal ?? $amount,
                'gross_total' => $amount,
                'status' => 'pending',
                'curreny' => config('misc.currency_code'),
                'converted_price' => currencyConvert($amount) ?? 0,
            ]);
            $order = $created_order;

            // data push to klaviyo
            $this->orderPlaced($order, $user);
        }
        // order create part under payment end

        // order shipping address create part
        if ($order) {
            $order->addresses()->create([
                'type' => 'shipping',
                'name' => $user_address->name ?? '',
                'email' => $user_address->email ?? '',
                'phone' => $user_address->phone ?? '',
                'country' => $user_address->country ?? '',
                'state' => $user_address->state ?? '',
                'city' => $user_address->city ?? '',
                'line1' => $user_address->line1 ?? '',
                'line2' => $user_address->line2 ?? '',
                'postal_code' => $user_address->postal_code ?? '',
            ]);
        }
        // order shipping address create part end

        // order items create part under this order
        if ($order) {

            if ($queue_items) {
                foreach ($queue_items as $key => $queue_item) {

                    $product =  Product::where('id', $queue_item)->first();

                    $order->items()->create([
                        'product_id' => $queue_item,
                        'purchase_option_id' => null,
                        'product_title' => $product->title ?? '',
                        'product_image' => $product->image['url'] ?? '',
                        'purchase_option' => null,
                        'amount' => $plan ? $plan->price_par_product : $product->additional_price ?? 0,
                        'subtotal' => $plan ? $plan->price_par_product : $product->additional_price ?? 0,
                        'quantity' => 1,
                        'additional_price' => ''
                    ]);
                }
            }
        }
        // order items create part under this order end

        if ($user) {

            $payment_data = cardInfo($user->id);

            // \Stripe\Stripe::setApiKey(config('services.stripe.secret));

            // $paymentMethods = \Stripe\PaymentMethod::all([
            //     'customer' => $user->stripe_id,
            //     'type' => 'card',
            // ]);

            // // Check if there are payment methods and get the first one
            // $paymentMethod = isset($paymentMethods['data'][0]) ? $paymentMethods['data'][0]['card'] : null;


        }
        // if ($user && $user->paymentMethods()) {
        //     $paymentMethods = $user->paymentMethods()->map(function ($paymentMethod) {
        //         return $paymentMethod->asStripePaymentMethod();
        //     });
        //     $payment_data = $paymentMethods[0]['card'];
        // }

        // payment create  end
        if ($order) {
            $created_payment = Payment::create([
                'holder_type' => Order::class,
                'holder_id' => $order->id,
                'payment_method_name' => 'Stripe',
                'gateway_id' => 1,
                'title' => 'Order ' . $order->order_no ?? $order->od,
                'desc' => null,
                'amount' => currencyConvert($amount) ?? $amount,
                'note' => null,
                'errorText' => null,
                'transaction_id' => $transaction_id,
                'status' => $succeeded_payment['status'] ?? 'pending',
                'data' => $payment_data,
                'curreny' => config('misc.currency_code'),
                'usd_price' => $amount ?? 0,
            ]);
        }
        // payment create  end

        // order placed notification to subscriber
        if (checkMailConfig()) {

            // send email for order is empty=
            if ($queue_items && $queue_items?->count() == 0) {
                $user->notify(new OrderIsEmptyNotification);
            }

            if ($order) {

                $get_order = Order::where('id', $order['id'])->first();

                $shippingAddress = '';
                if ($get_order->addresses) {
                    $shippingAddress = $get_order->addresses()->where('type', 'shipping')->first();
                }

                $coupon = Coupon::where('id', $order->coupon_id)->first();
                $social_media = SocialLink::orderBy('order', 'ASC')->get();

                // $view = new NewOrderMail($order, $shippingAddress, $social_media, $coupon);
                // Mail::to($user->email)->send($view);
                $user->notify(new SubscriptionNewOrderNotification($order, $shippingAddress, $social_media, $coupon));

                $staffs = Staff::all();
                foreach ($staffs as $key => $staff) {
                    $staff->notify(new NewOrderNotification($order, $shippingAddress));
                }
            }
        }
    }
}
