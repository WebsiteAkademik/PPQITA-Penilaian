<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKategoriPelajaran extends Model
{
    use HasFactory;

    protected $fillable = ['kode_sub_kategori', 'nama_sub_kategori', 'kategori_id', 'tahun_ajaran_id'];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
    
    public function kategoriPelajaran()
    {
        return $this->belongsTo(KategoriPelajaran::class);
    }

    public function mataPelajaran()
    {
        return $this->hasMany(MataPelajaran::class);
    }

    public function kategoriID(){
        return KategoriPelajaran::where("id", $this->kategori_id)->first();
    }
}
