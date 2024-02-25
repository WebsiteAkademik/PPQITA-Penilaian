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
        Schema::table('sub_kategori_pelajarans', function (Blueprint $table) {
            $table->foreign('kategori_id')->references('id')->on('kategori_pelajarans')->onDelete('cascade');
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
        Schema::table('sub_kategori_pelajarans', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['tahun_ajaran_id']);
        });
    }
};
