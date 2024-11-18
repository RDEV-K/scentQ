<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Product::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('reviewer_name')->nullable();
            $table->text('reviewer_avatar')->nullable();
            $table->unsignedBigInteger('upvotes')->default(0);
            $table->unsignedBigInteger('downvotes')->default(0);
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->integer('rate')->default(0);
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
        Schema::dropIfExists('reviews');
    }
}
