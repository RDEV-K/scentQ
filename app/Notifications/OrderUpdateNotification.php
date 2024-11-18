<?php

namespace App\Notifications;

use App\Helpers\TemplateBuilder;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderUpdateNotification extends Notification
{
    use Queueable;
    public $orderDetails;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public Order $order)
    {
        $this->orderDetails = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new TemplateBuilder)->fetch('order_updated')->parse($this->order->getInvoiceParams())->get();
        if (config('misc.currency_code') == 'AZN' || 'BD') {
            return (new MailMessage)
                ->subject('Order Updated Successfully')
                ->markdown('emails.az.order-update', ['order' => $this->order]);
        } else {
            return (new MailMessage)
                ->subject('Order Updated Successfully')
                ->markdown('emails.order-update', ['order' => $this->order]);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}