<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pendaftaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'no_nisn',
        'nama_calon_siswa',
        'tempat_lahir',
        'tanggal_lahir',
        'tinggi_badan',
        'no_kartu_keluarga',
        'no_wa_anak',
        'berat_badan',
        'alamat_rumah',
        'penyakit_kronis',
        'kelurahan',
        'dukuh',
        'kabupaten',
        'kecamatan',
        'asal_sekolah',
        'kodepos',
        'nama_ayah',
        'ayah_hidup',
        'ibu_hidup',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'nama_ibu',
        'informasi_pmb',
        'no_telepon_ortu',
        'penghasilan_per_bulan',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
