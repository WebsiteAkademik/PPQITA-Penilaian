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
            $table->string('no_pendaftaran')->index();
            //$table->foreignId('no_pendaftaran')->references('no_pendaftaran')->on('pendaftars');
            $table->date('tanggal_test');
            $table->time('jam_test');
            $table->string('metode_test');
            $table->text('info_test');
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
