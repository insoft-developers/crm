<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustFieldGoodReceive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('good_receives', function (Blueprint $table) {
            $table->string('contract_number')->nullable()->change();
            $table->string('sp_number')->after('contract_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('good_receives', function (Blueprint $table) {
            //
        });
    }
}
