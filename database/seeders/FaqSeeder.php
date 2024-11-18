<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faqs = [
            [
                'question' => 'The University of East Anglia (UEA)',
                'answer' => "The University of East Anglia FAQ resource is more of an inbuilt problem-solving informational architecture than a separate FAQ resource.",
            ],
            [
                'question' => 'Twitter',
                'answer' => "Twitter’s FAQ help center made a list as it factored in some fascinating personalization, easy-to-use search functionality, and has a positive user experience (something few FAQ pages ever achieve).",
            ],
            [
                'question' => 'YouTube',
                'answer' => "YouTube’s FAQ page is clean, fresh, simple to use, and provides access to the most commonly asked “help” topics.",
            ],
            [
                'question' => 'McDonald’s',
                'answer' => "The McDonald’s FAQ page feels informal and sociable, encouraging people to share their FAQ experiences (a rarity).",
            ],
            [
                'question' => 'WhatsApp',
                'answer' => "The FAQ resource for Whatsapp is bright, easy to use, and categorized effectively for quick desktop or mobile use.",
            ],
            [
                'question' => 'Wikipedia',
                'answer' => "Wikipedia’s help center is an excellent example of an “old-school” FAQ page.",
            ],
        ];

        foreach ($faqs as $key => $faq) {
            Faq::create([
                'question' => $faq['question'],
                'answer' => $faq['answer'],
            ]);
        }
    }
}
