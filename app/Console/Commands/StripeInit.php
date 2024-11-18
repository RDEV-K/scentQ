<?php

namespace App\Console\Commands;

use App\Models\Meta;
use Illuminate\Console\Command;
use Laravel\Cashier\Cashier;

class StripeInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scentq:stripe {--force=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $force = (bool)$this->option('force');
        $meta = Meta::query()->where('name', 'cashier_stripe_fragrance_subscription')->first();
        if (!$meta || ($meta && $force)) {
            $product = Cashier::stripe()->products->create([
                'name' => 'Fragrance Subscription'
            ]);
            Meta::query()->updateOrCreate(['name' => 'cashier_stripe_fragrance_subscription'], ['content' => $product->id]);
        }

        $meta = Meta::query()->where('name', 'cashier_stripe_case_subscription')->first();
        if (!$meta || ($meta && $force)) {
            $product = Cashier::stripe()->products->create([
                'name' => 'Case Subscription'
            ]);
            Meta::query()->updateOrCreate(['name' => 'cashier_stripe_case_subscription'], ['content' => $product->id]);
            $price = Cashier::stripe()->prices->create([
                'currency' => config('misc.currency_code'),
                'product' => $product->id,
                'unit_amount_decimal' => (10*100),
                'nickname' => 'Case Subscription Price',
                'billing_scheme' => 'per_unit',
                'recurring' => [
                    'interval' => 'month',
                    'interval_count' => 1,
                ]
            ]);
            Meta::query()->updateOrCreate(['name' => 'case_subscription_price'], ['content' => 10]);
            Meta::query()->updateOrCreate(['name' => 'case_subscription_stripe_price'], ['content' => $price->id]);
        }
        return 0;
    }
}
