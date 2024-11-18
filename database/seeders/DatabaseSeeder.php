<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\FaqSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // User::create([
        //     'first_name' => 'developer',
        //     'last_name' => 'developer',
        //     'email' => 'developer@mail.com',
        //     'password' => bcrypt('password')
        // ]);

        $this->call([
            FaqSeeder::class,
            SocialLinkSeeder::class,
            TextSeeder::class,
        ]);
    }
}
