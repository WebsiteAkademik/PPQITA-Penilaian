@extends('layouts.admin')

@section('title')
    Edit Data Siswa
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

        if (checkboxAyah.checked) {
            checkboxAyah.value = 1;
            formPendaftaranAyah.classList.remove('d-none');
        } else {
            checkboxAyah.value = 0;
            formPendaftaranAyah.classList.add('d-none');
        }
        
        if (checkboxIbu.checked) {
            checkboxIbu.value = 1;
            formPendaftaranIbu.classList.remove('d-none');
        } else {
            checkboxIbu.value = 0;
            formPendaftaranIbu.classList.add('d-none');
        }

    </script>
@endpush

@section('content')
    

    
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
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
                    <form action="{{ route('siswa.update', $siswa->id) }}" method="post" id="form-updateprofile" class="mt-2">
                        @csrf
                        @method('put')
                        <div class="row mb-4">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_nisn" class="form-label">NISN<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="text" class="form-control" name="no_nisn" id="no_nisn"
                                        value="{{ $siswa->no_nisn }}">
                                </div>
                            </div>     
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="nama_siswa" class="form-label">Nama Siswa<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="text" class="form-control" name="nama_siswa" id="nama_siswa"
                                        value="{{ $siswa->nama_siswa }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger"
                                        style="font-weight: 700;font-size: 20px;">*</span></label>
                                <input required type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                                    value="{{ $siswa->tempat_lahir }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                                        value="{{ $siswa->tanggal_lahir }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin<span class="text-danger"
                                        style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <select required class="form-select" id="jenis_kelamin" name="jenis_kelamin" value="{{ $siswa->jenis_kelamin }}">
                                        <option {{ $siswa->jenis_kelamin == '' ? 'selected' : '' }} disabled>--- Pilih Jenis Kelamin ---</option>
                                        <option {{ $siswa->jenis_kelamin == 'LAKI-LAKI' ? 'selected' : '' }} value="LAKI-LAKI">LAKI-LAKI</option>
                                        <option {{ $siswa->jenis_kelamin == 'PEREMPUAN' ? 'selected' : '' }} value="PEREMPUAN">PEREMPUAN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_kartu_keluarga" class="form-label">Nomor Kartu Keluarga <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="text" class="form-control" name="no_kartu_keluarga" id="no_kartu_keluarga"
                                        value="{{ $siswa->no_kartu_keluarga }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_induk_keluarga" class="form-label">Nomor Induk Keluarga <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="text" class="form-control" name="no_induk_keluarga" id="no_induk_keluarga"
                                        value="{{ $siswa->no_induk_keluarga }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                <label for="agama" class="form-label">Agama<span class="text-danger"
                                        style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <select required class="form-select" id="agama" name="agama" value="{{ $siswa->agama }}">
                                        <option {{ $siswa->agama == '' ? 'selected' : '' }} disabled>--- Pilih Agama ---</option>
                                        <option {{ $siswa->agama == 'Islam' ? 'selected' : '' }} value="Islam">Islam</option>
                                        <option {{ $siswa->agama == 'Kristen' ? 'selected' : '' }} value="Kristen">Kristen</option>
                                        <option {{ $siswa->agama == 'Katolik' ? 'selected' : '' }} value="Katolik">Katolik</option>
                                        <option {{ $siswa->agama == 'Hindu' ? 'selected' : '' }} value="Hindu">Hindu</option>
                                        <option {{ $siswa->agama == 'Budha' ? 'selected' : '' }} value="Budha">Budha</option>
                                        <option {{ $siswa->agama == 'Konghucu' ? 'selected' : '' }} value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="tinggi_badan" class="form-label">Tinggi Badan <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="number" class="form-control" name="tinggi_badan" id="tinggi_badan"
                                        value="{{ $siswa->tinggi_badan }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="berat_badan" class="form-label">Berat Badan <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="number" class="form-control" name="berat_badan" id="berat_badan"
                                        value="{{ $siswa->berat_badan }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_wa_anak" class="form-label">Nomor WhatsApp Anak<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="text" class="form-control" name="no_wa_anak" id="no_wa_anak"
                                        value="{{ $siswa->no_wa_anak }}">
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-3">
                                    <label for="penyakit_kronis" class="form-label">Memiliki Penyakit Kronis<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;"></span></label>
                                    <textarea class="form-control" name="penyakit_kronis" id="penyakit_kronis"
                                        value="">{{ $siswa->penyakit_kronis }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 border-radius">
                                <h3>Alamat</h3>
                            </div>
                            <div class="col-12 col-12">
                                <div class="mb-3">
                                    <label for="alamat_rumah" class="form-label">Jalan <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <textarea required required class="form-control" id="alamat_rumah" name="alamat_rumah" rows="3"
                                        value="">{{ $siswa->alamat_rumah }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="dukuh" class="form-label">Dukuh<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="text" class="form-control" name="dukuh" id="dukuh"
                                        value="{{ $siswa->dukuh }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="kelurahan" class="form-label">Kelurahan<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="text" class="form-control" name="kelurahan" id="kelurahan"
                                        value="{{ $siswa->kelurahan }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="text" class="form-control" name="kecamatan" id="kecamatan"
                                        value="{{ $siswa->kecamatan }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="kabupaten" class="form-label">Kabupaten / Kota<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="text" class="form-control" name="kabupaten" id="kabupaten"
                                        value="{{ $siswa->kabupaten }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="kodepos" class="form-label">Kode Pos<span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="text" class="form-control" name="kodepos" id="kodepos"
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
                                    <label for="asal_sekolah" class="form-label">Asal Sekolah <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="text" class="form-control" name="asal_sekolah" id="asal_sekolah"
                                        value="{{ $siswa->asal_sekolah }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="bg-white text-dark px-3 py-2 d-flex gap-1 ms-auto"
                                    style="border-radius: 2rem">
                                    <div class="ms-1">
                                        <input type="checkbox" name="ayah_hidup" id="ayah_hidup" {{ $siswa->ayah_hidup == '1' ? 'checked' : '' }} >
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
                                        value="{{ $siswa->nama_ayah }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="pekerjaan_ayah" id="pekerjaan_ayah"
                                        value="{{ $siswa->pekerjaan_ayah }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="bg-white text-dark px-3 py-2 d-flex gap-1 ms-auto"
                                    style="border-radius: 2rem">
                                    <div class="ms-1">
                                        <input type="checkbox" name="ibu_hidup" id="ibu_hidup" {{ $siswa->ibu_hidup == '1' ? 'checked' : '' }} >
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
                                        value="{{ $siswa->nama_ibu }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input type="text" class="form-control" name="pekerjaan_ibu" id="pekerjaan_ibu"
                                        value="{{ $siswa->pekerjaan_ibu }}">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="form-contact-ortu">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="no_telepon_ortu" class="form-label">Nomor Whatsapp Orang Tua <span class="text-danger"
                                            style="font-weight: 700;font-size: 20px;">*</span></label>
                                    <input required type="text" class="form-control" name="no_telepon_ortu" id="no_telepon_ortu"
                                        value="{{ $siswa->no_telepon_ortu }}">
                                </div>
                            </div>                            
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-lg-5">
                                <button type="submit" class="btn btn-primary" style="padding:10px;box-shadow:5px 5px 10px">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
