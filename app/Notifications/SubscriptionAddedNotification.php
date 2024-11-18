<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionAddedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $plan;
    public function __construct($plan)
    {
        $this->plan = $plan;
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

        if (config('misc.currency_code') == 'AZN' || 'BD') {
            return (new MailMessage)
            ->subject('Subscription Added Successfully')
            ->markdown('emails.az.subscription_added', ['plan' => $this->plan]);
        } else {
        return (new MailMessage)
            ->subject('Subscription Added Successfully')
            ->markdown('emails.subscription_added', ['plan' => $this->plan]);
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
