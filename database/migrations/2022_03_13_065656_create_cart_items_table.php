<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Cart::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Product::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(\App\Models\PurchaseOption::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(\App\Models\QueueItem::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();

            $table->string('product_title')->nullable();
            $table->string('product_image')->nullable();
            $table->string('purchase_option')->nullable();
            $table->string('amount')->default(0);
            $table->integer('quantity')->default(0);
            $table->string('subtotal')->default(0);
            $table->string('tax')->default(0);

            $table->longText('attrs')->nullable();
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
        Schema::dropIfExists('cart_items');
    }
}
