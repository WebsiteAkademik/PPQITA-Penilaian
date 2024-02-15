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
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string("program_keahlian", 120)->after("nama_calon_siswa");
        });
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string("no_induk_keluarga", 64)->after("no_kartu_keluarga");
        });
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string("agama", 20)->after("no_induk_keluarga");
        });
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string("bertato", 5)->after("berat_badan");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn('program_keahlian');
            $table->dropColumn('no_induk_keluarga');
            $table->dropColumn('agama');
            $table->dropColumn('bertato');
        });
    }
};
