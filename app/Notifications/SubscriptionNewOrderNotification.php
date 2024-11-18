<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionNewOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order, public $shipping, public $social_media, public $coupon)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        if (config('misc.currency_code') == 'AZN' || 'BD') {
            return (new MailMessage)
                ->subject('Order Placed Successfully')
                ->markdown('emails.az.subscription-order-mail', [
                    'order' => $this->order,
                    'shipping' => $this->shipping,
                    'social_media' => $this->social_media,
                    'coupon' => $this->coupon,
                ]);
        } else {
            return (new MailMessage)
                ->subject('Order Placed Successfully')
                ->markdown('emails.subscription-order-mail', [
                    'order' => $this->order,
                    'shipping' => $this->shipping,
                    'social_media' => $this->social_media,
                    'coupon' => $this->coupon,
                ]);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
