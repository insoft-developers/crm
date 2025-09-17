<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_code');
            $table->string('vendor_name');
            $table->string('nama_tagihan');
            $table->string('kontak_tagihan');
            $table->string('alamat_tagihan');
            $table->string('nama_penanggung_jawab')->nullable();
            $table->string('jabatan_penanggung_jawab')->nullable();
            $table->string('kontak_penanggung_jawab')->nullable();
            $table->string('email_penanggung_jawab')->nullable();
            $table->string('vendor_type')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('provinsi');
            $table->integer('kota');
            $table->integer('kecamatan');
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email');
            $table->integer('status');
            $table->string('vendor_grade')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('npwp')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('account_owner')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_account')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('foto')->nullable();
            $table->integer('balance')->nullable();
            $table->date('tanggal_aktif')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
