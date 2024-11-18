<?php

namespace App\Providers;

use App\Models\ShippingPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class DynamicConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Request $request): void
    {
        try {
            $latestShippingFee = ShippingPolicy::latest()->first();
            if($latestShippingFee){
                config(['misc.default_shipping' => $latestShippingFee->charge]);
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Database connection error in DynamicConfigServiceProvider: " . $e->getMessage());
        }
    }

}
