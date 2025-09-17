<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIntoPurchaeRequestItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_request_items', function (Blueprint $table) {
            $table->integer('quantity_po')->nullable()->after('quantity');
            $table->integer('quantity_outstanding')->nullable()->after('quantity_po');
            $table->string('weight_po')->nullable()->after('weight');
            $table->string('weight_outstanding')->nullable()->after('weight_po');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_request_items', function (Blueprint $table) {
            //
        });
    }
}
