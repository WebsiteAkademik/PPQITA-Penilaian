<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalTest extends Model
{
    use HasFactory;

    protected $fillable = ['nama_calon_siswa', 'tanggal_test', 'jam_test', 'jenis_test', 'pic_test'];

    public function pendaftar(){
        return $this->belongsTo(Pendaftar::class, 'nama_calon_siswa');
    }
};
