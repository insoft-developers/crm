<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsIntoCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->date('tanggal_lahir')->nullable()->after('alamat');
            $table->string('tempat_lahir')->nullable()->after('tanggal_lahir');
            $table->string('nama_tagihan')->nullable()->after('nama_lengkap');
            $table->string('kontak_tagihan')->nullable()->after('nama_tagihan');
            $table->string('alamat_tagihan')->nullable()->after('kontak_tagihan');

            $table->string('nama_penanggung_jawab')->nullable()->after('alamat_tagihan');
            $table->string('jabatan_penanggung_jawab')->nullable()->after('nama_penanggung_jawab');
            $table->string('kontak_penanggung_jawab')->nullable()->after('jabatan_penanggung_jawab');
            $table->string('email_penanggung_jawab')->nullable()->after('kontak_penanggung_jawab');
            $table->string('bank_code')->nullable()->after('branch_account');
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
