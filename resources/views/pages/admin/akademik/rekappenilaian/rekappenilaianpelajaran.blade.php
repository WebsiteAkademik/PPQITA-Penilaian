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
                    <h3 class="fw-bold">Rekap Penilaian Pelajaran</h3>
                    <div class="d-flex">
                        <a href="{{ route('cetak_laporan', ['min_date' => request('min_date'), 'max_date' => request('max_date')]) }}" target="_blank" class="btn btn-primary m-1">Cetak PDF</a>
                        <a href="{{ route('export-pendaftar', ['min_date' => request('min_date'), 'max_date' => request('max_date')]) }}" class="btn btn-success m-1">Export Excel</a>
                    </div><br/>
                    <div class="table">
                        <table class="table mb-0 align-middle" id="table-pendaftaran">
                            <thead class="text-dark">
                                <tr style="background-color: #2E8CB5">
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No.</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aqidah</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Fiqh</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Adab</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Prestasi
                                </tr>
                            </thead>
                            <tbody>
                                <!-- @foreach ($pendaftars as $key => $pendaftar)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $pendaftar->no_pendaftaran }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">{{ $pendaftar->nama_calon_siswa }}</h5>           
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">{{ $pendaftar->kabupaten }}</h5>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">{{ $pendaftar->asal_sekolah }}</h5>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal"><a href="https://wa.me/{{ $pendaftar->no_telepon }}">{{ $pendaftar->no_wa_anak }}</a></p>
                                    </td>
                                    <td class="border-bottom-0">
                                        @php
                                            switch ($pendaftar->status) {
                                                case 'BARU':
                                                    echo "<div class='badge text-capitalize' style='background-color: #00569C;'>$pendaftar->status</div>";
                                                    break;
                                                case 'TEST':
                                                    echo "<div class='badge text-capitalize bg-info'>$pendaftar->status</div>";
                                                    break;
                                                case 'MENUNGGU':
                                                    echo "<div class='badge text-capitalize bg-secondary'>$pendaftar->status</div>";
                                                    break;
                                                case 'DITERIMA':
                                                    echo "<div class='badge text-capitalize bg-success'>$pendaftar->status</div>";
                                                    break;
                                                case 'DITOLAK':
                                                    echo "<div class='badge text-capitalize bg-danger'>TIDAK DITERIMA</div>";
                                                    break;
                                            }
                                        @endphp
                                    </td>
                                    <td class="border-bottom-0 d-none">
                                        <h5 class="fw-normal mb-1">{{ $pendaftar->created_at->format('Y-m-d') }}</h5>
                                    </td>
                                </tr>
                                @endforeach -->
                            </tbody>
                        </table><br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

