<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodReceiveItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_receive_items', function (Blueprint $table) {
            $table->id();
            $table->integer('gr_id');
            $table->string('sp_number');
            $table->date('delivery_date');
            $table->date('arrive_date');
            $table->string('coil_number');
            $table->integer('product_id');
            $table->string('tebal');
            $table->string('lebar');
            $table->string('panjang');
            $table->integer('quantity');
            $table->integer('quantity_received');
            $table->integer('quantity_outstanding');
            $table->integer('weight');
            $table->integer('weight_received');
            $table->integer('weight_outstanding');
            $table->string('satuan');
            $table->string('location');
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
        Schema::dropIfExists('good_receive_items');
    }
}
