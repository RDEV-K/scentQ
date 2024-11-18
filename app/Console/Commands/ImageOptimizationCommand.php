<?php

namespace App\Console\Commands;

use App\Jobs\OptimizeImageSize;
use App\Models\Brand;
use App\Models\Note;
use App\Models\Product;
use Illuminate\Console\Command;

class ImageOptimizationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:optimization';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue image optimization job';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $loopCount = 0;
        $products = Product::all();
        foreach($products as $product){
            // optimize product primary image
            if($product->image && $product->image['url']){
                OptimizeImageSize::dispatch($product->image['url']);
            }

            // optimize product gallery images
            foreach ($product->images as $image) {
                if($image && $image['url']){
                    OptimizeImageSize::dispatch($image['url']);
                }
            }

            $loopCount++;

            // sleep 5 seconds once 100 product images has been queued
            if($loopCount % 100 == 0 && $products->count() != $loopCount) {
                $this->info( $loopCount .' has been updated. Sleeping for 5 seconds');
                sleep(5);
            }
            $this->info($products->count() != $loopCount);
            $this->info('product count is ' . $products->count());
            $this->info('loop count is ' . $loopCount);
        }

        // Product Notes
        $notes = Note::all();
        $loopCount = 0;
        foreach($notes as $note){
            if($note->image){
                OptimizeImageSize::dispatch($note->image);
            }
            $loopCount++;

            // sleep 5 seconds once 100 product images has been queued
            if($loopCount % 100 == 0 && $notes->count() != $loopCount) {
                $this->info( $loopCount .' note has been updated. Sleeping for 5 seconds');
                sleep(5);
            }
        }

        // Brand Images
        $brands = Brand::all();
        $loopCount = 0;

        foreach($brands as $brand){
            if($brand->image){
                OptimizeImageSize::dispatch($brand->image);
            }

            if($brand->cover_image){
                OptimizeImageSize::dispatch($brand->cover_image);
            }
            $loopCount++;

            // sleep 5 seconds once 100 product images has been queued
            if($loopCount % 100 == 0 && $brands->count() !== $loopCount) {
                $this->info( $loopCount .' brand has been updated. Sleeping for 5 seconds');
                sleep(5);
            }
        }
    }
}
