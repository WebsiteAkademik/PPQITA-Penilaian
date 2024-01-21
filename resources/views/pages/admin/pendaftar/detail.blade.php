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
                        <h2 class="fs-6 fw-semibold text-white mt-3">{{ $pendaftar->nama_calon_siswa }}</h2>
                        <p class="fs-2">{{ $pendaftar->no_nisn }}</p>
                    </div>
                    <h2 class="fs-4 fw-semibold text-white mt-2 text-start">Info Detail</h2>
                    <table>
                        <tr>
                            <td style="width: 40%">Nama Calon Siswa </td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->nama_calon_siswa }}</td>
                        </tr>
                        <tr>
                            <td style="width: 40%">NISN</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 55%">{{ $pendaftar->no_nisn }}</td>
                        </tr>
                        <tr>
                            <td style="width: 40%">No Whatsapp</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 55%">{{ $pendaftar->no_telepon }}</td>
                        </tr>
                        <tr>
                            <td style="width: 40%">No Induk Keluarga</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 55%">{{ $pendaftar->no_induk_keluarga }}</td>
                        </tr>
                        <tr>
                            <td style="width: 40%">Tempat tanggal lahir</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 55%">{{ $pendaftar->tempat_lahir . " " . $pendaftar->tanggal_lahir }}</td>
                        </tr>
                        <tr>
                            <td style="width: 40%">Jenis Kelamin</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 55%">{{ $pendaftar->jenis_kelamin != 0 ? 'Perempuan' : 'Laki - Laki' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%">Agama</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 55%">{{ $pendaftar->agama }}</td>
                        </tr>
                        <tr>
                            <td style="width: 40%">Alamat</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 55%">{{ 
                            $pendaftar->alamat_rumah 
                            . " " . $pendaftar->dukuh 
                            . " " . $pendaftar->kalurahan 
                            . " " . $pendaftar->kecamatan 
                            . " " . $pendaftar->kabupaten 
                            . " " . $pendaftar->kodepos  
                             }}</td>
                        </tr>
                        <tr>
                            <td style="width: 40%">Status</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 55%">{{ $pendaftar->status }}</td>

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
                            <td style="width: 65%">{{ $pendaftar->asal_sekolah }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Jurusan Yang Ingin Diambil</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->program_keahlian }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">NONISN</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->no_nisn }}</td>
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
                            <td style="width: 25%">Pekerjaan Ayah</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->pekerjaan_ayah }}</td>
                        </tr>

                        <tr>
                            <td style="width: 25%">No Telp / Whatsapp Orang Tua</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->no_telepon_ortu }}</td>
                        </tr>
                        <tr>
                        <tr>
                            <td style="width: 25%">Nama Ibu</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->nama_ibu }}</td>
                        </tr>
                        
                        <tr>
                            <td style="width: 25%">Pekerjaan Ibu</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->pekerjaan_ibu }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Memperoleh Informasi Dari</td>
                            <td style="width: 5%"> : </td>
                            <td style="width: 65%">{{ $pendaftar->informasi_pmb }}</td>
                        </tr>
                        <tr>
                    </table>
                    <br>
                    <table>
                        <!-- Tombol Cetak Formulir Pendaftaran -->
                        <a href="{{ route('cetak_pdf', $pendaftar->no_nisn) }}" class="btn btn-primary">Unduh Formulir Daftar Ulang</a>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
