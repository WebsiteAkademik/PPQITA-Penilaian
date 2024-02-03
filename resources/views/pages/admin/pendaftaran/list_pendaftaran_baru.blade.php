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
                    <h5 class="card-title fs-6 fw-semibold mb-4">Data Pendaftar Baru</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle" id="table-pendaftaran">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No. Pendaftaran</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tanggal Pendaftaran</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama Pendaftar</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Kota</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Alamat</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nomor Whatsapp Orang Tua</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Jadwal Test</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftaran as $key => $row)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $key + 1 }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">NP</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $row->created_at }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h3 class="fw-semibold mb-1">{{ $row->no_nisn }}</h3>
                                        <h5 class="fw-normal mb-1">{{ $row->nama_calon_siswa }}</h5>
                                        
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $row->kecamatan }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $row->alamat_rumah }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        @if( $row->no_wa_ayah != null )
                                        <p class="mb-0 fw-normal">Ayah: <a href="https://wa.me/{{ $row->no_wa_ayah }}">{{ $row->no_wa_ayah }}</a></p>
                                        @endif
                                        @if( $row->no_wa_ibu != null )
                                        <p class="mb-0 fw-normal">Ibu: <a href="https://wa.me/{{ $row->no_wa_ibu }}">{{ $row->no_wa_ibu }}</a></p>
                                        @endif
                                        @if( $row->no_telepon_ortu != null )
                                        <p class="mb-0 fw-normal">Ortu: <a href="https://wa.me/{{ $row->no_telepon_ortu }}">{{ $row->no_telepon_ortu }}</a></p>
                                        @endif
                                    </td>
                                    <td class="border-bottom-0 d-flex gap-2 align-items-center">
                                        JT
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
