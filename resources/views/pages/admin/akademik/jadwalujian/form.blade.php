@extends('layouts.admin')

@section('title')
    Form Input Jadwal Ujian
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('jadwalujian.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Form Input Jadwal Ujian</h5>
                <!-- Formulir input jadwal ujian -->
                <form method="post" action="{{ route('jadwalujian.formPOST') }}" onsubmit="return validateKode()">
                    @csrf
                    <div class="mb-3">
                        <label for="tanggal_ujian" class="form-label">Tanggal Ujian</label>
                        <input required type="date" class="form-control" name="tanggal_ujian" id="tanggal_ujian" value="{{ old('tanggal_ujian') }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="jam_ujian" class="form-label">Waktu Ujian</label>
                        <input required type="time" class="form-control" name="jam_ujian" id="jam_ujian" value="{{ old('jam_ujian') }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="form-select" required>
                            <option value="" disabled selected>Kelas</option>
                            @foreach ($kelas as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_ujian" class="form-label">Jenis Ujian</label>
                        <select required class="form-select" id="jenis_ujian" name="jenis_ujian" value="{{ old('jenis_ujian') }}">
                            <option {{ old('jenis_ujian') == '' ? 'selected' : '' }} disabled>--- Pilih Jenis Ujian ---</option>
                            <option {{ old('jenis_ujian') == 'Penilaian Harian' ? 'selected' : '' }} value="Penilaian Harian">Penilaian Harian</option>
                            <option {{ old('jenis_ujian') == 'UTS' ? 'selected' : '' }} value="UTS">UTS</option>
                            <option {{ old('jenis_ujian') == 'UAS' ? 'selected' : '' }} value="UAS">UAS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_mata_pelajaran" class="form-label">Mata Pelajaran</label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select" required>
                            <option value="" disabled selected>Mata Pelajaran</option>
                            @foreach ($mapel as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama_mata_pelajaran }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                        <input required type="hidden" class="form-control" name="tahun_ajaran_id" id="tahun_ajaran_id" value="{{ $tahunAjaran->id }}" placeholder="">
                        <input disabled type="text" class="form-control" id="tahun_ajaran_id" value="{{ $tahunAjaran->tahun_ajaran }}" placeholder="">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

