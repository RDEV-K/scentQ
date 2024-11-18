<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueuePurchasePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_purchase_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('minimum_count')->default(0);
            $table->unsignedInteger('maximum_count')->default(0);
            $table->string('discount')->default(0); // discount in percent
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
        Schema::dropIfExists('queue_purchase_policies');
    }
}
