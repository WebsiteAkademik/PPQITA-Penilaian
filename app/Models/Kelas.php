<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ['kelas', 'mata_pelajaran_id'];

    public function matapelajaran()
    {
        return $this->belongsToMany(MataPelajaran::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
