<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pr_number');
            $table->string('product_category');
            $table->date('request_date');
            $table->string('description')->nullable();
            $table->integer('request_user_id');
            $table->integer('status')->nullable();
            $table->integer('is_approve_1')->nullable();
            $table->integer('is_approve_2')->nullable();
            $table->integer('userid');
            $table->integer('quantity_total');
            $table->integer('weight_total');
            $table->string('rejection_note_1')->nullable();
            $table->string('rejection_note_2')->nullable();
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
        Schema::dropIfExists('purchase_requests');
    }
}
