<?php

use App\Models\Settings;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $setting = Settings::first();

        if(!$setting){
            Artisan::call('db:seed --class=SettingsSeeder --force');
        }

        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('kwd_rate')->default(0.31);
            $table->decimal('aed_rate')->default(3.67);
            $table->decimal('bhd_rate')->default(0.38);
            $table->decimal('qar_rate')->default(3.64);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('kwd_rate');
            $table->dropColumn('aed_rate');
            $table->dropColumn('bhd_rate');
            $table->dropColumn('qar_rate');
        });
    }
};
