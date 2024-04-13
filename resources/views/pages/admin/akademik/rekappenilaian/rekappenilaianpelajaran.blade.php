@extends('layouts.admin')

@section('title')
    Laporan Rekap Penilaian Pelajaran
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        .container-fluid {
            max-width: none !important;
        }
    </style>
@endpush

@push('script')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#table-pendaftaran', {
                "oLanguage": {
                    "sLengthMenu": "Tampilkan _MENU_ data per halaman",
                    "sZeroRecords": "Data tidak ditemukan",
                    "sSearch": "Cari"
                },
                "pageLength": 50
            });
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h3 class="fw-bold">Rekap Penilaian Pelajaran {{ $kelas->kelas }}</h3><br/>
                    <div class="d-flex">
                        <a href="{{ route('rekappenilaianpelajaran.cetak', $kelas->id) }}" target="_blank" class="btn btn-primary m-1">Cetak Rekap</a>
                        <a href="{{ route('rekappenilaianpelajaran.export', $kelas->id) }}" class="btn btn-success m-1">Export Rekap</a>
                    </div><br/>
                    <div class="table">
                        <table class="table mb-0 align-middle" id="table-pendaftaran">
                            <thead class="text-dark">
                                <tr style="background-color: #2E8CB5">
                                    <th style="text-align: center; vertical-align: middle;" class="border-bottom-0" rowspan="2">
                                        <h6 style="color: white" class="fw-semibold mb-0">No.</h6>
                                    </th>
                                    <th style="text-align: center; vertical-align: middle;" class="border-bottom-0" rowspan="2">
                                        <h6 style="color: white" class="fw-semibold mb-0">Nama</h6>
                                    </th>
                                    <th style="text-align: center" class="border-bottom-0" colspan="{{ count($mapel) }}">
                                        <h6 style="color: white" class="fw-semibold mb-0">Nilai</h6>
                                    </th>
                                    <th style="text-align: center; vertical-align: middle;" class="border-bottom-0" rowspan="2">
                                        <h6 style="color: white" class="fw-semibold mb-0">Rata-Rata</h6>
                                    </th>
                                </tr>
                                <tr style="background-color: #2E8CB5">
                                    @foreach($mapel as $m)
                                    <th style="text-align: center" class="border-bottom-0">
                                        <h6 style="color: white" class="fw-semibold mb-0">{{ $m->nama_mata_pelajaran }}</h6>
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekapNilai as $index => $rekap)
                                <tr>
                                    <td style="text-align: center;" class="border-bottom-0">{{ $index + 1 }}</td>
                                    <td class="border-bottom-0">{{ $rekap['siswa']->nama_siswa }}</td>
                                    @foreach ($rekap['nilai'] as $nilai)
                                    <td style="text-align: center;" class="border-bottom-0">{{ $nilai['nilai'] }}</td>
                                    @endforeach
                                    <td style="text-align: center;" class="border-bottom-0">{{-- Rata-rata --}}
                                        @php
                                            $totalNilai = 0;
                                            foreach($rekap['nilai'] as $n){
                                                $totalNilai += $n['nilai'];
                                            }
                                            $rataRata = count($rekap['nilai']) > 0 ? $totalNilai / count($rekap['nilai']) : 0;
                                        @endphp
                                        {{ number_format($rataRata, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr>
                                    <td colspan="{{ count($mapel) + 1 }}"></td>
                                    <td style="background-color: #2E8CB5" colspan="1">
                                        <h6 class="fw-semibold mb-0" style="color: white">Rata-Rata Kelas</h6>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        @php
                                            $totalRataRataKelas = 0;
                                            $totalSiswa = count($rekapNilai);
                                            foreach($rekapNilai as $rekap){
                                                foreach($rekap['nilai'] as $nilai){
                                                    $totalRataRataKelas += $nilai['nilai'];
                                                }
                                            }
                                            $rataRataKelas = $totalSiswa > 0 ? $totalRataRataKelas / ($totalSiswa * count($mapel)) : 0;
                                        @endphp
                                        {{ number_format($rataRataKelas, 2) }}
                                    </td>
                                </tr>    
                            </thead>
                        </table><br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection