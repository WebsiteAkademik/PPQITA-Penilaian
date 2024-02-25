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
        \Illuminate\Support\Facades\DB::statement("
            INSERT INTO siswas (no_nisn, nama_siswa, tempat_lahir, tanggal_lahir, jenis_kelamin, no_kartu_keluarga, no_induk_keluarga, agama, tinggi_badan, berat_badan, no_wa_anak, penyakit_kronis, alamat_rumah, dukuh, kelurahan, kecamatan, kabupaten, kodepos, asal_sekolah, ayah_hidup, nama_ayah, pekerjaan_ayah, ibu_hidup, nama_ibu, pekerjaan_ibu, no_telepon_ortu, user_id, created_at, updated_at)
            SELECT no_nisn, nama_calon_siswa, tempat_lahir, tanggal_lahir, jenis_kelamin, no_kartu_keluarga, no_induk_keluarga, agama, tinggi_badan, berat_badan, no_wa_anak, penyakit_kronis, alamat_rumah, dukuh, kelurahan, kecamatan, kabupaten, kodepos, asal_sekolah, ayah_hidup, nama_ayah, pekerjaan_ayah, ibu_hidup, nama_ibu, pekerjaan_ibu, no_telepon_ortu, user_id, NOW(), NOW()
            FROM pendaftarans
            WHERE status = 'DITERIMA';
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
