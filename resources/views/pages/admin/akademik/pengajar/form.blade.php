@extends('layouts.admin')

@section('title')
    Form Pengajar
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('pengajar.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Form Tambah Pengajar</h5>
                <!-- Formulir input pengajar -->
                <form method="post" action="{{ route('pengajar.formPOST') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_pengajar" class="form-label">Nama Pengajar</label>
                        <input required type="text" class="form-control" name="nama_pengajar" id="nama_pengajar" value="{{ old('nama_pengajar') }}">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" value="">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="no_wa_pengajar" class="form-label">Nomor WA</label>
                        <input required type="text" class="form-control" name="no_wa_pengajar" id="no_wa_pengajar" value="{{ old('no_wa_pengajar') }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input required type="text" class="form-control" name="username" id="username" value="{{ old('username') }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input required type="text" class="form-control" name="password" id="password" value="{{ old('password') }}" placeholder="">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection