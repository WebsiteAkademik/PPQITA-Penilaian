@extends('layouts.admin')

@section('title')
    Data Tahun Ajaran
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
            new DataTable('#table-tahunajar', {
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
                    <h5 class="card-title fs-6 fw-semibold mb-4">Data Tahun Ajaran</h5>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div>
                        <a href="{{ route('tahunajar.form') }}" class="btn btn-primary m-3" id="tambahTahunAjar">+ Tambah Tahun Ajaran</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle" id="table-tahunajar">
                            <thead class="text-dark fs-4">
                                <tr style="background-color: #2E8CB5">
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">ID</h6>
                                    </th>
                                    <th class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Tahun Ajaran</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Status</h6>
                                    </th>
                                    <th style="width: 100px;" class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0 text-white">Action</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tahunajar as $row)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $row->id }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $row->tahun_ajaran }}</h6>
                                    </td>
                                    <td class="border-bottom-0 align-items-center">
                                        @php
                                        switch ($row->status) {
                                            case 'aktif':
                                                echo "<div class='badge text-capitalize bg-success'>AKTIF</div>";
                                                break;
                                            case 'tidak aktif':
                                                echo "<div class='badge text-capitalize bg-danger'>TIDAK AKTIF</div>";
                                                break;
                                            }
                                        @endphp
                                    </td>
                                    <td class="border-bottom-0 align-items-center">
                                        <div class="row mt-1">
                                            <div class="col-6 col-lg-5">
                                                <a href="{{ route('tahunajar.edit', $row->id) }}" class="text-black text-center d-flex align-items-center justify-content-center" style="width: 40px;height: 40px;"><i class="fa-solid fa-pen-to-square"></i></a>
                                            </div>
                                            <div class="col-6 col-lg-5">
                                                <form id="deleteForm{{ $row->id }}" action="{{ route('tahunajar.delete', $row->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <a href="#" class="text-black text-center d-flex align-items-center justify-content-center" style="width: 40px;height: 40px;" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus data tahun ajaran ini?')) document.getElementById('deleteForm{{ $row->id }}').submit();"><i class="fa-solid fa-trash"></i></a>
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