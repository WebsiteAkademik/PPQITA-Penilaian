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
        Schema::create('penilaian_tahfidzs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_penilaian');
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained()->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained()->onDelete('cascade');
            $table->enum('jenis_penilaian', ['Setoran Baru', 'Hafalan Sugra', 'Hafalan Qubra', 'Tasmik']);
            $table->integer('surat_awal');
            $table->integer('surat_akhir');
            $table->integer('ayat_awal');
            $table->integer('ayat_akhir');
            $table->decimal('nilai', 4, 2);
            $table->string('keterangan', 255);
            $table->foreignId('pengajar_id')->constrained()->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->onDelete('cascade');
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
        Schema::dropIfExists('penilaian_tahfidzs');
    }
};
