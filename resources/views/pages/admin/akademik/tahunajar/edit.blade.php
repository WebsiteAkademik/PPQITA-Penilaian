@extends('layouts.admin')

@section('title')
    Edit Tahun Ajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('tahunajar.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Edit Tahun Ajaran</h5>

                {{-- Tampilkan pesan sukses jika ada --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Form untuk edit Tahun Ajaran -->
                <form method="post" action="{{ route('tahunajar.update', $tahunajar->id) }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                        <input required type="text" class="form-control" name="tahun_ajaran" id="tahun_ajaran" value="{{ $tahunajar->tahun_ajaran }}">
                    </div>
                    <div class="mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <select required class="form-select" id="semester" name="semester">
                            <option value="" disabled>--- Pilih Semester ---</option>
                            <option value="Ganjil" {{ $tahunajar->semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap" {{ $tahunajar->semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label><br/>
                        <input required type="radio" name="status" id="aktif" value="aktif" {{ $tahunajar->status == 'aktif' ? 'checked' : '' }}>
                        <label for="aktif" class="form-label">AKTIF</label><br/>
                        <input required type="radio" name="status" id="tidakaktif" value="tidak aktif" {{ $tahunajar->status == 'tidak aktif' ? 'checked' : '' }}>
                        <label for="tidakaktif" class="form-label">TIDAK AKTIF</label><br/>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection