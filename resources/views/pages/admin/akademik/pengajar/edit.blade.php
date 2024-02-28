@extends('layouts.admin')

@section('title')
    Edit Data Pengajar
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('pengajar.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Edit Data Pengajar</h5>
                <!-- Formulir edit data pengajar -->
                <form method="post" action="{{ route('pengajar.update', $pengajar->id) }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="nama_pengajar" class="form-label">Nama Pengajar</label>
                        <input required type="text" class="form-control" name="nama_pengajar" id="nama_pengajar" value="{{ $pengajar->nama_pengajar }}">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" value="">{{ $pengajar->alamat }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="no_wa_pengajar" class="form-label">Nomor WA</label>
                        <input required type="text" class="form-control" name="no_wa_pengajar" id="no_wa_pengajar" value="{{ $pengajar->no_wa_pengajar }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="nama_mata_pelajaran" class="form-label">Mapel yang Diampu</label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select" required>
                            <option value="" disabled selected>Mata Pelajaran</option>
                            @foreach ($mapel as $mapel)
                                <option value="{{ $mapel->id }}" {{ $pengajar->mata_pelajaran_id == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mata_pelajaran }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection