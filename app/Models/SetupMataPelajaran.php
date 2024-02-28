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
}
