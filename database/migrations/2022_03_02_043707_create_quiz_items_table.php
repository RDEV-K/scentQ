<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_items', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->enum('type', ['masculine', 'feminine'])->default('feminine');
            $table->string('image')->nullable();
            $table->tinyInteger('serial')->default(1);
            $table->foreignIdFor(\App\Models\QuizItem::class, 'show_if_id')->nullable()->constrained('quiz_items', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('show_if_option_id')->nullable();
            $table->timestamps();

            $table->foreign('show_if_option_id')->references('id')->on('quiz_items')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_items');
    }
}
