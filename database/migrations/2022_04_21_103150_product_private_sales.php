<?php

use App\Models\PrivateSale;
use App\Models\Product;
use App\Models\PurchaseOption;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductPrivateSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('product_private_sales', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignIdFor(PrivateSale::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        //     $table->foreignIdFor(Product::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        //     $table->foreignIdFor(PurchaseOption::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('product_private_sales');
    }
}
