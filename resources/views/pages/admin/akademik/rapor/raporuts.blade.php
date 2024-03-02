@extends('layouts.admin')

@section('title')
    Rapor UTS
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
    <style>
        .table-h {
            border-collapse: collapse;
            width: 100%;
        }

        .table-h td, .table-h th {
            padding: 8px;
            text-align: left;
        }

        .table-bordered, .table-bordered thead, .table-bordered tbody, .table-bordered th, .table-bordered td, .table-bordered tr {
            border-collapse: collapse;
            border: 1px solid #666;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-title fs-6 fw-semibold mb-4">Rapor UTS Siswa</h5>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <table class="table-h">
                                <tr>
                                    <th style="width: 150px">Wali Kelas</th>
                                    <td style="width: 10px;">:</td>
                                    <td>asdf</td>
                                </tr>
                                <tr>
                                    <th>Tahun Ajaran</th>
                                    <td>:</td>
                                    <td>asdf</td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td>:</td>
                                    <td>asdf</td>
                                </tr>
                                <tr>
                                    <th>Semester</th>
                                    <td>:</td>
                                    <td>asdf</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('pengajar.form') }}" class="btn btn-success m-3" id="tambahMapel">Cetak Rapor</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap mb-0 align-middle" id="table-kategori">
                            <thead class="text-dark fs-4">
                                <tr style="background-color: #2E8CB5">
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">No.</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Mata Pelajaran</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">KKM</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Rata-rata Kelas</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Nilai</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Nilai Deskripsi Kemajuan Belajar</h6>
                                    </th>
                                </tr>
                            </thead>
                            <thead>
                                <tr style="background-color: #2E8CB5; color: white;">
                                    <th class="border-bottom-0 text-left" colspan="6">A. Mata Pelajaran Umum</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr style="background-color: #2E8CB5; color: white;">
                                    <th class="border-bottom-0 text-left" colspan="6">B. Program Tahfidz</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr style="background-color: #2E8CB5; color: white;">
                                    <th class="border-bottom-0 text-left" colspan="6">C. Mata Pelajaran Dinniyah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-bottom-0 text-center" colspan="2">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center" colspan="2">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center" colspan="2" rowspan="2">
                                        <h6 class="fw-semibold mb-0"></h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-bottom-0 text-center" colspan="2">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center" colspan="2">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive" style="height: 10px;">
                        <!-- space -->
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap mb-0 align-middle" id="table-kategori">
                            <thead>
                                <tr style="background-color: #2E8CB5; color: white;">
                                    <th class="border-bottom-0 text-left" colspan="6">Pengembangan Diri dan Ekstra Kurikuler</th>
                                </tr>
                            </thead>
                            <thead class="text-dark fs-4">
                                <tr style="background-color: #2E8CB5">
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">No.</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Nama</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Nilai</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Keterangan</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">abc</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive" style="height: 10px;">
                        <!-- space -->
                    </div>
                    <div class="table-responsive row">
                        <div class="col-lg-6">
                            <table class="table table-bordered text-nowrap mb-0 align-middle" id="table-kategori">
                                <thead>
                                    <tr style="background-color: #2E8CB5; color: white;">
                                        <th class="border-bottom-0 text-left" colspan="2">Ketidakhadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border-bottom-0 text-center">
                                            <h6 class="fw-semibold mb-0">abc</h6>
                                        </td>
                                        <td class="border-bottom-0 text-center">
                                            <h6 class="fw-semibold mb-0">abc</h6>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table class="table table-bordered text-nowrap mb-0 align-middle" id="table-kategori">
                                <thead>
                                    <tr style="background-color: #2E8CB5; color: white;">
                                        <th class="border-bottom-0 text-left">Saran/Nasihat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border-bottom-0 text-left">
                                            <h6 class="fw-semibold mb-0">Alhamdulilah, nilai Ananda sangat baik. Semoga selalu semangat bersekolah.</h6>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection