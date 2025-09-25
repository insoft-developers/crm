<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldFisikIntoGoodReceiveItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('good_receive_items', function (Blueprint $table) {
            $table->string('tebal_fisik')->after('tebal_actual')->nullable();
            $table->integer('weight_fisik')->after('weight_actual')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('good_receive_items', function (Blueprint $table) {
            //
        });
    }
}
