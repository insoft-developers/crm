<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForGrItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('good_receive_items', function (Blueprint $table) {
            $table->integer('quantity')->nullable()->change();
            $table->integer('quantity_received')->nullable()->change();
            $table->integer('quantity_outstanding')->nullable()->change();
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
