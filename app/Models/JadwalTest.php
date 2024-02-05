<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pendaftaran;

class JadwalTest extends Model
{
    use HasFactory;

    protected $fillable = ['pendaftaran_id', 'tanggal_test', 'jam_test', 'jenis_test', 'pic_test'];

    public function pendaftaran(){
        return Pendaftaran::where("id", $this->pendaftaran_id)->first();
    }
};
