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
        Schema::table('penilaian_tahfidzs', function (Blueprint $table) {
            $table->string('surat_awal')->after('jenis_penilaian');
            $table->string('surat_akhir')->after('surat_awal');
            $table->string('ayat_awal')->after('surat_akhir');
            $table->string('ayat_akhir')->after('ayat_awal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaian_tahfidzs', function (Blueprint $table) {
            $table->dropColumn('surat_awal');
            $table->dropColumn('surat_akhir');
            $table->dropColumn('ayat_awal');
            $table->dropColumn('ayat_akhir');
        });
    }
};
