<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductReviewMailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public $order, public $user, public $social_media)
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
        if (config('misc.currency_code') == 'AZN' || 'BD') {
            return (new MailMessage)
                ->subject('Share Your Feedback and Review Our Product Today!')
                ->markdown('emails.az.product-review-mail', [
                    'order' => $this->order,
                    'user' => $this->user,
                    'social_media' => $this->social_media
                ]);
        } else {
            return (new MailMessage)
                ->subject('Share Your Feedback and Review Our Product Today!')
                ->markdown('emails.product-review-mail', [
                    'order' => $this->order,
                    'user' => $this->user,
                    'social_media' => $this->social_media
                ]);
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
