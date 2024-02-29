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
        Schema::table('jadwal_ujians', function ($table) {
            $table->dropForeign(['siswa_id']);
            $table->dropColumn('siswa_id');
            $table->dropForeign(['pengajar_id']);
            $table->dropColumn('pengajar_id');
            $table->dropColumn('ruang_ujian');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jadwal_ujians', function (Blueprint $table) {
            $table->unsignedBigInteger('siswa_id')->nullable()->after('id');
            $table->foreign('siswa_id')->references('id')->on('siswas');
            $table->unsignedBigInteger('pengajar_id')->nullable()->after('kelas_id');
            $table->foreign('pengajar_id')->references('id')->on('pengajars');
            $table->string('ruang_ujian')->after('jam_ujian');
        });
    }
};
