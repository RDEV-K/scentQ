<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Notifications\OrderCanceledNotification;
use App\Notifications\OrderDeliveredNotification;
use App\Notifications\OrderUpdateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderUpdateNotification
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
     * @param  \App\Events\OrderStatusUpdated  $event
     * @return void
     */
    public function handle(OrderStatusUpdated $event)
    {
        $address = $event->order->addresses()->where('type', 'shipping')->first();
        if ($address) {
            // if order completed, send only OrderDeliveredNotification
            if ($event->order->status == 'completed') {
                return $address->notify(new OrderDeliveredNotification($event->order));
            }

            // if order canceled, send only OrderCanceledNotification
            if ($event->order->status == 'canceled') {
                return $address->notify(new OrderCanceledNotification($event->order));
            }

            // for all other states changes, send OrderUpdateNotification
            return $address->notify(new OrderUpdateNotification($event->order));
        }
    }
}
