<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductNoteRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_note_relation', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Product::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Note::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_note_relation');
    }
}
