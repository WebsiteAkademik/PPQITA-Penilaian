
@extends('layouts.admin')

@section('title', 'Input Jadwal Test Peserta')

@section('content')
    <div class="container">
        <h3 class="d-flex align-items-center justify-content-between">
            <a href="{{ route('jadwaltest.list') }}" class="btn btn-primary mb-3">Lihat Daftar Jadwal Test</a>
        </h3>
        <br>
        <h1>Input Jadwal Test Peserta</h1>
        <h4>Masukkan data peserta yang hendak dijadwal disini</h4>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <!-- Formulir input jadwal test -->
        <form method="post" action="{{ route('jadwaltest.store') }}">
            @csrf
            <div class="mb-3">
                <label for="no_pendaftaran" class="form-label">No Pendaftaran</label>
                <select name="no_pendaftaran" class="form-select" required>
                    <option value="" disabled selected>Pilih No Pendaftaran</option>
                    @foreach ($pendaftars as $pendaftar)
                        <option value="{{ $pendaftar->no_pendaftaran }}">{{ $pendaftar->no_pendaftaran }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_test" class="form-label">Tanggal Test</label>
                <input type="date" name="tanggal_test" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jam_test" class="form-label">Jam Test</label>
                <input type="time" name="jam_test" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="metode_test" class="form-label">Metode Test</label>
                <select name="metode_test" class="form-select" required>
                    <option value="Zoom Meeting">Zoom Meeting</option>
                    <option value="Google Meet">Google Meet</option>
                    <option value="Google Meet">Offline</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="info_test" class="form-label">Informasi Tambahan</label>
                <textarea name="info_test" class="form-control" cols="30" rows="10" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
