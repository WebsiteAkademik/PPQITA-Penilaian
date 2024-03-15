<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianPelajaran extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal_penilaian', 'siswa_id', 'kelas_id', 'mata_pelajaran_id', 'nilai', 'keterangan', 'pengajar_id', 'tahun_ajaran_id'];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
    
    public function Kelas()
    {
        return $this->belongsToMany(Siswa::class);
    }
    public function mataPelajaran()
    {
        return $this->belongsToMany(MataPelajaran::class);
    }
    
    public function Siswa()
    {
        return $this->belongsToMany(Siswa::class);
    }

    public function pengajar()
    {
        return $this->belongsToMany(Pengajar::class);
    }

    public function detailSetupMataPelajaran()
    {
        return $this->belongsTo(DetailSetupMataPelajaran::class);
    }

    public function setupMataPelajaran()
    {
        return $this->belongsTo(SetupMataPelajaran::class, 'setup_mata_pelajaran_id');
    }

    public function tahunID(){
        return TahunAjaran::where("id", $this->tahun_ajaran_id)->first();
    }

    public function kelasID(){
        return Kelas::where("id", $this->kelas_id)->first();
    }

    public function mapelID(){
        return MataPelajaran::where("id", $this->mata_pelajaran_id)->first();
    }

    public function siswaID(){
        return Siswa::where("id", $this->siswa_id)->first();
    }
}
