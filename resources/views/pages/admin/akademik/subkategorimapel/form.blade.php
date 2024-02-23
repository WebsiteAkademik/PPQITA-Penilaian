@extends('layouts.admin')

@section('title')
    Form Sub Kategori Pelajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('subkategori.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Form Tambah Sub Kategori Pelajaran</h5>
                <!-- Formulir input kategori pelajaran -->
                <form method="post" action="{{ route('subkategori.formPOST') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_sub_kategori" class="form-label">Kode Sub Kategori</label>
                        <input required type="text" class="form-control" name="kode_sub_kategori" id="kode_sub_kategori" value="{{ old('kode_sub_kategori') }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="nama_sub_kategori" class="form-label">Sub Kategori Pelajaran</label>
                        <input required type="text" class="form-control" name="nama_sub_kategori" id="nama_sub_kategori" value="{{ old('nama_sub_kategori') }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Kategori Pelajaran</label>
                        <select name="kategori_pelajaran_id" class="form-select" required>
                            <option value="" disabled selected>Kategori</option>
                            @foreach ($kategori as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection