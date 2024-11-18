<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\PurchaseOption;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class AddFixedPurchaseOptionToAllProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scentq:afpotap';

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
        $products = Product::query()->with('purchase_options')->whereDoesntHave('purchase_options', function ($q) {
            /* @var Builder $q */
            return $q->where('type', 'one_time');
        })->get();

        /* @var Product $product */
        foreach ($products as $product) {
            if (! $product->purchase_options->count()) continue;
            $this->info('Adding purchase option to product ' . $product->id);
            $po = $product->purchase_options()->create([
                'type' => 'one_time',
                'image' => $product->purchase_options[0]->image,
                'price' => 21.95,
                'quantity_text' => $product->purchase_options[0]->quantity_text,
                'type_text' => $product->purchase_options[0]->type_text,
            ]);
            if (! $po instanceof PurchaseOption) {
                $this->warn("Unable to add for product " . $product->id);
            }
        }
        return 0;
    }
}
