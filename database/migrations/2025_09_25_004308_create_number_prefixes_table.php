<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumberPrefixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_prefixes', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_request')->nullable();
            $table->string('purchase_order')->nullable();
            $table->string('good_receive')->nullable();
            $table->string('titipan')->nullable();
            $table->integer('userid');
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
        Schema::dropIfExists('number_prefixes');
    }
}
