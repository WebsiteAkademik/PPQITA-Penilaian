<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $fillable = ['tahun_ajaran', 'status'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function kategoriPelajarans()
    {
        return $this->hasMany(KategoriPelajaran::class);
    }
    
    public function subKategoriPelajarans()
    {
        return $this->hasMany(SubKategoriPelajaran::class);
    }
}