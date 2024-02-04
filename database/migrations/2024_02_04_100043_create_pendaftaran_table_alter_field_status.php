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
            $table->dropColumn("status");
        });

        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->enum('status', ['BARU', 'MENUNGGU', 'TEST', 'DITERIMA', 'DITOLAK'])->default('BARU');
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
            $table->dropColumn("status");
        });
        
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->enum('status', ['BARU', 'TEST', 'DITERIMA', 'DITOLAK'])->default('BARU');
        });
    }
};
