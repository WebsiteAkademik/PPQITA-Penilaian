@extends('layouts.adminuser')

@section('title')
    Profile Siswa
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h2 class="fw-semibold">Profile Siswa</h2><br/>
                    <form action="" method="post" id="">
                        @csrf
                        @method('put')
                        <div class="row mb-4">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_nisn" class="form-label">NISN</label>
                                    <input disabled type="text" class="form-control" name="no_nisn" id="no_nisn"
                                        value="{{ $siswa->no_nisn }}">
                                </div>
                            </div>     
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="nama_siswa" class="form-label">Nama Siswa</label>
                                    <input disabled type="text" class="form-control" name="nama_siswa" id="nama_siswa"
                                        value="{{ $siswa->nama_siswa }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input disabled type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                                    value="{{ $siswa->tempat_lahir }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input disabled type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                                        value="{{ $siswa->tanggal_lahir }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <input disabled type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin"
                                        value="{{ $siswa->jenis_kelamin }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_kartu_keluarga" class="form-label">Nomor Kartu Keluarga</label>
                                    <input disabled type="text" class="form-control" name="no_kartu_keluarga" id="no_kartu_keluarga"
                                        value="{{ $siswa->no_kartu_keluarga }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_induk_keluarga" class="form-label">Nomor Induk Keluarga</label>
                                    <input disabled type="text" class="form-control" name="no_induk_keluarga" id="no_induk_keluarga"
                                        value="{{ $siswa->no_induk_keluarga }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                    <input disabled type="text" class="form-control" name="agama" id="agama"
                                        value="{{ $siswa->agama }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="tinggi_badan" class="form-label">Tinggi Badan </label>
                                    <input disabled type="number" class="form-control" name="tinggi_badan" id="tinggi_badan"
                                        value="{{ $siswa->tinggi_badan }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="berat_badan" class="form-label">Berat Badan</label>
                                    <input disabled type="number" class="form-control" name="berat_badan" id="berat_badan"
                                        value="{{ $siswa->berat_badan }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_wa_anak" class="form-label">Nomor WhatsApp Anak</label>
                                    <input disabled type="text" class="form-control" name="no_wa_anak" id="no_wa_anak"
                                        value="{{ $siswa->no_wa_anak }}">
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-3">
                                    <label for="penyakit_kronis" class="form-label">Memiliki Penyakit Kronis</label>
                                    <textarea disabled class="form-control" name="penyakit_kronis" id="penyakit_kronis"
                                        value="">{{ $siswa->penyakit_kronis }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 border-radius">
                                <h3>Alamat</h3>
                            </div>
                            <div class="col-12 col-12">
                                <div class="mb-3">
                                    <label for="alamat_rumah" class="form-label">Jalan</label>
                                    <textarea  disabled class="form-control" id="alamat_rumah" name="alamat_rumah" rows="3"
                                        value="">{{ $siswa->alamat_rumah }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="dukuh" class="form-label">Dukuh</label>
                                    <input disabled type="text" class="form-control" name="dukuh" id="dukuh"
                                        value="{{ $siswa->dukuh }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="kelurahan" class="form-label">Kelurahan</label>
                                    <input disabled type="text" class="form-control" name="kelurahan" id="kelurahan"
                                        value="{{ $siswa->kelurahan }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <input disabled type="text" class="form-control" name="kecamatan" id="kecamatan"
                                        value="{{ $siswa->kecamatan }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="kabupaten" class="form-label">Kabupaten / Kota</label>
                                    <input disabled type="text" class="form-control" name="kabupaten" id="kabupaten"
                                        value="{{ $siswa->kabupaten }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="kodepos" class="form-label">Kode Pos</label>
                                    <input disabled type="text" class="form-control" name="kodepos" id="kodepos"
                                        value="{{ $siswa->kodepos }}">
                                </div>
                            </div>
                        </div>                      
                        <div class="row mb-2">
                            <div class="col-12 border-radius">
                                <h3>Asal Sekolah dan Keluarga</h3>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-3">
                                    <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                                    <input disabled type="text" class="form-control" name="asal_sekolah" id="asal_sekolah"
                                        value="{{ $siswa->asal_sekolah }}">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="form-ayah">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                    <input disabled type="text" class="form-control" name="nama_ayah" id="nama_ayah"
                                        value="{{ $siswa->nama_ayah }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                                    <input disabled type="text" class="form-control" name="pekerjaan_ayah" id="pekerjaan_ayah"
                                        value="{{ $siswa->pekerjaan_ayah }}">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="form-ibu">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="nama_ibu" class="form-label">Nama Ibu</label>
                                    <input disabled type="text" class="form-control" name="nama_ibu" id="nama_ibu"
                                        value="{{ $siswa->nama_ibu }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                                    <input disabled type="text" class="form-control" name="pekerjaan_ibu" id="pekerjaan_ibu"
                                        value="{{ $siswa->pekerjaan_ibu }}">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="form-contact-ortu">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_telepon_ortu" class="form-label">Nomor Whatsapp Orang Tua</label>
                                    <input disabled type="text" class="form-control" name="no_telepon_ortu" id="no_telepon_ortu"
                                        value="{{ $siswa->no_telepon_ortu }}">
                                </div>
                            </div>                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
