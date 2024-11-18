<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\SubscriptionHistory;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Laravel\Cashier\Subscription;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\WebhookClient\Models\WebhookCall;

class SubscriptionDeleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(
        public WebhookCall $webhookCall
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = data_get($this->webhookCall->payload, 'data.object', null);

        // if the status is not canceled we don't want it
        if (!$data || $data['status'] !== 'canceled') {
            return;
        }

        $id = data_get($data, 'id', null);

        info('Subscription Canceled Event Received:', ['subscription' => $id]);

        $subscription = Subscription::where('stripe_id', $id)->first();

        // if subscription not found ignore it
        if (!$subscription) {
            return;
        }

        // finally update subscription status
        $subscription->stripe_status = $data['status'];

        $subscription->ends_at = Carbon::createFromTimestamp(
            $data['current_period_end']
        );

        $subscription->save();        

        // Create a new instance of the Subscription History
        $history = new SubscriptionHistory();

        // Set the attributes of the SubscriptionHistory to match the original
        $history->fill($subscription->attributesToArray());

        // Save the Subscription History
        $history->save();

        // delete the subscription
        $subscription->delete();

        info('Subscription ' . strtoupper($data['status']) . ' Status Updated.');
    }
}
