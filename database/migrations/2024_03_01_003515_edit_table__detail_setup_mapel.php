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
        Schema::table('detail_setup_mata_pelajarans', function ($table) {
            $table->dropColumn('jam_pelajaran');
        });
        
        Schema::table('detail_setup_mata_pelajarans', function ($table) {
            $table->integer('jam_pelajaran')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_setup_mata_pelajarans', function ($table) {
            $table->dropColumn('jam_pelajaran');
        });

        Schema::table('detail_setup_mata_pelajarans', function ($table) {
            $table->time('jam_pelajaran')->after('id');
        });
    }
};
