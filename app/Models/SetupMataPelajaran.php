<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupMataPelajaran extends Model
{
    use HasFactory;

    protected $fillable = ['mata_pelajaran_id', 'sub_kategori_pelajaran_id', 'kategori_pelajaran_id', 'tahun_ajaran_id'];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
}
