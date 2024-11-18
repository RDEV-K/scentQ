<?php

namespace App\Listeners\SocialiteProviders\Apple;

use App\Events\SocialiteProviders\Manager\SocialiteWasCalled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AppleExtendSocialite
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SocialiteWasCalled $event): void
    {
        //
    }
}
