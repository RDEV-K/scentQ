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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('tax');
        });
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('tax');
        });
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('tax_total');
        });
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('tax');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('tax_total');
        });
        Schema::table('line_items', function (Blueprint $table) {
            $table->dropColumn('tax');
        });

        // Schema::table('products', function (Blueprint $table) {
        //     $table->string('tax')->default('0')->nullable()->change();
        // });
        // Schema::table('plans', function (Blueprint $table) {
        //     $table->string('tax')->default(0)->nullable()->change();
        // });
        // Schema::table('carts', function (Blueprint $table) {
        //     $table->string('tax_total')->default(0)->nullable()->change();
        // });
        // Schema::table('cart_items', function (Blueprint $table) {
        //     $table->string('tax')->default(0)->nullable()->change();
        // });
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->string('tax_total')->default(0)->nullable()->change();
        // });
        // Schema::table('line_items', function (Blueprint $table) {
        //     $table->string('tax')->default(0)->nullable()->change();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
