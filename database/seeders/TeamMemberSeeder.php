<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TeamMember::create([
            'name' => 'Orkhan Rasulov',
            'designation' => 'CEO & Founder of ScentQ',
            'description' => "As the founder and COO of ScentQ, Orkhan brings invaluable expertise in operations and strategic management to the company. With a proven track record of optimizing supply chains and enhancing customer experiences, Orkhan has been instrumental in the company's rapid growth and success. His dedication to ensuring seamless subscription fulfillment and exceptional service has solidified ScentQ’s position as a top player in the fragrance industry. Orkhan continues to drive operational excellence and innovation, ensuring that subscribers receive their favorite fragrances with efficiency and reliability.",
            'linkedin_url' => 'https://www.linkedin.com/in/orkhan-rasulov-6480a3155/',
            'img_url' => 'images/team-member/about-boy.webp'
        ]);

        TeamMember::create([
            'name' => 'ANAXANIM ZEYNALLI',
            'designation' => 'CEO & Founder of ScentQ',
            'description' => "Anaxanim the visionary founder and CEO of ScentQ is a visionary entrepreneur who has transformed the way people experience and access fragrances. With an unwavering passion for scents and a deep understanding of consumer preferences, Anaxanim embarked on a mission to democratize luxury fragrances. Under Anaxanim's leadership, ScentQ has flourished offering a curated selection of exquisite fragrances delivered directly to customers' doorsteps, elevating the olfactory experience for thousands of subscribers worldwide. Anaxanim continues to drive innovation and elevate the fragrance subscription industry, making luxury scents more accessible and enjoyable for customers around the world.",
            'linkedin_url' => 'https://www..com/in/anaxanim-zeynalli-6a8398258/',
            'img_url' => 'images/team-member/about-girl.webp'
        ]);
    }
}
