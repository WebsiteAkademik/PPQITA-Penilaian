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
            $table->string('no_pendaftaran', 64)->after("id");
            $table->enum('jenis_kelamin', ['LAKI-LAKI', 'PEREMPUAN'])->after("tanggal_lahir");
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
            $table->dropColumn('no_pendaftaran');
            $table->dropColumn('jenis_kelamin');
        });
    }
};
