@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-5">
                            <i class="fa-solid fa-user" style="font-size: 4rem;"></i>
                        </div>
                        <div class="col-7 text-end">
                            <h4 style="font-weight: 600">{{ $pendaftarCount }}</h4>
                            <p>Pendaftar</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('pendaftar.index') }}" class="text-dark d-flex justify-content-between">
                        <p style="font-weight: 500">Detail</p>
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Pendaftaran Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama Calon Siswa</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nomor Whatsapp Anak</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status</h6>
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
                                            <h3 class="fw-semibold mb-1">{{ $pendaftar->no_nisn }}</h3>
                                            <h5 class="fw-normal mb-1">{{ $pendaftar->nama_calon_siswa }}</h5>
                                            <br/><span class="fw-normal mb-1">{{ "Tempat Lahir : " . $pendaftar->tempat_lahir }}</span>
                                            <br/><span class="fw-normal mb-1">{{ "Tanggal Lahir : " . $pendaftar->tanggal_lahir }}</span>
                                            <br/><span class="fw-normal mb-1">{{ "No KK : " . $pendaftar->no_kartu_keluarga }}</span>
                                            <br/><span class="fw-normal mb-1">{{ "Agama : " . $pendaftar->agama }}</span>
                                            <br/><span class="fw-normal mb-1">{{ "Alamat Rumah : " . $pendaftar->alamat_rumah }}</span>
                                            <br/><span class="fw-normal mb-1">{{ "Nama Ayah : " . $pendaftar->nama_ayah }}</span>
                
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal"><a href="https://wa.me/{{ $pendaftar->no_telepon }}">{{ $pendaftar->no_telepon }}</a></p>
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
