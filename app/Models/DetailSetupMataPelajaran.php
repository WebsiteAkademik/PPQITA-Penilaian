<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSetupMataPelajaran extends Model
{
    use HasFactory;

    protected $fillable = ['jam_pelajaran', 'kkm', 'setup_mata_pelajaran_id', 'mata_pelajaran_id', 'tahun_ajaran_id'];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function setupMataPelajaran()
    {
        return $this->belongsTo(SetupMataPelajaran::class);
    }

    public function mapelID(){
        return MataPelajaran::where("id", $this->mata_pelajaran_id)->first();
    }

}
