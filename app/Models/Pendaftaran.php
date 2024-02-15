<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pendaftaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_pendaftaran',
        'user_id',
        'no_nisn',
        'nama_calon_siswa',
        'program_keahlian',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'tinggi_badan',
        'no_kartu_keluarga',
        'no_induk_keluarga',
        'agama',
        'no_wa_anak',
        'berat_badan',
        'bertato',
        'alamat_rumah',
        'penyakit_kronis',
        'kelurahan',
        'dukuh',
        'kabupaten',
        'kecamatan',
        'asal_sekolah',
        'kodepos',
        'nama_ayah',
        'ayah_hidup',
        'ibu_hidup',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'nama_ibu',
        'informasi_pmb',
        'no_telepon_ortu',
        'penghasilan_per_bulan',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function printedStatus(){
        $STATUS = [
            "BARU" => "Menunggu",
            "MENUNGGU" => "Menunggu",
            "TEST" => "Test",
            "DITERIMA" => "Diterima",
            "DITOLAK" => "Tidak Diterima",
        ];

        return $STATUS[$this->status];
    }

    public function printedStatusDashboard(){
        $STATUS = [
            "BARU" => "Baru",
            "MENUNGGU" => "Menunggu",
            "TEST" => "Test",
            "DITERIMA" => "Diterima",
            "DITOLAK" => "Tidak Diterima",
        ];

        return $STATUS[$this->status];
    }

    public function  updateStatusBaru(){
        $this->update([
            'status' => "BARU",
        ]);
    }

    public function  updateStatusMenunggu(){
        $this->update([
            'status' => "MENUNGGU",
        ]);
    }

    public function  updateStatusTest(){
        $this->update([
            'status' => "TEST",
        ]);
    }

    public function  updateStatusDiterima(){
        $this->update([
            'status' => "DITERIMA",
        ]);
    }

    public function  updateStatusDitolak(){
        $this->update([
            'status' => "DITOLAK",
        ]);
    }
}
