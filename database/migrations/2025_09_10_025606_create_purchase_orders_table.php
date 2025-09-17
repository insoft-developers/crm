<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_request_id');
            $table->string('purchase_request_number');
            $table->string('purchase_order_number');
            $table->integer('vendor_id');
            $table->integer('vendor_address_id');
            $table->date('purchase_order_date');
            $table->string('product_category');
            $table->integer('payment_method');
            $table->integer('delivery_method');
            $table->string('description');
            $table->integer('status');
            $table->integer('is_approve_1')->nullable();
            $table->integer('is_approve_2')->nullable();
            $table->integer('quantity_total');
            $table->integer('weight_total');
            $table->string('rejection_note_1')->nullable();
            $table->string('rejection_note_2')->nullable();
            $table->integer('subtotal')->nullable();
            $table->integer('total_tax')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('request_user_id');
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
        Schema::dropIfExists('purchase_orders');
    }
}
