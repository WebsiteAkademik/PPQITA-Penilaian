@extends('layouts.base')

@section('title')
    Daftar Online
@endsection

@push('script')
    <script>
        let checkboxAyah = document.getElementById('ayah_hidup');
        let checkboxIbu = document.getElementById('ibu_hidup');
        const formPendaftaranAyah = document.getElementById('form-ayah');
        const formPendaftaranIbu = document.getElementById('form-ibu');

        let showFormPendaftaran = false;

        checkboxAyah.addEventListener('change', function() {
            if (checkboxAyah.checked) {
                checkboxAyah.value = 1;
                formPendaftaranAyah.classList.remove('d-none');
            } else {
                checkboxAyah.value = 0;
                formPendaftaranAyah.classList.add('d-none');
            }
        });

        checkboxIbu.addEventListener('change', function() {
            if (checkboxIbu.checked) {
                checkboxIbu.value = 1;
                formPendaftaranIbu.classList.remove('d-none');
            } else {
                checkboxIbu.value = 0;
                formPendaftaranIbu.classList.add('d-none');
            }
        });

        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'reload-captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha)
                }
            });
        });
    </script>
@endpush

@push('style')
<style>
    .border-radius {
        border-radius: 10px;
        padding:10px;
        color:white;
        background-color:#B90000;
        margin-bottom:5px;
        text-align:center;
    }
</style>
@endpush

