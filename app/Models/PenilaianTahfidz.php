<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianTahfidz extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal_penilaian', 'siswa_id', 'kelas_id', 'mata_pelajaran_id', 'jenis_penilaian', 'surat_awal', 'surat_akhir', 'ayat_awal', 'ayat_akhir', 'nilai', 'keterangan', 'pengajar_id', 'tahun_ajaran_id'];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
    
    public function Kelas()
    {
        return $this->belongsToMany(Siswa::class);
    }
    public function mataPelajaran()
    {
        return $this->belongsToMany(MataPelajaran::class);
    }
    
    public function Siswa()
    {
        return $this->belongsToMany(Siswa::class);
    }

    public function pengajar()
    {
        return $this->belongsToMany(Pengajar::class);
    }
}
