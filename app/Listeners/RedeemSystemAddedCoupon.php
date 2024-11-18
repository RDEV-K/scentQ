<?php

namespace App\Listeners;

use App\Events\CouponUsed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RedeemSystemAddedCoupon
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
     * @param  \App\Events\CouponUsed  $event
     * @return void
     */
    public function handle(CouponUsed $event)
    {
        $coupon = $event->coupon;
        if ($coupon->system_added) {
            unset($coupon->notRemovable);
            $coupon->update([
                'redeemed' => true
            ]);
        }
    }
}
