@extends('layouts.admin')

@section('title')
    Form Kelas
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('kelas.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Form Tambah Kelas</h5>
                <!-- Formulir input kelas -->
                <form method="post" action="{{ route('kelas.formPOST') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input required type="text" class="form-control" name="kelas" id="kelas" value="{{ old('kelas') }}" placeholder="Contoh: XA">
                    </div>
                    <div class="mb-3">
                        <label for="nama_pengajar" class="form-label">Wali Kelas</label>
                        <select name="pengajar_id" id="pengajar_id" class="form-select" required>
                            <option value="" disabled selected>--- Pilih Nama Wali Kelas ---</option>
                            @foreach ($pengajar as $pengajar)
                                <option value="{{ $pengajar->id }}">{{ $pengajar->nama_pengajar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection