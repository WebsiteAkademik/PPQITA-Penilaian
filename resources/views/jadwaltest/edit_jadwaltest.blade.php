@extends('layouts.admin')

@section('title', 'Edit Jadwal Test')

@section('content')
    <div class="container">
        <h1>Edit Jadwal Test</h1>
        <br>

        {{-- Tampilkan pesan sukses jika ada --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form untuk mengedit jadwal test --}}
        <form action="{{ route('jadwaltest.update', $jadwalTest->id) }}" method="post">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="nama_calon_siswa">Nama Calon Siswa:</label>
                <input type="text" class="form-control" id="nama_calon_siswa" name="nama_calon_siswa" value="{{ $jadwalTest->nama_calon_siswa }}">
            </div>

            <div class="form-group">
                <label for="tanggal_test">Tanggal Test:</label>
                <input type="date" class="form-control" id="tanggal_test" name="tanggal_test" value="{{ $jadwalTest->tanggal_test }}">
            </div>

            <div class="form-group">
                <label for="jam_test">Jam Test:</label>
                <input type="time" class="form-control" id="jam_test" name="jam_test" value="{{ $jadwalTest->jam_test }}">
            </div>

            <div class="form-group">
                <label for="jenis_test">Jenis Test:</label>
                <input type="text" class="form-control" id="jenis_test" name="jenis_test" value="{{ $jadwalTest->jenis_test }}">
            </div>

            <div class="form-group">
                <label for="pic_test">PIC:</label>
                <input type="text" class="form-control" id="pic_test" name="pic_test" value="{{ $jadwalTest->pic_test }}">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
@endsection
