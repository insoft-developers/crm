<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id'); // cabang tempat bekerja
            $table->string('nama_lengkap'); // nama lengkap karyawan
            $table->string('nik')->nullable(); // nomor induk pegawai, opsional
            $table->string('jabatan'); // posisi/jabatan
            $table->string('departemen')->nullable(); // divisi atau departemen
            $table->text('alamat'); // alamat tempat tinggal
            $table->string('latitude')->nullable(); // opsional: koordinat lokasi
            $table->string('longitude')->nullable();

            $table->integer('provinsi');
            $table->integer('kota');
            $table->integer('kecamatan');
            $table->string('postal_code')->nullable();

            $table->string('phone')->nullable(); // nomor HP
            $table->string('phone2')->nullable(); // nomor alternatif
            $table->string('email')->nullable(); // email pribadi atau kerja

            $table->string('no_ktp')->nullable(); // KTP
            $table->string('npwp')->nullable(); // NPWP jika ada
            $table->date('tanggal_lahir')->nullable();
            $table->date('tanggal_masuk')->nullable(); // tanggal mulai kerja
            $table->string('status_karyawan')->nullable(); // kontrak, tetap, freelance, dll

            $table->text('description')->nullable(); // keterangan tambahan

            // Informasi Rekening untuk gaji
            $table->string('bank_account_number')->nullable();
            $table->string('account_owner')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_account')->nullable();

            // Informasi akun jika digunakan
            $table->string('foto')->nullable();
            $table->integer('status')->nullable(); // aktif/nonaktif
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
        Schema::dropIfExists('karyawans');
    }
}
