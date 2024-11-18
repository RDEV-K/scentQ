<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class AdjustExcerpt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scentq:auto_excerpt';

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
        $max_length = 200;
        $keep_word = false;
        $cut_off = '';
        $products = Product::query()->whereNull('excerpt')->get();

        /* @var Product $product */
        foreach ($products as $product) {
            $this->info(sprintf("Working on product: %d", $product->id));
            $text = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($product->content))))));
            if(mb_strlen($text) <= $max_length) {
            } elseif (mb_strlen($text) > $max_length) {
                if($keep_word) {
                    $text = mb_substr($text, 0, $max_length + 1);

                    if($last_space = mb_strrpos($text, ' ')) {
                        $text = mb_substr($text, 0, $last_space);
                        $text = rtrim($text);
                        $text .=  $cut_off;
                    }
                } else {
                    $text = mb_substr($text, 0, $max_length);
                    $text = rtrim($text);
                    $text .=  $cut_off;
                }
            }

            $product->update([
                'excerpt' => $text
            ]);
        }
        return 0;
    }
}
