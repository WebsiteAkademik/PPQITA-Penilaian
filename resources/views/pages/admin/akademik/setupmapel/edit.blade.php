@extends('layouts.admin')

@section('title')
    Edit Setup Mata Pelajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('setup.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Edit Setup Mata Pelajaran</h5>

                {{-- Tampilkan pesan sukses jika ada --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Form untuk edit Setup Mata Pelajaran -->
                <form method="post" action="{{ route('setup.update', $setup->id) }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="tanggal_setup" class="form-label">Tanggal Setup</label>
                        <input required type="date" class="form-control" name="tanggal_setup" id="tanggal_setup" value="{{ $setup->tanggal_setup }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label">Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="form-select" required>
                            <option value="" disabled selected>Kelas</option>
                            @foreach ($kelas as $kelas)
                                <option value="{{ $kelas->id }}" {{ $setup->kelas_id == $kelas->id ? 'selected' : '' }}>{{ $kelas->kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_pengajar" class="form-label">Pengajar</label>
                        <select name="pengajar_id" id="pengajar_id" class="form-select" required>
                            <option value="" disabled selected>Pengajar</option>
                            @foreach ($pengajar as $pengajar)
                                <option value="{{ $pengajar->id }}" {{ $setup->pengajar_id == $pengajar->id ? 'selected' : '' }}>{{ $pengajar->nama_pengajar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection