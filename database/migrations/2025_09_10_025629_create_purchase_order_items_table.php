<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_order_id');
            $table->string('purchase_order_number');
            $table->integer('product_id');
            $table->string('tebal');
            $table->string('lebar');
            $table->string('panjang');
            $table->integer('quantity');
            $table->integer('quantity_received')->nullable();
            $table->integer('quantity_outstanding')->nullable();
            $table->string('satuan');
            $table->string('weight');
            $table->string('weight_received')->nullable();
            $table->string('weight_outstanding')->nullable();
            $table->integer('price');
            $table->integer('tax')->nullable();
            $table->integer('price_before_tax');
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
        Schema::dropIfExists('purchase_order_items');
    }
}
