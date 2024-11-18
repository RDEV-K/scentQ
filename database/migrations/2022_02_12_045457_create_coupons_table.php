<?php

use App\Models\Coupon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->string('strip_coupon')->nullable();
            $table->string('min')->default(-1)->comment('Minimum Cart Amount, -1=Any Amount');
            $table->string('upto')->default(-1)->comment('Upto Discount Amount (Only for percent amount), -1=not needed');
            $table->bigInteger('maximum_use_limit')->default(-1);
            $table->tinyInteger('discount_type')->default(1)->comment('1=percent, 2=raw amount');
            $table->string('amount')->default(0);
            $table->boolean('system_added')->default(false);
            $table->boolean('redeemed')->default(false); // Only Work For System Coupon
            $table->nullableMorphs('ref'); // gift_card_purchase
            $table->longText('emails')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
