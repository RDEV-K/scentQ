<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('cart_items','purchase_option_type')){
            Schema::table('cart_items', function (Blueprint $table) {
                $table->string('purchase_option_type')->after('purchase_option')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('cart_items','purchase_option_type')){
            Schema::table('cart_items', function (Blueprint $table) {
                $table->dropColumn('purchase_option_type');
            });
        }
    }
};
