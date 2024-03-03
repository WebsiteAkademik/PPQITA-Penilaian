@extends('layouts.admin')

@section('title')
    Laporan Rekap Penilaian Tahfidz
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
                    <h3 class="fw-bold">Rekap Penilaian Tahfidz</h3>
                    <div class="d-flex">
                        <a href="{{ route('cetak_laporan', ['min_date' => request('min_date'), 'max_date' => request('max_date')]) }}" target="_blank" class="btn btn-primary m-1">Cetak PDF</a>
                        <a href="{{ route('export-pendaftar', ['min_date' => request('min_date'), 'max_date' => request('max_date')]) }}" class="btn btn-success m-1">Export Excel</a>
                    </div><br/>
                    <div class="table">
                        <table class="table mb-0 align-middle" id="table-pendaftaran">
                            <thead class="text-dark">
                                <tr style="background-color: #2E8CB5">
                                    <th style="text-align: center; width: 20px" class="border-bottom-0">
                                        <h6 style="color: white" class="fw-semibold mb-0">No.</h6>
                                    </th>
                                    <th style="text-align: center" class="border-bottom-0">
                                        <h6 style="color: white" class="fw-semibold mb-0">Nama</h6>
                                    </th>
                                    <th style="text-align: center; width: 200px" class="border-bottom-0">
                                        <h6 style="color: white" class="fw-semibold mb-0">UI/UX</h6>
                                    </th>
                                    <th style="text-align: center; width: 200px" class="border-bottom-0">
                                        <h6 style="color: white" class="fw-semibold mb-0">Web Development</h6>
                                    </th>
                                    <th style="text-align: center; width: 200px" class="border-bottom-0">
                                        <h6 style="color: white" class="fw-semibold mb-0">Mobile Development</h6>
                                    </th>
                                    <th style="text-align: center; width: 200px" class="border-bottom-0">
                                        <h6 style="color: white" class="fw-semibold mb-0">Rata-Rata</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">asdf</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">asdf</h5>           
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">asdf</h5>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">asdf</h5>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">asdf</h5>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">asdf</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">asdf</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">asdf</h5>           
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">asdf</h5>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">asdf</h5>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">asdf</h5>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h5 class="fw-normal mb-1">asdf</h5>
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <td colspan="4"></td>
                                    <td style="background-color: #2E8CB5">
                                        <h6 class="fw-semibold mb-0" style="color: white">Rata-Rata Kelas</h6>
                                    </td>
                                    <td>
                                        <h6 class="fw-semibold mb-0">asdf</h6>
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

