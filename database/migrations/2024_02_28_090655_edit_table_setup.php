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
        Schema::table('setup_mata_pelajarans', function (Blueprint $table) {
            $table->unsignedBigInteger('kelas_id')->nullable()->after('tanggal_setup');
            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->unsignedBigInteger('pengajar_id')->nullable()->after('kelas_id');
            $table->foreign('pengajar_id')->references('id')->on('pengajars');
            $table->dropForeign(['mata_pelajaran_id']);
            $table->dropColumn('mata_pelajaran_id');
            $table->dropForeign(['sub_kategori_pelajaran_id']);
            $table->dropColumn('sub_kategori_pelajaran_id');
            $table->dropForeign(['kategori_pelajaran_id']);
            $table->dropColumn('kategori_pelajaran_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setup_mata_pelajarans', function (Blueprint $table) {
            $table->unsignedBigInteger('mata_pelajaran_id')->nullable()->after('tanggal_setup');
            $table->foreign('mata_pelajaran_id')->references('id')->on('mata_pelajarans'); 
            $table->unsignedBigInteger('sub_kategori_pelajaran_id')->nullable()->after('mata_pelajaran_id');
            $table->foreign('sub_kategori_pelajaran_id')->references('id')->on('sub_kategori_pelajarans'); 
            $table->unsignedBigInteger('kategori_pelajaran_id')->nullable()->after('sub_kategori_pelajaran_id');
            $table->foreign('kategori_pelajaran_id')->references('id')->on('kategori_pelajarans');
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
            $table->dropForeign(['pengajar_id']);
            $table->dropColumn('pengajar_id');
        });
    }
};
