<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Brand::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('sub_title')->nullable();
            $table->enum('type', ['perfume','cologne','makeup','skincare','personal-care','giftset','extras'])->default('perfume');
            $table->foreignIdFor(\App\Models\ProductSubType::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->enum('for', ['both', 'him', 'her'])->default('both');
            $table->string('retail_value')->nullable();
            $table->string('tax')->default('0');
            $table->longText('images')->nullable(); // A JSON Encoded Image Gallery
            $table->longText('content')->nullable();
            $table->longText('how_to_use')->nullable();
            $table->longText('ingredients')->nullable();
            $table->longText('why_we_love_it')->nullable();
            $table->longText('how_it_works')->nullable();
            $table->longText('disclaimer')->nullable();
            $table->string('additional_price')->nullable(); // Only Used For Premium Product
            $table->string('stock')->default(-1);
            $table->boolean('mark_as_clean')->default(false);
            $table->boolean('is_case')->default(false);
            $table->string('status')->default('published'); // published|drafted
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
        Schema::dropIfExists('products');
    }
}
