<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajar extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pengajar', 'alamat', 'no_wa_pengajar', 'mata_pelajaran_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function mataPelajaran()
    {
        return $this->hasMany(MataPelajaran::class);
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
