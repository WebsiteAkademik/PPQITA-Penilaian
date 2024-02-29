<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupMataPelajaran extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal_setup', 'kelas_id', 'pengajar_id', 'tahun_ajaran_id'];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function detailSetupMataPelajaran()
    {
        return $this->hasOne(DetailSetupMataPelajaran::class);
    }

    public function tahunajaranID(){
        return TahunAjaran::where("id", $this->tahun_ajaran_id)->first();
    }

    public function pengajarID(){
        return Pengajar::where("id", $this->pengajar_id)->first();
    }

    public function kelasID(){
        return Kelas::where("id", $this->kelas_id)->first();
    }
}
