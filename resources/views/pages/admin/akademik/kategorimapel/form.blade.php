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
                <form method="post" action="{{ route('kategori.formPOST') }}" onsubmit="return validateKodeKategori()">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_kategori" class="form-label">Kode Kategori</label>
                        <input required type="text" class="form-control" name="kode_kategori" id="kode_kategori" value="{{ old('kode_kategori') }}" placeholder="Kode harus terdiri atas 10 digit">
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Kategori Pelajaran</label>
                        <input required type="text" class="form-control" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="Tulis Nama Kategori Pelajaran">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function validateKodeKategori() {
            var kodeKategoriInput = document.getElementById('kode_kategori').value;

            // Validasi tambahan jika diperlukan
            var regex = /^[a-zA-Z0-9]{10}$/;
            if (!regex.test(kodeKategoriInput)) {
                alert('Format kode kategori tidak valid. Kode kategori harus terdiri atas 10 digit.');
                return false;
            }

            // Formulir valid, kirim ke server
            return true;
        }
    </script>
@endpush
