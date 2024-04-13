<?php

namespace App\Exports;

use App\Models\PenilaianPelajaran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportRekapNilai implements FromCollection, WithHeadings
{
    protected $rekapNilai;
    protected $mapel;
    protected $rataRataKelas;

    public function __construct(Collection $rekapNilai, $mapel, $rataRataKelas)
    {
        $this->rekapNilai = $rekapNilai;
        $this->mapel = $mapel;
        $this->rataRataKelas = $rataRataKelas;
    }

    public function headings(): array
    {
        // Sesuaikan heading dengan struktur yang diinginkan
        $headings = [
            'No.',
            'Nama Siswa',
        ];

        // Ambil nama mata pelajaran dari rekap nilai pertama sebagai referensi
        foreach ($this->mapel as $mapel) {
            $headings[] = $mapel->nama_mata_pelajaran;
        }

        $headings[] = 'Rata-Rata';

        return $headings;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->rekapNilai as $index => $rekap) {
            $rowData = [
                $index + 1,
                $rekap['siswa']->nama_siswa,
            ];

            $totalNilai = 0;

            foreach ($rekap['nilai'] as $nilai) {
                $rowData[] = number_format($nilai['nilai'], 2);
                $totalNilai += $nilai['nilai'];
            }

            $rataRata = count($rekap['nilai']) > 0 ? $totalNilai / count($rekap['nilai']) : 0;
            $rowData[] = number_format($rataRata, 2);

            $data[] = $rowData;
        }

        // Tambahkan baris untuk rata-rata kelas
        $rataRataKelasRow = array_merge([''], array_fill(0, count($this->mapel), ''), ['Rata-Rata Kelas'], [number_format($this->rataRataKelas, 2)]);
        $data[] = $rataRataKelasRow;

        return collect($data);
    }
}
