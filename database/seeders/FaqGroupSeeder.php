<?php

namespace Database\Seeders;

use App\Models\FaqGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            ['title' => 'General'],
            ['title' => ' My Account'],
            ['title' => 'Subscription'],
            ['title' => 'Billing & Shipping'],
            ['title' => 'Order & Tracking']
        ];

        foreach ($groups as $key => $group) {
            FaqGroup::create([
                'title' => $group['title']
            ]);
        }
    }
}
