@extends('layouts.admin')

@section('title')
    Edit Jadwal Ujian
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('jadwalujian.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Edit Jadwal Ujian</h5>

                {{-- Tampilkan pesan sukses jika ada --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Form untuk edit jadwal ujian -->
                <form method="post" action="{{ route('jadwalujian.update', $jadwalujian->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="tanggal_ujian" class="form-label">Tanggal Ujian</label>
                        <input required type="date" class="form-control" name="tanggal_ujian" id="tanggal_ujian" value="{{ $jadwalujian->tanggal_ujian }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="jam_ujian" class="form-label">Waktu Ujian</label>
                        <input required type="time" class="form-control" name="jam_ujian" id="jam_ujian" value="{{ $jadwalujian->jam_ujian }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label">Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="form-select" required>
                            <option value="" disabled selected>Kelas</option>
                            @foreach ($kelas as $kelasItem)
                                <option value="{{ $kelasItem->id }}" {{ $kelasItem->id == $jadwalujian->kelas_id ? 'selected' : '' }}>{{ $kelasItem->kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_ujian" class="form-label">Jenis Ujian</label>
                        <select required class="form-select" id="jenis_ujian" name="jenis_ujian">
                            <option value="" disabled>--- Pilih Jenis Ujian ---</option>
                            <option value="Penilaian Harian" {{ $jadwalujian->jenis_ujian == 'Penilaian Harian' ? 'selected' : '' }}>Penilaian Harian</option>
                            <option value="UTS" {{ $jadwalujian->jenis_ujian == 'UTS' ? 'selected' : '' }}>UTS</option>
                            <option value="UAS" {{ $jadwalujian->jenis_ujian == 'UAS' ? 'selected' : '' }}>UAS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran</label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select" required>
                            <option value="" disabled selected>Mata Pelajaran</option>
                            @foreach ($mapel as $mapelItem)
                                <option value="{{ $mapelItem->id }}" {{ $mapelItem->id == $jadwalujian->mata_pelajaran_id ? 'selected' : '' }}>{{ $mapelItem->nama_mata_pelajaran }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                        <input type="hidden" name="tahun_ajaran_id" id="tahun_ajaran_id" value="{{ $jadwalujian->tahun_ajaran_id }}">
                        <input type="text" class="form-control" id="tahun_ajaran" value="{{ $jadwalujian->tahunAjaran()->tahun_ajaran }}" disabled>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
