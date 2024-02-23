@extends('layouts.admin')

@section('title')
    Edit Sub Kategori Pelajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('subkategori.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Edit Sub Kategori Pelajaran</h5>

                {{-- Tampilkan pesan sukses jika ada --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Form untuk edit Sub Kategori Pelajaran -->
                <form method="post" action="{{ route('subkategori.update', $subkategori->id) }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="kode_sub_kategori" class="form-label">Kode Sub Kategori</label>
                        <input required type="text" class="form-control" name="kode_sub_kategori" id="kode_sub_kategori" value="{{ $subkategori->kode_sub_kategori }}">
                    </div>
                    <div class="mb-3">
                        <label for="nama_sub_kategori" class="form-label">Sub Kategori Pelajaran</label>
                        <input required type="text" class="form-control" name="nama_sub_kategori" id="nama_sub_kategori" value="{{ $subkategori->nama_sub_kategori }}">
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Kategori Pelajaran</label>
                        <select name="kategori_pelajaran_id" class="form-select" required>
                            <option value="{{ $subkategori->kategori_pelajaran_id }}" selected>{{ $subkategori->kategoriID()->nama_kategori }}</option>
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