<?php

namespace App\Console\Commands;

use App\Models\Gateway;
use App\Models\NotificationTemplate;
use App\Models\Page;
use App\Models\Staff;
use App\Models\Taxonomy;
use App\PaymentMethods\PayPal;
use App\PaymentMethods\Stripe;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Seed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scentq:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed scentq required data to be functional';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $opt = $this->ask('What do you want to seed? all:a|taxonomy:t|page:p|gateway:g|notification template:nt', 'a');
        $opt = 'a';
        try {
            DB::beginTransaction();
            if ($opt == 'a') {
                Staff::create([
                    'name' => 'Super Admin',
                    'username' => 'JamalSuper',
                    'email' => 'scentqueue@gmail.com',
                    'avatar' => 'https://i.pravatar.cc/200?u=' . 'scentqueue@gmail.com',
                    'password' => Hash::make('Jamal@321!')
                ]);
            }
            if ($opt == 'a' || $opt == 'g') {
                $gateways = [
                    [
                        'name' => 'Stripe',
                        'test_mode' => true,
                        'credentials' => [
                            'publishable_key' => env('STRIPE_KEY'),
                            'secret_key' => env('STRIPE_SECRET'),
                            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
                        ],
                        'class_name' => 'Stripe'
                    ],
                    [
                        'name' => 'Paypal',
                        'test_mode' => true,
                        'credentials' => [
                            'business_email' => '',
                        ],
                        'class_name' => 'PayPal'
                    ],
                ];
                foreach ($gateways as $gateway) {
                    Gateway::create($gateway);
                }
            }
            if ($opt == 'a' || $opt == 't') {
                // Seeding Pages
                $builtInTaxonomies = [];
                foreach ($builtInTaxonomies as $builtInTaxonomy) {
                    /* @var Taxonomy $taxonomy */
                    $taxonomy = Taxonomy::create($builtInTaxonomy);
                    $taxonomy->metas()->createMany($builtInTaxonomy['meta']);
                }
            }
            if ($opt == 'a' || $opt == 'p') {
                // Seeding Pages
                $builtInPages = config('pages');
                foreach ($builtInPages as $page) {
                    Page::create($page);
                }
            }
            if ($opt == 'a' || $opt == 'nt') {
                // Seeding NotificationTemplate
                foreach (config('notification_templates') as $type => $templates) {
                    foreach ($templates as $name => $item) {
                        $item['name'] = $name;
                        $item['channel'] = $type;
                        NotificationTemplate::create($item);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
