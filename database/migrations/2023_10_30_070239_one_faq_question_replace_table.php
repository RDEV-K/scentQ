<?php

use App\Models\Faq;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $item = Faq::where('question', "Ensuring Authenticity: Are These Genuine Scents?")->first();
        if($item){
            $item->update([
                'question' => "How to Know if Your Scents are Real",
                'answer' => " To make sure you're getting genuine scents, it's best to buy from trusted places like authorized retailers, official brand stores, or reputable online platforms. They're more likely to sell real products.",
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
