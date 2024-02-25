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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('no_nisn', 30);
            $table->string('nama_siswa', 64);
            $table->string('tempat_lahir', 64);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['LAKI-LAKI', 'PEREMPUAN']);
            $table->string('no_kartu_keluarga', 32);
            $table->string('no_induk_keluarga', 64);
            $table->string('agama', 20);
            $table->integer('tinggi_badan');
            $table->integer('berat_badan');
            $table->string('no_wa_anak', 20);
            $table->string('penyakit_kronis', 256);
            $table->string('alamat_rumah', 256);
            $table->string('dukuh', 64);
            $table->string('kelurahan', 64);
            $table->string('kecamatan', 64);
            $table->string('kabupaten', 64);
            $table->string('kodepos', 10);
            $table->string('asal_sekolah', 64);
            $table->boolean('ayah_hidup');
            $table->string('nama_ayah', 64);
            $table->string('pekerjaan_ayah', 64);
            $table->boolean('ibu_hidup');
            $table->string('nama_ibu', 64);
            $table->string('pekerjaan_ibu', 256);
            $table->string('no_telepon_ortu', 20);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('siswas');
    }
};
