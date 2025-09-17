<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->string('nama_lengkap');
            $table->string('customer_type');
            $table->string('alamat');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('provinsi');
            $table->integer('kota');
            $table->integer('kecamatan');
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email');
            $table->string('contact_person')->nullable();
            $table->string('email_contact_person')->nullable();
            $table->integer('status')->nullable();
            $table->integer('akun_hutang')->nullable();
            $table->integer('akun_piutang')->nullable();
            $table->integer('akun_piutang_sementara')->nullable();
            $table->integer('limit_hutang')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('npwp_induk')->nullable();
            $table->string('npwp')->nullable();
            $table->text('description')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('account_owner')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_account')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
