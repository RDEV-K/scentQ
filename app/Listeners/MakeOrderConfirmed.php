<?php

namespace App\Listeners;

use App\Events\PaymentReceived;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Notifications\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MakeOrderConfirmed
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
     * @param  \App\Events\PaymentReceived  $event
     * @return void
     */
    public function handle(PaymentReceived $event)
    {
        if ($event->payment->holder instanceof Order) {
            $event->payment->holder()->update([
                'status' => Order::$STATUS_PENDING
            ]);
            if ($event->payment->holder->user) {
                $event->payment->holder->user->cart()->delete();
            }
            $shippingAddress = $event->payment->holder->addresses()->where('type', 'shipping')->first();
            if ($shippingAddress instanceof OrderAddress) {
                $shippingAddress->notify(new NewOrderNotification($event->payment->holder, $shippingAddress));
            }
        }
    }
}
