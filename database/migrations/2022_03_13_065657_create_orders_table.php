<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(\App\Models\Queue::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->nullableMorphs('source');
            $table->foreignIdFor(\App\Models\ShippingPolicy::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('shipping_cost')->default(0);

            $table->foreignIdFor(\App\Models\Coupon::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('coupon_code')->nullable();
            $table->string('discount')->default(0);

            $table->string('gross_total')->default(0)->comment('line_item_price*line_item_quantity=line_item_subtotal');
            $table->string('tax_total')->default(0)->comment('tax calculation on sum(line_item_subtotal)');
            $table->string('net_total')->default(0)->comment('after all addition and deduction');

            $table->string('status')->default('no_entry');
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
        Schema::dropIfExists('orders');
    }
}
