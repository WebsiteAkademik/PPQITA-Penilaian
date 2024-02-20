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
        if (!Schema::hasTable('sub_kategori_pelajarans')) {
            Schema::create('sub_kategori_pelajarans', function (Blueprint $table) {
                $table->id();
                $table->string('kode_sub_kategori', 20)->unique();
                $table->string('nama_sub_kategori', 60)->unique();
                $table->foreignId('kategori_pelajaran_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('sub_kategori_pelajarans');
    }
};
