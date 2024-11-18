<?php

namespace App\Listeners;

use App\Events\UserSubscribed;
use App\Http\Controllers\QueueController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\InteractsWithQueue;

class AddSubscriptionFreeProductToQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserSubscribed  $event
     * @return void
     */
    public function handle(UserSubscribed $event)
    {
        $user = $event->user;
        $plan = $event->plan;
        QueueController::pushProductBySystem($user, $plan->free_product_id);
    }
}
