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
        Schema::table('penilaian_pelajarans', function ($table) {
            $table->enum('jenis_ujian', ['Penilaian Harian', 'UTS', 'UAS'])->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaian_pelajarans', function (Blueprint $table) {
            $table->dropColumn('jenis_ujian');
        });
    }
};
