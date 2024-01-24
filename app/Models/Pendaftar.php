<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_pendaftaran',
        'no_nisn',
        'nama_calon_siswa',
        'program_keahlian',
        'tempat_lahir',
        'tanggal_lahir',
        'no_induk_keluarga',
        'no_kartu_keluarga',
        'jenis_kelamin',
        'agama',
        'tinggi_badan',
        'berat_badan',
        'bertato',
        'penyakit_kronis',
        'asal_sekolah',
        'alamat_rumah',
        'dukuh',
        'kalurahan',
        'kecamatan',
        'kabupaten',
        'kodepos',
        'nama_ayah',
        'pekerjaan_ibu',
        'nama_ibu',
        'pekerjaan_ayah',        
        'penghasilan_per_bulan',
        'ayah_hidup',
        'ibu_hidup',
        'no_telepon',
        'no_telepon_ortu',
        'informasi_pmb',
        'status',
        'slug',
        'user_name',
        'password',
    ];
}
