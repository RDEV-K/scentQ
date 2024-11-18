<?php

namespace App\Providers;


use Inertia\Inertia;
use App\Models\Gateway;
use App\Services\PlanService;
use Illuminate\Routing\Route;
use Lcobucci\JWT\Configuration;
use Torann\GeoIP\Facades\GeoIP;
use App\Services\SocialLinkService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Lcobucci\JWT\Signer\Ecdsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->app->bind(Configuration::class, fn () => Configuration::forSymmetricSigner(
        //     Sha256::create(),
        //     InMemory::plainText(config('services.apple.private_key')),
        // ));

        // Domain wise currency change code on runtime
        try {

            // Get the domain name from the request
            $ip = request()->ip();
            // $ip = '103.102.27.0'; // Bangladesh
            // $ip = '105.179.161.212'; // Mauritius
            // $ip = "101.167.184.0"; // United Kingdom
            // $ip = '103.119.111.0'; // Azerbaijan
            // $ip = '79.172.180.120'; // saudi arab
            // $ip = '102.217.239.0'; // quwait
            // $ip = '102.177.124.0'; //United Arab Emirates
            // $ip = '103.152.99.0'; // Bahrain
            // $ip = '103.14.208.0'; // Qatar

            $country = '';
            try {
                if ($ip && $ip != '127.0.0.1') {
                    $geo = GeoIP::getLocation($ip);
                    if ($geo) {
                        $country = $geo['iso_code'];
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
            }

            $domain = request()->getHost();
            // $domain = 'scentq.co.uk';

            //  domain it not uk
            if ($domain == 'scentq.co.uk') {
                $this->setConfigCurrency('GBP', '£', 'left');
            } else {
                $this->setConfigCurrency('USD', '$', 'left');
            }
        } catch (\Exception $exception) {
        }

        // Change Configs On Runtime
        try {

            // stripe info set
            config()->set('cashier.currency', config('misc.currency_code'));
//            config()->set('cashier.key', env('STRIPE_KEY'));
//            config()->set('cashier.secret', env('STRIPE_SECRET'));

            // $stripe = Gateway::find(1);
            // config()->set('cashier.currency', config('misc.currency_code'));
            // config()->set('cashier.key', $stripe->credentials['publishable_key']);
            // config()->set('cashier.secret', $stripe->credentials['private_key']);
        } catch (\Exception $exception) {
        }

        Inertia::titleTemplate(fn($title) => $title ? sprintf("%s | %s", $title, config('app.name')) : config('app.name'));

        Blade::directive('able', function ($expression) {
            $caps = explode(', ', $expression);
            $value = count($caps) > 1 ? $caps : $caps[0];
            return "<?php if (auth('staff')->user()->hasCap($value)): ?>";
        });

        Blade::directive('endable', function ($expression) {
            return "<?php endif; ?>";
        });

        if (!app()->runningInConsole()) {
            View::share('social_media', SocialLinkService::getAllLinks());
            View::share('current_plan', PlanService::getCurrentDefaultPlan());
        }
    }

    public function setConfigCurrency(
        string $currency_code,
        string $currency_symbol,
        string $currency_position,
        string $dir = 'ltr',
        string $language = 'en',
    )
    {
        config()->set('misc.currency_code', $currency_code);
        config()->set('misc.currency_symbol', $currency_symbol);
        config()->set('misc.currency_position', $currency_position);

        config()->set('misc.dir', $dir);
        config()->set('misc.language', $language);
    }
}
