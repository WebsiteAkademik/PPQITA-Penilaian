@extends('layouts.admin')

@section('title')
    Pendaftar
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
                    <h5 class="card-title fs-6 fw-semibold mb-4">List Pendaftaran</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle" id="table-pendaftaran">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama & Email</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No Telp</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Alamat</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Action</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftars as $key => $pendaftar)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $key + 1 }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $pendaftar->nama_maba }}</h6>
                                            <span class="fw-normal">{{ $pendaftar->email_maba }}</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $pendaftar->no_telp_maba }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            @php
                                                switch ($pendaftar->status) {
                                                    case 'open':
                                                        echo "<div class='badge text-capitalize' style='background-color: #00569C;'>$pendaftar->status</div>";
                                                        break;
                                                    case 'testing':
                                                        echo "<div class='badge text-capitalize bg-info'>$pendaftar->status</div>";
                                                        break;
                                                    case 'wawancara':
                                                        echo "<div class='badge text-capitalize bg-warning'>$pendaftar->status</div>";
                                                        break;
                                                    case 'diterima':
                                                        echo "<div class='badge text-capitalize bg-success'>$pendaftar->status</div>";
                                                        break;
                                                    case 'tidak diterima':
                                                        echo "<div class='badge text-capitalize bg-danger'>$pendaftar->status</div>";
                                                        break;
                                                }
                                            @endphp
                                        </td>
                                        <td class="border-bottom-0 d-flex gap-2 align-items-center">
                                            <a href="{{ route('pendaftar.detail', $pendaftar->slug) }}"
                                                class="text-white text-center d-flex align-items-center justify-content-center rounded-circle bg-warning"
                                                style="width: 40px;height: 40px;">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#editPendaftarModal"
                                                class="text-white text-center d-flex align-items-center justify-content-center rounded-circle"
                                                style="background-color: #00569C;width: 40px;height: 40px;border:none;">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            @include('pages.modal.editPendaftarModal')
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
