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
        Schema::table('detail_setup_mata_pelajarans', function ($table) {
            $table->dropColumn('pengajar_id');
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_setup_mata_pelajarans', function ($table) {
            $table->unsignedBigInteger('pengajar_id')->after('mata_pelajaran_id');
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropColumn('tahun_ajaran_id');
        });
        
        Schema::table('detail_setup_mata_pelajarans', function ($table) {
            $table->unsignedBigInteger('tahun_ajaran_id')->after('pengajar_id');
        });
    }
};
