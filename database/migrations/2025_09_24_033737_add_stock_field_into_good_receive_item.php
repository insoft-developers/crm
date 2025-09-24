<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStockFieldIntoGoodReceiveItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('good_receive_items', function (Blueprint $table) {
            $table->string('massa')->nullable()->after('location');
            $table->integer('weight_actual')->after('massa')->nullable();
            $table->string('note')->after('weight_actual')->nullable();
            $table->integer('stock_status')->after('note')->nullable();
            $table->string('remark')->after('stock_status')->nullable();
            $table->string('tebal_actual')->after('remark')->nullable();
            $table->integer('weight_return')->after('tebal_actual')->nullable();
            $table->datetime('return_date')->nullable()->after('weight_return');
            
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
