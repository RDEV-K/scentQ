<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateReviewRatings extends Command
{
    protected $signature = 'product:update-review-ratings';

    protected $description = 'Update review ratings for each products in the database';


    public function handle()
    {
        try {
            // Get 100 of Product by each chunk
            $products = Product::chunk(100, function($products){
            // $products = Product::all();
                foreach ($products as $product) {
                    // Get the ratings
                    $ratings = $product->reviews()->avg('rate');
                    $ratings = round($ratings, 2);

                    // Update the ratings if changed
                    if ($ratings > 0 && $ratings != $product->review_ratings) {
                        // $product->review_ratings = $ratings;
                        // $product->save();
                        DB::table('products')->where('id', $product->id)
                        ->update([
                            'review_ratings' => $ratings
                        ]);
                    }
                }
                sleep(rand(3,5));
            });

            $this->info('Review ratings updated successfully.');
        } catch (\Throwable $th) {
            $this->info("An error occurred: " . $th->getMessage());
            Log::alert($th->getMessage(), [$th]);
        }
    }
}
