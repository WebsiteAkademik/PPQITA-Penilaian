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

            <div class="mb-3">
                <label for="nama_calon_siswa" class="form-label">Nama Calon Siswa</label>
                <select name="nama_calon_siswa" class="form-select" required>
                    <option value="{{ $jadwalTest->pendaftaran()->nama_calon_siswa }}" selected>{{ $jadwalTest->pendaftaran()->nama_calon_siswa }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_test" class="form-label">Tanggal Test</label>
                <input type="date" name="tanggal_test" class="form-control" value="{{ $jadwalTest->tanggal_test }}" required>
            </div>
            <div class="mb-3">
                <label for="jam_test" class="form-label">Jam Test</label>
                <input type="time" name="jam_test" class="form-control" value="{{ $jadwalTest->jam_test }}" required>
            </div>
            <div class="mb-3">
                <label for="jenis_test" class="form-label">Jenis Test</label>
                <textarea class="form-control" id="jenis_test" name="jenis_test" rows="3" required>{{ $jadwalTest->jenis_test }}</textarea>
            </div>
            <div class="mb-3">
                <label for="pic_test" class="form-label">PIC</label>
                <select name="pic_test" class="form-select" required>
                    <option {{ $jadwalTest->pic_test == "Ust. Dutha Bahari" ? 'selected' : '' }} value="Ust. Dutha Bahari">Ust Dutha Bahari</option>
                    <option {{ $jadwalTest->pic_test == "Dhanny Ardiansyah" ? 'selected' : '' }} value="Dhanny Ardiansyah">Dhanny Ardiansyah</option>
                    <option {{ $jadwalTest->pic_test == "Diyan Utami" ? 'selected' : '' }} value="Diyan Utami">Diyan Utami</option>
                </select>
            </div>            
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
        <br>
        <form action="{{ route('jadwaltest.delete', $jadwalTest->id) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
@endsection
