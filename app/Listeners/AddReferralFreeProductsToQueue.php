<?php

namespace App\Listeners;

use App\Events\UserSubscribed;
use App\Http\Controllers\QueueController;
use App\Models\Meta;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddReferralFreeProductsToQueue
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
        if ($user->referred_by instanceof User) {
            // SETTINGS, referrer_user_product_id, referred_user_product_id
            $metas = Meta::query()
                ->where('name', 'referrer_user_product_id')
                ->orWhere('name', 'referred_user_product_id')
                ->pluck('content', 'name')->toArray();

            if (isset($metas['referrer_user_product_id'])) {
                QueueController::pushProductBySystem($user->referred_by, $metas['referrer_user_product_id']);
            }
            if (isset($metas['referred_user_product_id'])) {
                QueueController::pushProductBySystem($user, $metas['referred_user_product_id']);
            }

        }
    }
}
