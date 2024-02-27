<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ['kelas'];

    public function matapelajaran()
    {
        return $this->belongsToMany(MataPelajaran::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
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
