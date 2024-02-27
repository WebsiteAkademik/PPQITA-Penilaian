<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalUjian extends Model
{
    use HasFactory;

    protected $fillable = ['siswa_id', 'tanggal_ujian', 'jam_ujian', 'ruang_ujian', 'jenis_ujian', 'mata_pelajaran_id', 'kelas_id', 'pengajar_id', 'tahun_ajaran_id'];

    public function siswa(){
        return Siswa::where("id", $this->siswa_id)->first();
    }
    
    public function mataPelajaran(){
        return MataPelajaran::where("id", $this->mata_pelajaran_id)->first();
    }
    
    public function kelas(){
        return Kelas::where("id", $this->kelas_id)->first();
    }
    
    public function pengajar(){
        return Pengajar::where("id", $this->pengajar_id)->first();
    }
    
    public function tahunAjaran(){
        return TahunAjaran::where("id", $this->tahun_ajaran_id)->first();
    }
}
