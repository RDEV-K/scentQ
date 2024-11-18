<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data_count = DB::table('faq_groups')->count();
        if ($data_count == 0) {
            $this->seedFaqGroupSeeder();
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    public function seedFaqGroupSeeder()
    {
        Artisan::call('db:seed --class=FaqGroupSeeder');
    }
};
