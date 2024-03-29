<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $fillable = ['kode_mata_pelajaran', 'nama_mata_pelajaran', 'kkm', 'sub_kategori_pelajaran_id', 'kategori_pelajaran_id', 'tahun_ajaran_id'];

    public function pengajar()
    {
        return $this->belongsTo(Pengajar::class);
    }
    
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
    
    public function kategoriPelajaran()
    {
        return $this->belongsTo(KategoriPelajaran::class);
    }

    public function kategoriID(){
        return KategoriPelajaran::where("id", $this->kategori_pelajaran_id)->first();
    }

    public function subKategoriPelajaran()
    {
        return $this->belongsTo(SubKategoriPelajaran::class);
    }

    public function subkategoriID(){
        return SubKategoriPelajaran::where("id", $this->sub_kategori_pelajaran_id)->first();
    }

    public function setupMataPelajaran()
    {
        return $this->hasMany(SetupMataPelajaran::class);
    }

    public function detailSetupMataPelajaran()
    {
        return $this->hasMany(DetailSetupMataPelajaran::class);
    }
    
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class);
    }
    
    public function penilaianTahfidz()
    {
        return $this->belongsToMany(PenilaianTahfidz::class);
    }
    
    public function penilaianPelajaran()
    {
        return $this->belongsToMany(PenilaianPelajaran::class);
    }
}
