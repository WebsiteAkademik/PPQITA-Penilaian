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
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn('kelas');
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->string('kelas')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn('kelas');
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->enum('kelas', ['1', '2', '3'])->after('id');
        });
    }
};
