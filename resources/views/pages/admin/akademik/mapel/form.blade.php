@extends('layouts.admin')

@section('title')
    Form Kategori Pelajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('kategori.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Form Tambah Kategori Pelajaran</h5>
                <!-- Formulir input kategori pelajaran -->
                <form method="post" action="{{ route('kategori.formPOST') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_pelajaran" class="form-label">Kode Pelajaran</label>
                        <input required type="text" class="form-control" name="kode_pelajaran" id="kode_pelajaran" value="{{ old('kode_pelajaran') }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="nama_mapel" class="form-label">Nama Mata Pelajaran</label>
                        <input required type="text" class="form-control" name="nama_mapel" id="nama_mapel" value="{{ old('nama_mapel') }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="kategori_pelajaran" class="form-label">Kategori Pelajaran</label>
                        <input required type="text" class="form-control" name="kategori_pelajaran" id="kategori_pelajaran" value="{{ old('kategori_pelajaran') }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="sub_kategori_pelajaran" class="form-label">Sub Kategori Pelajaran</label>
                        <input required type="text" class="form-control" name="sub_kategori_pelajaran" id="sub_kategori_pelajaran" value="{{ old('sub_kategori_pelajaran') }}" placeholder="">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection