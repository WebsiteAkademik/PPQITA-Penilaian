@extends('layouts.admin')

@section('title')
    Data Pengajar
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
                    <h5 class="card-title fs-6 fw-semibold mb-4">Data Pengajar</h5>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div>
                        <a href="{{ route('pengajar.form') }}" class="btn btn-primary m-3" id="tambahMapel">+ Tambah Pengajar</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle" id="table-kategori">
                            <thead class="text-dark fs-4">
                                <tr style="background-color: #2E8CB5">
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">No.</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Nama Pengajar</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Alamat</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">No. WA</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Mapel yang Diampu</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Action</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajar as $key => $row)
                                <tr>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{ $key + 1 }}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{ $row->nama_pengajar }}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{ $row->alamat }}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{ $row->no_wa_pengajar }}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{ $row->mapelID()->nama_mata_pelajaran }}</h6>
                                    </td>
                                    <td class="border-bottom-0 align-items-center">
                                        <div class="row" style="width: 100px; margin: 0 auto">
                                            <div class="col-6 d-flex justify-content-center">
                                                <a href="{{ route('pengajar.edit', $row->id) }}" class="text-black text-center d-flex align-items-center justify-content-center" style="width: 40px;height: 40px;"><i class="fa-solid fa-pen-to-square"></i></a>
                                            </div>
                                            <div class="col-6 d-flex justify-content-center">
                                                <form id="deleteForm{{ $row->id }}" action="{{ route('pengajar.delete', $row->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <a href="#" class="text-black text-center d-flex align-items-center justify-content-center" style="width: 40px;height: 40px;" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus data pengajar ini?')) document.getElementById('deleteForm{{ $row->id }}').submit();"><i class="fa-solid fa-trash"></i></a>
                                            </div>
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