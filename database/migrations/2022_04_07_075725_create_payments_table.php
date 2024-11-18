<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('holder');
            $table->foreignIdFor(\App\Models\Gateway::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('payment_method_name')->nullable();
            $table->string('title')->nullable();
            $table->string('desc')->nullable();
            $table->string('amount')->default(0);
            $table->string('note')->nullable();
            $table->longText('errorText')->nullable();
            $table->text('transaction_id')->nullable();
            $table->string('status')->default('pending');
            $table->longText('data')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
