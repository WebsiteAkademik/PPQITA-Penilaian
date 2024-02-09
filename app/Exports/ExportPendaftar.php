<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class ExportPendaftar implements FromCollection,WithHeadings
{
    protected $pendaftars;

    public function headings():array{
        return[
            'No. Pendaftaran',
            'NISN',
            'Nama Calon Siswa',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'No. KK',
            'No. WA Siswa',
            'Penyakit yang diderita',
            'Alamat Rumah',
            'Dukuh',
            'Kelurahan',
            'Kecamatan',
            'Kabupaten/Kota',
            'Kode Pos',
            'Asal Sekolah',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'No. Telp Ortu',
            'Penghasilan Ortu perbulan',
            'Informasi dari',
            'Created At',
            'Update At',
            'Status' 
        ];
    }

    public function __construct(Collection $pendaftars)
    {
        $this->pendaftars = $pendaftars;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->pendaftars->makeHidden(['id', 'user_id', 'tinggi_badan', 'berat_badan', 'ayah_hidup', 'ibu_hidup']);
    }
}
