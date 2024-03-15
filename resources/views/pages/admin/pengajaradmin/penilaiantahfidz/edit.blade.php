@extends('layouts.admin')

@section('title')
    Edit Penilaian Tahfidz
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('penilaiantahfidz.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Edit Nilai Siswa</h5>
                <!-- Form untuk edit Penilaian Tahfidz -->
                <form method="post" action="{{ route('penilaiantahfidz.update', $penilaian->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="tanggal_penilaian" class="form-label">Tanggal Penilaian</label>
                        <input required type="date" class="form-control" name="tanggal_penilaian" id="tanggal_penilaian" value="{{ $penilaian->tanggal_penilaian }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="siswa_id" class="form-label">Siswa</label>
                        <input type="hidden" name="siswa_id" id="siswa_id" value="{{ $penilaian->siswa_id }}">
                        <input disabled type="text" class="form-control" name="nama_siswa" id="nama_siswa" value="{{ $penilaian->siswaID()->nama_siswa }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label">Kelas</label>
                        <input type="hidden" name="kelas_id" id="kelas_id" value="{{ $penilaian->kelas_id }}">
                        <input disabled type="text" class="form-control" name="kelas" id="kelas" value="{{ $penilaian->kelasID()->kelas }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="jenis_penilaian" class="form-label">Jenis Penilaian</label>
                        <select required class="form-select" id="jenis_penilaian" name="jenis_penilaian">
                            <option value="" disabled>--- Pilih Jenis Penilaian ---</option>
                            <option value="Setoran Baru" {{ $penilaian->jenis_penilaian == 'Setoran Baru' ? 'selected' : '' }}>Setoran Baru</option>
                            <option value="Hafalan Sugra" {{ $penilaian->jenis_penilaian == 'Hafalan Sugra' ? 'selected' : '' }}>Hafalan Sugra</option>
                            <option value="Hafalan Qubra" {{ $penilaian->jenis_penilaian == 'Hafalan Qubra' ? 'selected' : '' }}>Hafalan Qubra</option>
                            <option value="Tasmik" {{ $penilaian->jenis_penilaian == 'Tasmik' ? 'selected' : '' }}>Tasmik</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="surat_awal" class="form-label">Surat Awal</label>
                        <input required type="text" class="form-control" name="surat_awal" id="surat_awal" value="{{ $penilaian->surat_awal }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="surat_akhir" class="form-label">Surat Akhir</label>
                        <input required type="text" class="form-control" name="surat_akhir" id="surat_akhir" value="{{ $penilaian->surat_akhir }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="ayat_awal" class="form-label">Ayat Awal</label>
                        <input required type="number" class="form-control" name="ayat_awal" id="ayat_awal" value="{{ $penilaian->ayat_awal }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="ayat_akhir" class="form-label">Ayat Akhir</label>
                        <input required type="number" class="form-control" name="ayat_akhir" id="ayat_akhir" value="{{ $penilaian->ayat_akhir }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="nilai" class="form-label">Nilai</label>
                        <input required type="number" class="form-control" name="nilai" id="nilai" value="{{ $penilaian->nilai }}" placeholder="">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection