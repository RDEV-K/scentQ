<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Models\ProductOfTheMonth;
use Illuminate\Support\Facades\Log;

class AutomaticQueueFillupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue-fill-up:automatic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         Log::info('Cron job started successfully.');
        // fetch all the subscription active users
        $users =  User::whereHas('subscriptions', function ($q) {
            return $q->active();
        })->get();

        // then loop the all users
        if ($users) {
            foreach ($users as $key => $user) {

                $subscription = $user->subscription('personal');
                if ($subscription) {

                    try {
                        $subscriptionFromStripe = (clone $subscription)->asStripeSubscription();

                        $today_date = now()->format('d-m-y');

                        $code_fire_date = Carbon::createFromTimestamp($subscriptionFromStripe->current_period_end)
                            ->subDays(2)->format('d-m-y');

                        // if next billing date and today date are same then fire the code
                        if ($today_date == $code_fire_date) {

                            try {
                                $month = Carbon::now()->addMonth(1)->format('m');
                                $year = Carbon::now()->format('Y');
                                $subscription =  $user->subscription('personal');

                                // get the user queue for next month
                                $queue = $user->queues()->where('year', $year)->where('month', $month)->first();

                                // if there is no queue then create one
                                if (!$queue) {
                                    $user->queues()->create([
                                        'year' => $year,
                                        'month' => $month
                                    ]);
                                }

                                // get the user queue for next month again after create
                                $queue = $user->queues()->where('year', $year)->where('month', $month)->first();

                                // if queue is available then do next thing
                                if ($queue) {

                                    // get the user queue total items
                                    $items_count = $queue->items()->count();
                                    // get the user subscription plan product total items
                                    $product_count =  getPlanProductCount($subscription->stripe_price);

                                    // if items_count less then product_count
                                    if ($items_count < $product_count) {

                                        // then got the amount left to add queue
                                        $remain_product = intval($product_count) - intval($items_count);

                                        if ($remain_product >= 0) {
                                            for ($i = 0; $i < $remain_product; $i++) {
                                                $this->addProductToQueue($queue, $user, $product_count, $subscription->stripe_price, $i);
                                            }
                                        } else {
                                            // Handle the case where $remain_product is negative
                                        }
                                    }
                                }
                            } catch (\Throwable $th) {
                                //
                            }
                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }
        }
    }

    protected function getPrevousOrderNotes($user)
    {
        $year = Carbon::now()->format('Y');

        $date =  Carbon::parse('01-' . Carbon::now()->format('m') . '-' . $year)->startOfMonth();
        $subscription_order = $user->orders()
            ->with(['items'])
            ->whereMonth('created_at', $date)
            ->whereNotNull('queue_id')
            ->first();

        if ($subscription_order) {

            $subscription_order_items = $subscription_order->items()->with(['product.notes'])->first();

            if ($subscription_order_items && $subscription_order_items->product && $subscription_order_items->product->notes) {

                $note_ids = [];
                foreach ($subscription_order_items->product->notes as $key => $item) {
                    array_push($note_ids, $item->id);
                }

                $product = Product::whereHas('notes', function ($q) use ($note_ids) {
                    $q->whereIn('notes.id', $note_ids);
                })->inRandomOrder()->first();

                return $product;
            }
        }
    }

    protected function addProductToQueue($queue, $user, $product_count, $plan_price, $i)
    {
        if ($i == 0) {
            $product =  $this->getProductFromProductOfMonth() ?? $this->getRandomProduct();
        } else {
            $product =  $this->getPrevousOrderNotes($user) ?? $this->getRandomProduct();
        }

        $queue->items()->create([
            'queue_id' => $queue->id,
            'product_id' => $product->id,
            'addedBy_type' => 'App\Models\User',
            'addedBy_id' => $user->id,
        ]);

        // $this->addProductToOrder($user, $product, $product_count, $plan_price);
    }

    protected function getRandomProduct()
    {
        $product = Product::inRandomOrder()->first();
        return $product;
    }

    protected function getProductFromProductOfMonth()
    {
        $month = now()->addMonth(1)->format('m');
        $year = now()->format('Y');

        $product_of_month = ProductOfTheMonth::where('year', $year)->where('month', $month)->with(['product'])->first();

        if (!$product_of_month) {
            return $this->getRandomProduct();
        }

        $product = $product_of_month->product;

        if (!$product) {
            return $this->getRandomProduct();
        }

        return $product;
    }

    // protected function addProductToOrder($user, $product, $product_count, $plan_price)
    // {
    //     $order = $user->orders()
    //         ->whereBetween(
    //             'created_at',
    //             [
    //                 Carbon::now()->startOfMonth(),
    //                 Carbon::now()->endOfMonth()
    //             ]
    //         )
    //         ->whereNotNull('queue_id')->first();

    //     if ($order) {
    //         $items_count = $order->items()->count();
    //         $plan = getPlan($plan_price);

    //         if ($items_count < $product_count) {
    //             $order->items()->create([
    //                 'product_id' => $product->id,
    //                 'purchase_option_id' => null,
    //                 'product_title' => $product->title ?? '',
    //                 'product_image' => $product->image['url'] ?? '',
    //                 'purchase_option' => null,
    //                 'amount' => $plan ? $plan->price_par_product : 0,
    //                 'quantity' => 1,
    //                 'additional_price' => ''
    //             ]);
    //         }
    //     }
    // }
}