@section('content')
    <!-- Jumbotron -->
    <section class="jumbotron" style="background: url(../assets/Foto_Bersama_Dihalaman.jpeg) no-repeat;background-size:100%;   background-position: center; z-index:1;">
        
    </section>

    {{-- Pendaftaran --}}
    <section class="pendaftaran p-5 m-auto" id="formpendaftaran" style="box-shadow:5px 5px 10px;z-index:2;margin:10px">
        <div class="container">
            <div class="row text-left justify-content-center">
                <div class="col-12">
                    <div class="text-center mb-4">
                        <h2 class="mb-3">Form PPDB Calon Santri PPQIT Al Mahir Surakarta
                        </h2>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                            <strong>Kesalahan Input!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('daftar-online') }}" method="post" id="form-pendaftaran" class="mt-2">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-12 border-radius">
                                <h3>Data Calon Santri</h3>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_nisn" class="form-label">NO NISN<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="number" class="form-control" name="no_nisn" id="no_nisn"
                                        value="{{ old('no_nisn') }}">
                                </div>
                            </div>     

                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="nama_calon_siswa" class="form-label">Nama Calon Peserta Didik <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="nama_calon_siswa" id="nama_calon_siswa"
                                        value="{{ old('nama_calon_siswa') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger"
                                        style="font-weight: 700;font-size: 20px;">*</span></label>
                                <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                                    value="{{ old('tempat_lahir') }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                                        value="{{ old('tanggal_lahir') }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_kartu_keluarga" class="form-label">Nomor Kartu Keluarga <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="no_kartu_keluarga" id="no_kartu_keluarga"
                                        value="{{ old('no_kartu_keluarga') }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="tinggi_badan" class="form-label">Tinggi Badan <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="number" class="form-control" name="tinggi_badan" id="tinggi_badan"
                                        value="{{ old('tinggi_badan') }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="berat_badan" class="form-label">Berat Badan <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="number" class="form-control" name="berat_badan" id="berat_badan"
                                        value="{{ old('berat_badan') }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_wa_anak" class="form-label">Nomor WhatsApp Anak<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="no_wa_anak" id="no_wa_anak"
                                        value="{{ old('no_wa_anak') }}">
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-3">
                                    <label for="penyakit_kronis" class="form-label">Memiliki Penyakit Kronis<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <textarea class="form-control" name="penyakit_kronis" id="penyakit_kronis"
                                        value="">{{ old('penyakit_kronis') }}</textarea>
                                </div>
                            </div>

                            <div class="col-12 border-radius">
                                <h3>Alamat</h3>
                            </div>
                            <div class="col-12 col-12">
                                <div class="mb-3">
                                    <label for="alamat_rumah" class="form-label">Jalan <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <textarea class="form-control" id="alamat_rumah" name="alamat_rumah" rows="3" value="">{{ old('alamat_rumah') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="dukuh" class="form-label">Dukuh<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="dukuh" id="dukuh"
                                        value="{{ old('dukuh') }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="kelurahan" class="form-label">Kelurahan<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="kelurahan" id="kelurahan"
                                        value="{{ old('kelurahan') }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="kecamatan" id="kecamatan"
                                        value="{{ old('kecamatan') }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="kabupaten" class="form-label">Kabupaten / Kota<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="kabupaten" id="kabupaten"
                                        value="{{ old('kabupaten') }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="kodepos" class="form-label">Kode Pos<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="kodepos" id="kodepos"
                                        value="{{ old('kodepos') }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-2">
                            <div class="col-12 border-radius">
                                <h3>Asal Sekolah dan Keluarga</h3>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-3">
                                    <label for="asal_sekolah" class="form-label">Asal Sekolah <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="asal_sekolah" id="asal_sekolah"
                                        value="{{ old('asal_sekolah') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="bg-white text-dark px-3 py-2 d-flex gap-1 ms-auto"
                                    style="border-radius: 2rem">
                                    <div class="ms-1">
                                        <input type="checkbox" name="ayah_hidup" id="ayah_hidup" value="1" checked>
                                        <label for="ayah_hidup">Ayah Hidup?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="form-ayah">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="nama_ayah" class="form-label">Nama Ayah <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="nama_ayah" id="nama_ayah"
                                        value="{{ old('nama_ayah') }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="pekerjaan_ayah" id="pekerjaan_ayah"
                                        value="{{ old('pekerjaan_ayah') }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="bg-white text-dark px-3 py-2 d-flex gap-1 ms-auto"
                                    style="border-radius: 2rem">
                                    <div class="ms-1">
                                        <input type="checkbox" name="ibu_hidup" id="ibu_hidup" value="1" checked>
                                        <label for="ibu_hidup">Ibu Hidup?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="form-ibu">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="nama_ibu" class="form-label">Nama Ibu <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="nama_ibu" id="nama_ibu"
                                        value="{{ old('nama_ibu') }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="pekerjaan_ibu" id="pekerjaan_ibu"
                                        value="{{ old('pekerjaan_ibu') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="form-contact-ortu">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_telepon_ortu" class="form-label">Nomor Whatsapp Orang Tua <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="number" class="form-control" name="no_telepon_ortu" id="no_telepon_ortu"
                                        value="{{ old('no_telepon_ortu') }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="penghasilan_per_bulan" class="form-label">Penghasilan Perbulan <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <select class="form-select" id="penghasilan_per_bulan" name="penghasilan_per_bulan" value="{{ old('penghasilan_per_bulan') }}">
                                        <option {{ old('penghasilan_per_bulan') == '' ? 'selected' : '' }} disabled>--- Pilih Penghasilan ---</option>
                                        <option {{ old('penghasilan_per_bulan') == 'Kurang Dari 1 Juta' ? 'selected' : '' }} value="Kurang Dari 1 Juta">Kurang Dari 1 Juta</option>
                                        <option {{ old('penghasilan_per_bulan') == '1 Juta - 2 Juta' ? 'selected' : '' }} value="1 Juta - 2 Juta">1 Juta - 2 Juta</option>
                                        <option {{ old('penghasilan_per_bulan') == '2 Juta - 3 Juta' ? 'selected' : '' }} value="2 Juta - 3 Juta">2 Juta - 3 Juta</option>
                                        <option {{ old('penghasilan_per_bulan') == '3 Juta - 5 Juta' ? 'selected' : '' }} value="3 Juta - 5 Juta">3 Juta - 5 Juta</option>
                                        <option {{ old('penghasilan_per_bulan') == '5 Juta - 10 Juta' ? 'selected' : '' }} value="5 Juta - 10 Juta">5 Juta - 10 Juta</option>
                                        <option {{ old('penghasilan_per_bulan') == 'Diatas 10 Juta' ? 'selected' : '' }} value="Diatas 10 Juta">Diatas 10 Juta</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row mb-4">
                            <div class="col-12 border-radius">
                                <h3>Login Dan Info Lain</h3>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="user_name" class="form-label">Username <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Isikan NISN"
                                        value="{{ old('user_name') }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="password" id="password" placeholder="Isikan NISN"
                                        value="{{ old('password') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="mb-3">
                                    <label for="informasi_pmb" class="form-label">Memperoleh Informasi Dari Mana?
                                        <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <textarea class="form-control" id="informasi_pmb" name="informasi_pmb" rows="3" value="">{{ old('informasi_pmb') }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="captcha">
                                    <span>{!! Captcha::img('flat') !!}</span>
                                    <button type="button" class="btn btn-danger reload" id="reload">&#x21bb;</button>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mt-2">
                                    <input type="text" class="form-control" name="captcha" id="captcha"
                                        placeholder="Input Captcha">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-lg-5">
                                <button type="submit" class="btn btn-light" style="padding:10px;box-shadow:5px 5px 10px">Submit Pendaftaran</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
