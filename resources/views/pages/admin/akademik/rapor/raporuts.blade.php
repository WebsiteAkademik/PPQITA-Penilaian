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
                    <h5 class="card-title fs-6 fw-semibold mb-4">Rapor UTS</h5>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <table class="table-h">
                                <tr>
                                    <th style="width: 150px">Wali Kelas</th>
                                    <td style="width: 10px;">:</td>
                                    <td>{{ $kelas->pengajarID()->nama_pengajar }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun Ajaran</th>
                                    <td>:</td>
                                    <td>{{ $tahunajar->tahun_ajaran }}</td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td>:</td>
                                    <td>{{ $kelas->kelas }}</td>
                                </tr>
                                <tr>
                                    <th>Semester</th>
                                    <td>:</td>
                                    <td>{{ $tahunajar->semester }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap mb-0 align-middle" id="table-kategori">
                            <thead class="text-dark fs-4">
                                <tr style="background-color: #2E8CB5">
                                    <th style="width: 10%;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">No.</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Nama Siswa</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Action</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $key => $row)
                                <tr>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{ $key + 1 }}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{ $row->nama_siswa }}</h6>
                                    </td>
                                    <td class="border-bottom-0 align-items-center text-center">
                                        <div class="row col-6 d-flex justify-content-center" style="width: 100px; margin: 0 auto">
                                            <a href="{{ route('raporuts.cetak', $row->id) }}" target="_blank" class="btn btn-success m-3" id="cetakRapor">Cetak</a>
                                        </div>
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