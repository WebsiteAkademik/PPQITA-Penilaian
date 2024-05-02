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
        Schema::table('penilaian_pelajarans', function (Blueprint $table) {
            $table->string('semester')->after('tanggal_penilaian');
        });
        Schema::table('penilaian_tahfidzs', function (Blueprint $table) {
            $table->string('semester')->after('tanggal_penilaian');
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
            $table->dropColumn('semester');
        });
        Schema::table('penilaian_tahfidzs', function (Blueprint $table) {
            $table->dropColumn('semester');
        });
    }
};
