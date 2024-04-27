@extends('layouts.admin')

@section('title')
    Edit Detail Setup Mata Pelajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('detail.index', $setup->id) }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Edit Detail Setup Mata Pelajaran</h5>
                <!-- Formulir input setup mata pelajaran -->
                <form method="post" action="{{ route('detail.update', ['id' => $setup->id, 'id2' => $detail->id]) }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="jam_pelajaran" class="form-label">Jam Pelajaran yang Harus diperoleh</label>
                        <input required type="number" class="form-control" name="jam_pelajaran" id="jam_pelajaran" value="{{ $detail->jam_pelajaran }}" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="nama_mata_pelajaran" class="form-label">Mata Pelajaran</label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select" required>
                            <option value="" disabled selected>--- Pilih Mata Pelajaran ---</option>
                            @foreach ($mapel as $mapel)
                                <option value="{{ $mapel->id }}" {{ $detail->mata_pelajaran_id == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mata_pelajaran }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kkm" class="form-label">KKM</label>
                        <input required type="number" class="form-control" name="kkm" id="kkm" value="{{ $detail->kkm }}" placeholder="">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection