@extends('layouts.admin')

@section('title')
    Form Tahun Ajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-title fs-6 fw-semibold mb-4">Form Tambah Tahun Ajaran</h5>
                <!-- Formulir input tahun ajaran -->
                <form method="post" action="{{ route('form_tahun-ajarPOST') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                        <input required type="text" class="form-control" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran') }}">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label><br/>
                        <input required type="radio" name="status" id="aktif" value="aktif">
                        <label for="aktif" class="form-label">AKTIF</label><br/>
                        <input required type="radio" name="status_tahunajar" id="tidakaktif" value="tidak aktif">
                        <label for="tidakaktif" class="form-label">TIDAK AKTIF</label><br/>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection