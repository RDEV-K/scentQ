<?php

namespace App\Notifications;

use App\Helpers\TemplateBuilder;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderInvoiceToCustomer extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public Order $order, public $shipping)
    {
        //
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
        // return (new TemplateBuilder)->fetch('invoice')->parse($this->order->getInvoiceParams())->get();
        if (config('misc.currency_code') == 'AZN' || 'BD') {
            return (new MailMessage)
                ->subject('Order Placed Successfully')
                ->markdown('emails.az.new-order', ['order' => $this->order, 'shipping' => $this->shipping]);
        } else {
            return (new MailMessage)
                ->subject('Order Placed Successfully')
                ->markdown('emails.new-order', ['order' => $this->order, 'shipping' => $this->shipping]);
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
