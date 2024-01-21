<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalTest extends Model
{
    use HasFactory;

    protected $fillable = ['no_pendaftaran', 'tanggal_test', 'jam_test', 'metode_test', 'info_test'];

    public function pendaftar(){
        return $this->belongsTo(Pendaftar::class, 'no_pendaftaran');
    }
};
