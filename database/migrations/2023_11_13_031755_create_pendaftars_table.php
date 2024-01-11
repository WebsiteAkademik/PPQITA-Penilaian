<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            // Data Maba
            $table->string('no_pendaftaran', 50);
            $table->char('no_nisn', 16);
            $table->string('nama_calon_siswa', 100)->nullable();
            $table->string('program_keahlian', 100)->nullable();
            $table->string('tempat_lahir',100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_induk_keluarga',100)->nullable();
            $table->string('no_kartu_keluarga',100)->nullable();
            $table->integer('jenis_kelamin')->nullable();
            $table->string('agama', 59)->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->integer('bertato')->nullable();
            $table->string('penyakit_kronis', 200)->nullable();
            $table->string('asal_sekolah', 1000)->nullable();
            $table->string('alamat_rumah', 1000)->nullable();
            $table->string('dukuh', 100)->nullable();
            $table->string('kalurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->string('kodepos', 100)->nullable();
            $table->integer('ayah_hidup')->nullable();
            $table->integer('ibu_hidup')->nullable();
            $table->string('nama_ayah', 50)->nullable();
            $table->string('pekerjaan_ayah', 50)->nullable();
            $table->string('nama_ibu', 50)->nullable();
            $table->string('pekerjaan_ibu', 50)->nullable();
            $table->string('penghasilan_per_bulan', 100)->nullable();
            $table->char('no_telepon', 20)->nullable();
            $table->char('no_telepon_ortu', 20)->nullable();
            $table->string('informasi_pmb', 50)->nullable();
            $table->char('user_name', 20)->nullable();
            $table->String('password', 500)->nullable();
            $table->string('status', 50);
            $table->string('slug', 1000);
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
        Schema::dropIfExists('pendaftars');
    }
};
