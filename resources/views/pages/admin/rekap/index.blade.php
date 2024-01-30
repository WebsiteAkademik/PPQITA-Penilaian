@extends('layouts.admin')

@section('title')
    Laporan Rekap Pendaftar
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
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
                    <h3 class="fw-bold">Rekap Pendaftar</h3>
                    <h6>Tahun Ajaran: 2024/2025</h6>
                    <h6>Bulan: Januari 2024</h6><br/>
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle" id="table-pendaftaran">
                            <thead class="text-dark">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No. Pendaftaran</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama Pendaftar</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Kota</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Sekolah Asal</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No. Whatsapp</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftars as $key => $pendaftar)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $pendaftar->user_id }}</h6>
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
                                                case 'DITERIMA':
                                                    echo "<div class='badge text-capitalize bg-success'>$pendaftar->status</div>";
                                                    break;
                                                case 'DITOLAK':
                                                    echo "<div class='badge text-capitalize bg-danger'>$pendaftar->status</div>";
                                                    break;
                                            }
                                        @endphp
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table><br/>
                        <div class="d-flex">
                            <a href="{{ route('cetak_laporan') }}" class="btn btn-primary m-1">Cetak PDF</a>
                            <a href="{{ route('export-pendaftar') }}" class="btn btn-success m-1">Export Excel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

