<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalTestsTableBaru extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('jadwal_tests');
        Schema::create('jadwal_tests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pendaftaran_id')->unsigned()->index();
            $table->foreign('pendaftaran_id')->references('id')->on('pendaftarans')->onDelete('cascade');
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
        Schema::create('jadwal_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('no_pendaftaran')->index();
            $table->date('tanggal_test');
            $table->time('jam_test');
            $table->string('jenis_test');
            $table->text('pic_test');
            $table->timestamps();
        });
    }
}
