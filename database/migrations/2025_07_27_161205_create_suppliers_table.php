<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->string('nama_perusahaan'); // Nama supplier/perusahaan
            $table->string('nama_penanggung_jawab')->nullable(); // Bisa jadi contact person
            $table->string('alamat');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('provinsi');
            $table->integer('kota');
            $table->integer('kecamatan');
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('email_contact_person')->nullable();

            $table->string('npwp')->nullable();
            $table->string('no_ktp')->nullable();
            $table->text('description')->nullable(); // keterangan tambahan

            // Informasi Rekening
            $table->string('bank_account_number')->nullable();
            $table->string('account_owner')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_account')->nullable();

            // Akun-akun khusus
            $table->integer('akun_hutang')->nullable(); // akun untuk hutang ke supplier

            // Jika pakai limit pembelian ke supplier
            $table->integer('limit_hutang')->nullable();

            $table->integer('status')->nullable(); // aktif/nonaktif
            $table->integer('userid'); // user yang menambahkan

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
        Schema::dropIfExists('suppliers');
    }
}
