<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $fillable = ['kode_mata_pelajaran', 'nama_mata_pelajaran', 'kkm', 'sub_kategori_pelajaran_id', 'kategori_pelajaran_id', 'tahun_ajaran_id'];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
    
    public function kategoriPelajaran()
    {
        return $this->belongsTo(KategoriPelajaran::class);
    }

    public function subKategoriPelajaran()
    {
        return $this->belongsTo(SubKategoriPelajaran::class);
    }

    public function setupMataPelajaran()
    {
        return $this->hasMany(SetupMataPelajaran::class);
    }
    
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class);
    }
    
    public function penilaianTahfidz()
    {
        return $this->belongsToMany(PenilaianTahfidz::class);
    }
}
