<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['personal', 'gift'])->default('personal');
            $table->string('name');
            $table->integer('product_count')->default(1);
            $table->string('price_par_product')->default(0);
            $table->unsignedBigInteger('first_time_coupon_id')->nullable();
            $table->string('total_price')->default(0);//ToDo == product_count x price_par_product
            $table->string('badge_text')->nullable();
            $table->string('tax')->default(0); //tax in percent
            $table->boolean('free_shipping')->default(false);//Todo
            $table->string('first_discount')->default(0); // First Time Discount In Percent
            $table->foreignIdFor(\App\Models\Product::class, 'free_product_id')->nullable()->constrained()->on('products')->cascadeOnUpdate()->nullOnDelete();
            //only for gift type column
            $table->integer('gift_month_count')->default(1);
            $table->string('gift_total')->default(0);
            $table->string('gift_save')->default(0);
            $table->longText('features')->nullable();
            $table->integer('gift_personal_receive')->default(0);
            // Stripe Integration
            $table->string('stripe_id')->nullable();
            $table->string('stripe_coupon')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();


            $table->foreign('first_time_coupon_id')->references('id')->on('coupons')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
