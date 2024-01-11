@extends('layouts.admin')

@section('title')
    Detail Pendaftar : {{ $pendaftar->nama_maba }}
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@endpush

@push('script')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        new DataTable('#table-pendaftaran', {
            "oLanguage": {
                "sLengthMenu": "Tampilkan _MENU_ data per halaman",
                "sZeroRecords": "Data tidak ditemukan",
                "sSearch": "Cari"
            },
            "pageLength": 50
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100" style="background-color: #00569C;">
                <div class="card-body p-4 text-white">
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('assets/avatar.png') }}" class="rounded-circle" alt="avatar image"
                            style="width: 8rem">
                        <h2 class="fs-6 fw-semibold text-white mt-3">{{ $pendaftar->nama_maba }}</h2>
                        <p class="fs-2">{{ $pendaftar->email_maba }}</p>
                    </div>
                    <h2 class="fs-4 fw-semibold text-white mt-2 text-start">Info Detail</h2>
                    <table>
                        <tr>
                            <td style="width: 25%">Nama Maba</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->nama_maba }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Email Maba</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->email_maba }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">No Telp Maba</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->no_telp_maba }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">No KTP Maba</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->no_ktp_maba }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Tanggal Lahir Maba</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->tgl_lahir_maba }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Jenis Kelamin Maba</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->jenis_kelamin_maba != 0 ? 'Perempuan' : 'Laki - Laki' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Agama Maba</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->agama_maba }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Alamat Maba</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->alamat_maba }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Status</td>
                            <td style="width: 5%"> : </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="" style="display: flex;justify-content: space-between;align-items: center;">
                        <a href="{{ route('pendaftar.index') }}"><i class="fa-solid fa-arrow-left-long pe-2"></i>
                            Kembali</a>
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
                    </div>
                    <h2 class="fs-6 fw-semibold mt-4">Data Sekolah</h2>
                    <table>
                        <tr>
                            <td style="width: 25%">Nama Sekolah</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->nama_sekolah }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Jurusan Sekolah</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->jurusan_sekolah }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Nomor Ijazah</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->no_ijazah }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Tanggal Ijazah</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->tgl_ijazah }}</td>
                        </tr>
                    </table>
                    <h2 class="fs-6 fw-semibold mt-4">Data Orangtua</h2>
                    <table>
                        <tr>
                            <td style="width: 25%">Nama Ayah</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->nama_ayah }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">No Telp Ayah</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->no_telp_ayah }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Alamat Ayah</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->alamat_ayah }}</td>
                        </tr>
                        <tr>
                        <tr>
                            <td style="width: 25%">Nama Ibu</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->nama_ibu }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">No Telp Ibu</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->no_telp_ibu }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Alamat Ibu</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->alamat_ibu }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Jurusan Prodi</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->jurusan_prodi }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Memperoleh Informasi PSB PPQIT Al - Mahir dari</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->informasi_psb }}</td>
                        </tr>
                        <tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
