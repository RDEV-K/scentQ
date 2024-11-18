<?php

namespace Database\Seeders;

use App\Models\Text;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $texts = [
            ['key' => 'title', 'value' => 'INDULGE IN NEW LUXURY BRANDS EVERY MONTH'],
            ['key' => 'subtitle', 'value' => 'Explore a world of 1600 fragrances, with your monthly priced at'],
            ['key' => 'buttonText', 'value' => 'Just'],

        ];

        foreach ($texts as $text) {
            Text::updateOrCreate(
                ['key' => $text['key']],
                ['value' => $text['value']]
            );
        }
    }
}
