<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodReceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_receives', function (Blueprint $table) {
            $table->id();
            $table->integer('po_id');
            $table->string('po_number');
            $table->string('gr_number');
            $table->integer('vendor_id');
            $table->string('contract_number');
            $table->integer('warehouse_id');
            $table->string('mills');
            $table->string('product_category');
            $table->integer('total_quantity');
            $table->integer('total_weight');
            $table->integer('good_status');
            $table->integer('status')->default(1);
            $table->date('gr_date');
            $table->date('due_date');
            $table->integer('payment_method_id');
            $table->integer('delivery_method_id');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('good_receives');
    }
}
