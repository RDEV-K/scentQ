<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Product;
use Illuminate\Console\Command;
use App\Models\ProductOfTheMonth;
use App\Http\Controllers\HomeController;
use App\Notifications\OrderIsEmptyNotification;
use App\Notifications\SubscriptionAutoFilledUp;

class AutoFillupNewSubscriptionOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order-fill-up:automatic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Query users registered in the last 3 days
        $users = User::query()
            ->hasActiveSubscriptionsWithIn(days: 3)
            ->get();

        // return if no users has created subscription within last 3 days
        if (count($users) <= 0) {
            return;
        }

        //  loop users 
        foreach ($users as $user) {
            // check order is empty             
            $date =  now()->startOfMonth();
            $emptyStatus = (new HomeController())->checkSubscriptionOrderIsEmpty($user, $date);

            if (!$emptyStatus) {
                continue;
            }

            // ===================== check 12 hrs is filled after subscription 
            $subscription = $user->subscription('personal');

            // Your target time (replace this with your actual time)
            $subscriptionFromStripe = (clone $subscription)->asStripeSubscription();

            $subscriptionDate = Carbon::createFromTimestamp($subscriptionFromStripe->created)->format('Y-m-d H:i:s');

            // Current time
            $currentTime = now();

            // Calculate the difference in hours            
            $hoursDifference = $currentTime->diffInHours($subscriptionDate);

            // Check if the target time is within the next 8 or 24 hours

            if ($hoursDifference >= 8 && $hoursDifference <= 9) {
                $user->notify(new OrderIsEmptyNotification);
            } elseif ($hoursDifference >= 24 && $hoursDifference <= 25) {
                $user->notify(new OrderIsEmptyNotification);
            } elseif ($hoursDifference >= 48) {
                $result = $this->pushProductIntoOrder($user, $date, $subscription);

                if ($result) {
                    $user->notify(new SubscriptionAutoFilledUp);
                }
            }
            // ===================== check 48 hrs is filled after subscription end 
        }
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

        $productOfMonth = ProductOfTheMonth::where('year', $year)
            ->where('month', $month)
            ->with(['product'])
            ->first();

        $product = $productOfMonth ? $productOfMonth->product : null;

        return $product ?? $this->getRandomProduct();
    }

    public function pushProductIntoOrder($user, $date, $subscription): bool
    {
        $subscriptionOrder = $user->orders()
            ->whereMonth('created_at', $date)
            ->whereNotNull('queue_id')
            ->first();

        if (!$subscriptionOrder) {
            return false; // No order found, exit early
        }

        if (!$subscription || !$subscription->stripe_price) {
            return false; // No personal subscription or missing stripe_price, exit early
        }

        $plan = Plan::where('stripe_id', $subscription->stripe_price)->first();
        $product = $this->getProductFromProductOfMonth();

        if (!$plan || !$product) {
            return false; // No valid plan or product, exit early
        }

        $subscriptionOrder->items()->create([
            'product_id' => $product->id,
            'purchase_option_id' => null,
            'product_title' => $product->title ?? '',
            'product_image' => $product->image['url'] ?? '',
            'purchase_option' => null,
            'amount' => $plan->price_par_product ?? $product->additional_price ?? 0,
            'subtotal' => $plan->price_par_product ?? $product->additional_price ?? 0,
            'quantity' => 1,
            'additional_price' => '',
        ]);

        return true; // Success
    }
}
