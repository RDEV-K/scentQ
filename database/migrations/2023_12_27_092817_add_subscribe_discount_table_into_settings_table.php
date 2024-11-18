<?php

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
        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('first_month_subscribe_discount_percentage')->default(50);
            $table->boolean('first_month_subscribe_discount_status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('first_month_subscribe_discount_percentage');
            $table->dropColumn('first_month_subscribe_discount_status');
        });
    }
};
