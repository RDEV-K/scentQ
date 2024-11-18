<?php

use App\Models\SocialLink;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('social_links', function (Blueprint $table) {
            $table->string('full_url')->nullable();
        });

        $links = SocialLink::all();

        if($links){
            
            foreach ($links as $key => $link) {
                $link->update([
                    'full_url'=> asset($link->icon),
                ]);
            }
                
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_links', function (Blueprint $table) {
            //
        });
    }
};
