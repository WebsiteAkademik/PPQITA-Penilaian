<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_nisn',
        'nama_siswa',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_kartu_keluarga',
        'no_induk_keluarga',
        'agama',
        'tinggi_badan',
        'berat_badan',
        'no_wa_anak',
        'penyakit_kronis',
        'alamat_rumah',
        'dukuh',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'kodepos',
        'asal_sekolah',
        'ayah_hidup',
        'nama_ayah',
        'pekerjaan_ayah',
        'ibu_hidup',
        'nama_ibu',
        'pekerjaan_ibu',
        'no_telepon_ortu',
        'kelas_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    
    public function penilaianTahfidz()
    {
        return $this->belongsTo(PenilaianTahfidz::class);
    }
}
