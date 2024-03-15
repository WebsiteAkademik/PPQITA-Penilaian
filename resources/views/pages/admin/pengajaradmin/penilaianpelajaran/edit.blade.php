@extends('layouts.admin')

@section('title')
    Edit Penilaian Pelajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('penilaianpelajaran.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Edit Nilai Siswa</h5>
                <!-- Form untuk edit Penilaian Pelajaran -->
                <form method="post" action="{{ route('penilaianpelajaran.update', $penilaian->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="tanggal_penilaian" class="form-label">Tanggal Penilaian</label>
                        <input required type="date" class="form-control" name="tanggal_penilaian" id="tanggal_penilaian" value="{{ $penilaian->tanggal_penilaian }}" placeholder="Kode harus terdiri atas 10 digit">
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
                        <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran</label>
                        <input type="hidden" name="mata_pelajaran_id" id="mata_pelajaran_id" value="{{ $penilaian->mata_pelajaran_id }}">
                        <input disabled type="text" class="form-control" name="nama_mata_pelajaran" id="nama_mata_pelajaran" value="{{ $penilaian->mapelID()->nama_mata_pelajaran }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="jenis_ujian" class="form-label">Jenis Ujian</label>
                        <select required class="form-select" id="jenis_ujian" name="jenis_ujian">
                            <option value="" disabled>--- Pilih Jenis Ujian ---</option>
                            <option value="Penilaian Harian" {{ $penilaian->jenis_ujian == 'Penilaian Harian' ? 'selected' : '' }}>Penilaian Harian</option>
                            <option value="UTS" {{ $penilaian->jenis_ujian == 'UTS' ? 'selected' : '' }}>UTS</option>
                            <option value="UAS" {{ $penilaian->jenis_ujian == 'UAS' ? 'selected' : '' }}>UAS</option>
                        </select>
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