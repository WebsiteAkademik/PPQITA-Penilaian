@extends('layouts.admin')

@section('title')
    Form Mata Pelajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('mapel.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Form Tambah Mata Pelajaran</h5>
                <!-- Formulir input kategori pelajaran -->
                <form method="post" action="{{ route('mapel.formPOST') }}" onsubmit="return validateKode()">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_mata_pelajaran" class="form-label">Kode Pelajaran</label>
                        <input required type="text" class="form-control" name="kode_mata_pelajaran" id="kode_mata_pelajaran" value="{{ old('kode_mata_pelajaran') }}" placeholder="Kode harus terdiri atas 10 digit">
                    </div>
                    <div class="mb-3">
                        <label for="nama_mata_pelajaran" class="form-label">Nama Mata Pelajaran</label>
                        <input required type="text" class="form-control" name="nama_mata_pelajaran" id="nama_mata_pelajaran" value="{{ old('nama_mata_pelajaran') }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="kkm" class="form-label">KKM</label>
                        <input required type="number" class="form-control" name="kkm" id="kkm" value="{{ old('kkm') }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Kategori Pelajaran</label>
                        <select name="kategori_pelajaran_id" id="kategori_pelajaran_id" class="form-select" onchange="getSubKategori()" required>
                            <option value="" disabled selected>Kategori</option>
                            @foreach ($kategori as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_sub_kategori" class="form-label">Sub Kategori Pelajaran</label>
                        <select name="sub_kategori_pelajaran_id" id="sub_kategori_pelajaran_id" class="form-select" required>
                            <option value="" disabled selected>Sub Kategori</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function getSubKategori() {
            var kategoriId = document.getElementById('kategori_pelajaran_id').value;
            var subKategoriSelect = document.getElementById('sub_kategori_pelajaran_id');

            //Menghapus option yang ada
            subKategoriSelect.innerHTML = '<option value="" disabled selected>Sub Kategori</option>';

            //Mengambil function select sub kategori yang terelasi dengan kategori yang dipilih
            @foreach ($subkategori as $subkat)
                if ({{ $subkat->kategori_id }} == kategoriId) {
                    var option = document.createElement('option');
                    option.value = '{{ $subkat->id }}';
                    option.text = '{{ $subkat->nama_sub_kategori }}';
                    subKategoriSelect.appendChild(option);
                }
            @endforeach
        }

        function validateKode() {
            var kodeInput = document.getElementById('kode_mata_pelajaran').value;

            // Validasi tambahan jika diperlukan
            var regex = /^[a-zA-Z0-9]{10}$/;
            if (!regex.test(kodeInput)) {
                alert('Format kode mata pelajaran tidak valid. Kode mata pelajaran harus terdiri atas 10 digit.');
                return false;
            }

            // Formulir valid, kirim ke server
            return true;
        }
    </script>
@endpush