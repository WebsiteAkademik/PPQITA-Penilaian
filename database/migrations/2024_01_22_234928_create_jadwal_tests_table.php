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
        Schema::create('jadwal_tests', function (Blueprint $table) {
            $table->id();
            $table->string('nama_calon_siswa')->index();
            $table->date('tanggal_test');
            $table->time('jam_test');
            $table->string('jenis_test');
            $table->text('pic_test');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_tests');
    }
};