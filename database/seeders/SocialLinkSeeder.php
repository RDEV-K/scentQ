<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = [
            [
                'name' => 'facebook',
                'link' => 'https://www.facebook.com/scentqueue',
                'icon' => '/social-icons/facebook.png',
            ],
            [
                'name' => 'instagram',
                'link' => 'https://www.instagram.com/scentqueue/',
                'icon' => '/social-icons/instagram.png',
            ],
            [
                'name' => 'tiktok',
                'link' => 'https://www.tiktok.com/scentqueue/',
                'icon' => '/social-icons/tiktok.png',
            ],
            [
                'name' => 'pinterest',
                'link' => 'https://www.pinterest.com/scentqueue/',
                'icon' => '/social-icons/pinterest.png',
            ],
        ];

        SocialLink::truncate();

        foreach ($links as $key => $link) {
            SocialLink::create([
                'name' => $link['name'],
                'link' => $link['link'],
                'icon' => $link['icon'],
            ]);
        }
    }
}
