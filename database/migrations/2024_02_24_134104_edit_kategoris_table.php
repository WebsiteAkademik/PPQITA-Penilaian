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
        if (!Schema::hasTable('kategori_pelajarans')) {
            Schema::create('kategori_pelajarans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tahun_ajaran_id')->constrained()->onDelete('cascade');
                $table->string('kode_kategori', 10)->unique();
                $table->string('nama_kategori', 50);
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
        Schema::table('kategori_pelajarans', function (Blueprint $table) {
            Schema::dropIfExists('kategori_pelajarans');
        });
    }
};