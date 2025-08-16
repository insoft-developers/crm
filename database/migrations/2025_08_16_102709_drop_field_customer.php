<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropFieldCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('alamat');
            $table->dropColumn('phone2');
            $table->dropColumn('contact_person');
            $table->dropColumn('email_contact_person');
            $table->dropColumn('contact_person_phone');
            $table->dropColumn('contact_person_phone2');
            $table->dropColumn('akun_hutang');
            $table->dropColumn('akun_piutang');
            $table->dropColumn('akun_piutang_sementara');
            $table->dropColumn('limit_hutang');
            $table->dropColumn('npwp_induk');
            $table->dropColumn('description');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
}
