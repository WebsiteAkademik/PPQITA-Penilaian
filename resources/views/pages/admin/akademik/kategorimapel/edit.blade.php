@extends('layouts.admin')

@section('title')
    Edit Kategori Pelajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('kategori.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Edit Kategori Pelajaran</h5>

                {{-- Tampilkan pesan sukses jika ada --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Form untuk edit Kategori Pelajaran -->
                <form method="post" action="{{ route('kategori.update', $kategori->id) }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="kode_kategori" class="form-label">Kode Kategori</label>
                        <input required type="text" class="form-control" name="kode_kategori" id="kode_kategori" value="{{ $kategori->kode_kategori }}">
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Kategori Pelajaran</label>
                        <input required type="text" class="form-control" name="nama_kategori" id="nama_kategori" value="{{ $kategori->nama_kategori }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection