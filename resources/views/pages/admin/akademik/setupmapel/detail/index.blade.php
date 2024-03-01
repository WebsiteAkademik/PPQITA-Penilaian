@extends('layouts.admin')

@section('title')
    Detail Setup Mata Pelajaran
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
            new DataTable('#table-detailsetup', {
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
                    <h5 class="card-title fs-6 fw-semibold mb-4">Detail Setup Mata Pelajaran</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap mb-0 align-middle" id="table-setup">
                            <tr>
                                <th style="width: 100px;" class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Tahun Ajaran:</h6>
                                </th>
                                <td style="width: 100px;" class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $tahunajar->tahun_ajaran }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 100px;" class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Kelas:</h6>
                                </th>
                                <td style="width: 100px;" class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $kelas->kelas }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 100px;" class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Pengajar:</h6>
                                </th>
                                <td style="width: 100px;" class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $pengajar->nama_pengajar }}</h6>
                                </td>
                            </tr>
                        </table>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div>
                        <a href="{{ route('detail.form', $setup->id) }}" class="btn btn-primary m-3" id="tambahSetup">Tambah</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle" id="table-detailsetup">
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
                                        <h6 class="fw-semibold mb-0 text-white">Action</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail as $key => $row)
                                <tr>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{ $key + 1 }}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{ $row->mapelID()->nama_mata_pelajaran }}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{ $row->kkm }}</h6>
                                    </td>
                                    <td class="border-bottom-0 align-items-center text-center">
                                        <div class="col-6 d-flex justify-content-center">
                                            <a type="button" data-bs-toggle="modal"
                                                data-bs-target="#detail{{ $setup->id, $row->id  }}"
                                                class="text-black text-center d-flex align-items-center justify-content-center"
                                                style="width: 40px;height: 40px;border:none;">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                           @include('pages.admin.akademik.modal.detailsetup', array('row' => $row, 'setup' => $setup))
                                        </div>
                                        <div class="col-6 d-flex justify-content-center">
                                            <form id="deleteForm{{ $setup->id, $row->id }}" action="{{ route('detail.delete', ['id' => $setup->id, 'id2' => $row->id]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a href="#" class="text-black text-center d-flex align-items-center justify-content-center" style="width: 40px;height: 40px;" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus detail setup mata pelajaran ini?')) document.getElementById('deleteForm{{ $setup->id, $row->id }}').submit();"><i class="fa-solid fa-trash"></i></a>
                                        </div>
                                    </td> 
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <a href="{{ route('setup.index') }}" class="btn btn-primary m-3" id="simpanSetup">Simpan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection