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
    <script>
        $(document).ready(function() {
            new DataTable('#table-kategori', {
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
                <div class="card-body">
                    <h5 class="card-title fs-6 fw-semibold mb-4">Rapor UTS Siswa</h5>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">Wali Kelas     :</p>
                            <p class="card-text">Tahun Ajaran   :</p>
                            <p class="card-text">Kelas          :</p>
                            <p class="card-text">Semester       :</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('pengajar.form') }}" class="btn btn-success m-3" id="tambahMapel">Cetak Rapor</a>
                    </div>
                    <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle" id="table-kategori">
                <thead class="text-dark fs-4">
                    <tr style="background-color: #2E8CB5">
                        <th style="width: 100px;" class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0 text-white">No.</h6>
                        </th>
                        <th style="width: 300px;" class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0 text-white">Mata Pelajaran</h6>
                        </th>
                        <th style="width: 100px;" class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0 text-white">KKM</h6>
                        </th>
                        <th style="width: 150px;" class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0 text-white">Rata-rata Kelas</h6>
                        </th>
                        <th style="width: 300px;" class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0 text-white">Nilai Deskripsi Kemajuan Belajar</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php $nomor = 1; @endphp
                    @foreach ($rapor_uts as $rapor)
                    <tr>
                        <td class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">{{ $nomor++ }}</h6>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">{{ $rapor->mata_pelajaran }}</h6>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">{{ $rapor->kkm }}</h6>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">{{ $rapor->rata_rata_kelas }}</h6>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">{{ $rapor->deskripsi_kemajuan_belajar }}</h6>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
                </div>
            </div>
        </div>
    </div>
@endsection