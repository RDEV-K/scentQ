<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOfTheMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_of_the_months', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('type');
            $table->integer('month');
            $table->string('year');
            $table->string('cover_image')->nullable();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->text('quote')->nullable();
            $table->text('quote_by')->nullable();
            $table->text('quote_by_designation')->nullable();
            $table->string('video_code')->nullable();
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
        Schema::dropIfExists('product_of_the_months');
    }
}
