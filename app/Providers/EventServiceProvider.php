<?php

namespace App\Providers;

use App\Models\User;
use App\Events\CouponUsed;
use App\Events\UserSubscribed;
use App\Events\PaymentReceived;
use App\Observers\UserObserver;
use App\Events\OrderStatusUpdated;
use App\Listeners\MakeOrderConfirmed;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\RedeemSystemAddedCoupon;
use App\Listeners\HasUploadedImageListener;
use App\Listeners\SendOrderUpdateNotification;
use App\Listeners\AddReferralFreeProductsToQueue;
use App\Listeners\AddSubscriptionFreeProductToQueue;
use UniSharp\LaravelFilemanager\Events\ImageWasUploaded;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
//        Registered::class => [
//            SendEmailVerificationNotification::class,
//        ],
        UserSubscribed::class => [
            AddSubscriptionFreeProductToQueue::class,
            AddReferralFreeProductsToQueue::class
        ],
        PaymentReceived::class => [
            MakeOrderConfirmed::class,
        ],
        OrderStatusUpdated::class => [
            SendOrderUpdateNotification::class
        ],
        CouponUsed::class => [
            RedeemSystemAddedCoupon::class,
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            \SocialiteProviders\Apple\AppleExtendSocialite::class.'@handle',
        ],
        ImageWasUploaded::class => [
            HasUploadedImageListener::class
        ],
        'eloquent.created: *' => [
            \App\Listeners\ClearCacheOnModelChange::class,
        ],
        'eloquent.updated: *' => [
            \App\Listeners\ClearCacheOnModelChange::class,
        ],
        'eloquent.deleted: *' => [
            \App\Listeners\ClearCacheOnModelChange::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
