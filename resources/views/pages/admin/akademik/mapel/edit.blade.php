@extends('layouts.admin')

@section('title')
    Edit Mata Pelajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('mapel.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Edit Mata Pelajaran</h5>

                {{-- Tampilkan pesan sukses jika ada --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Form untuk edit Mata Pelajaran -->
                <form method="post" action="{{ route('mapel.update', $mapel->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="kode_mata_pelajaran" class="form-label">Kode Pelajaran</label>
                        <input required type="text" class="form-control" name="kode_mata_pelajaran" id="kode_mata_pelajaran" value="{{ $mapel->kode_mata_pelajaran }}">
                    </div>
                    <div class="mb-3">
                        <label for="nama_mata_pelajaran" class="form-label">Nama Mata Pelajaran</label>
                        <input required type="text" class="form-control" name="nama_mata_pelajaran" id="nama_mata_pelajaran" value="{{ $mapel->nama_mata_pelajaran }}">
                    </div>
                    <div class="mb-3">
                        <label for="kkm" class="form-label">KKM</label>
                        <input required type="number" class="form-control" name="kkm" id="kkm" value="{{ $mapel->kkm }}">
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Kategori Pelajaran</label>
                        <select name="kategori_pelajaran_id" id="kategori_pelajaran_id_edit" class="form-select" onchange="getSubKategoriEdit()" required>
                            <option value="" disabled selected>Kategori</option>
                            @foreach ($kategori as $kategori)
                                <option value="{{ $kategori->id }}" {{ $mapel->kategori_pelajaran_id == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_sub_kategori" class="form-label">Sub Kategori Pelajaran</label>
                        <select name="sub_kategori_pelajaran_id" id="sub_kategori_pelajaran_id_edit" class="form-select" required>
                            <option value="" disabled selected>Sub Kategori</option>
                            @foreach ($subkategori as $subkat)
                                @if($mapel->sub_kategori_pelajaran_id == $subkat->id)
                                    <option value="{{ $subkat->id }}" selected>{{ $subkat->nama_sub_kategori }}</option>
                                @endif
                            @endforeach
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
        document.addEventListener('DOMContentLoaded', function() {
            getSubKategoriEdit();
        });

        function getSubKategoriEdit() {
            var kategoriId = document.getElementById('kategori_pelajaran_id_edit').value;
            var subKategoriSelect = document.getElementById('sub_kategori_pelajaran_id_edit');

            // Menghapus option yang ada
            subKategoriSelect.innerHTML = '';

            // Menambahkan sub kategori yang terelasi dengan kategori yang dipilih
            @foreach ($subkategori as $subkat)
                if ({{ $subkat->kategori_id }} == kategoriId) {
                    var option = document.createElement('option');
                    option.value = '{{ $subkat->id }}';
                    option.text = '{{ $subkat->nama_sub_kategori }}';
                    if ({{ $mapel->sub_kategori_pelajaran_id }} == {{ $subkat->id }}) {
                        option.selected = true;
                    }
                    subKategoriSelect.appendChild(option);
                }
            @endforeach
        }
    </script>
@endpush