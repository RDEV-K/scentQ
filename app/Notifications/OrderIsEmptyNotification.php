<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderIsEmptyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
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
        $file = 'emails.order-empty';

        if (config('misc.currency_code') == 'AZN' || config('misc.currency_code') == 'BD') {
            $file = 'emails.az.order-empty';
        }

        return (new MailMessage)
            ->subject('No product associated with your order')
            ->markdown($file, ['name' => $notifiable->full_name]);
    }
}
