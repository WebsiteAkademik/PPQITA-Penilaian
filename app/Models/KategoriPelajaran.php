<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPelajaran extends Model
{
    use HasFactory;

    protected $fillable = ['tahun_ajaran_id', 'kode_kategori', 'nama_kategori'];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
    
    public function subKategoriPelajaran()
    {
        return $this->hasMany(SubKategoriPelajaran::class);
    }

    public function mataPelajaran()
    {
        return $this->hasMany(MataPelajaran::class);
    }
}
