
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
                <label for="nama_calon_siswa" class="form-label">Nama Calon Siswa</label>
                <select name="nama_calon_siswa" class="form-select" required>
                    <option value="" disabled selected>Nama</option>
                    @foreach ($pendaftars as $pendaftar)
                        <option value="{{ $pendaftar->nama_calon_siswa }}">{{ $pendaftar->nama_calon_siswa }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_test" class="form-label">Tanggal Test</label>
                <input type="date" name="tanggal_test" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="time" name="jam_test" class="form-control" required>
                <label for="jam_test" class="form-label">Jam Test</label>                
            </div>
            <div class="mb-3">
                <label for="jenis_test" class="form-label">Jenis Test</label>
                <select name="jenis_test" class="form-select" required>
                    <option value="Umum">Umum</option>
                    <option value="Dinniyah">Dinniyah</option>
                    <option value="Hafalan">Hafalan</option>
                    <option value="Matematika">Matematika</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pic_test" class="form-label">PIC</label>
                <select name="pic_test" class="form-select" required>
                    <option value="Ust. Dutha Bahari">Ust Dutha Bahari</option>
                    <option value="Dhanny Ardiansyah">Dhanny Ardiansyah</option>
                    <option value="Diyan Utami">Diyan Utami</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
