<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajar extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pengajar', 'alamat', 'no_wa_pengajar', 'user_id'];

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

    public function mapelID(){
        return MataPelajaran::where("id", $this->mata_pelajaran_id)->first();
    }
}
