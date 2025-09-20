<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIntoGoodReceive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('good_receives', function (Blueprint $table) {
            $table->integer('total_weight_received')->after('total_weight');
            $table->integer('total_weight_outstanding')->after('total_weight_received');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('good_receives', function (Blueprint $table) {
            //
        });
    }
}
