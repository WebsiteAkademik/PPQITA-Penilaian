@extends('layouts.admin')

@section('title')
    Edit Data Siswa
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('pengajar.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Edit Data Siswa</h5>
                <!-- Formulir edit data pengajar -->
                <form method="post" action="{{ route('pengajar.update', $pengajar->id) }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="nama_pengajar" class="form-label">No.</label>
                        <input required type="text" class="form-control" name="nama_pengajar" id="nama_pengajar" value="{{ $pengajar->nama_pengajar }}">
                    </div>
                    <div class="mb-3">
                        <label for="no_nisn" class="form-label">NISN</label>
                        <textarea class="form-control" id="no_nisn" name="no_nisn" rows="3" value="">{{ $pengajar->no_nisn }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">Nama Siswa</label>
                        <input required type="text" class="form-control" name="nama_siswa" id="nama_siswa" value="{{ $pengajar->nama_siswa }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input required type="text" class="form-control" name="kelas" id="kelas" value="{{ $pengajar->kelas }}" placeholder="">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection