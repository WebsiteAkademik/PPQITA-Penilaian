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
        if (!Schema::hasTable('mata_pelajarans')) {
            Schema::create('detail_setup_mata_pelajarans', function (Blueprint $table) {
                $table->id();
                $table->time('jam_pelajaran');
                $table->integer('kkm');
                $table->foreignId('setup_mata_pelajaran_id')->constrained()->onDelete('cascade');
                $table->foreignId('mata_pelajaran_id')->constrained()->onDelete('cascade');
                $table->foreignId('pengajar_id')->constrained()->onDelete('cascade');
                $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_setup_mata_pelajarans');
    }
};