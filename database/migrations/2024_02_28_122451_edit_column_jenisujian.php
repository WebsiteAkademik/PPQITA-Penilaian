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
        Schema::table('jadwal_ujians', function (Blueprint $table) {
            $table->dropColumn('jenis_ujian');
        });
        
        Schema::table('jadwal_ujians', function (Blueprint $table) {
            $table->enum('jenis_ujian', ['Penilaian Harian', 'UTS', 'UAS'])->after('ruang_ujian');
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
            $table->dropColumn('jenis_ujian');
    });
        
        Schema::table('jadwal_ujians', function (Blueprint $table) {
            $table->string('jenis_ujian')->after('ruang_ujian');
        });
    }
};
