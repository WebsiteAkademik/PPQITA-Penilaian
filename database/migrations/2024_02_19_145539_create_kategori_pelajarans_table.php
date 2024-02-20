<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriPelajaransTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('kategori_pelajarans')) {
            Schema::create('kategori_pelajarans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tahun_ajaran_id')->constrained()->onDelete('cascade');
                $table->string('kode_kategori', 10)->unique();
                $table->string('nama_kategori', 50)->unique();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_pelajarans');
    }
};