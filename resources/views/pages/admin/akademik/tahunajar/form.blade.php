@extends('layouts.admin')

@section('title')
    Form Tahun Ajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('tahunajar.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Form Tambah Tahun Ajaran</h5>
                <!-- Formulir input tahun ajaran -->
                <form method="post" action="{{ route('tahunajar.formPOST') }}" onsubmit="return validateForm()">
                    @csrf
                    <div class="mb-3">
                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                        <input required type="text" class="form-control" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran') }}" placeholder="Contoh: 2019/2020">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label><br/>
                        <input required type="radio" name="status" id="aktif" value="aktif" {{ old('status') == 'aktif' ? 'checked' : '' }}>
                        <label for="aktif" class="form-label">AKTIF</label><br/>
                        <input required type="radio" name="status" id="tidakaktif" value="tidak aktif" {{ old('status') == 'tidak aktif' ? 'checked' : '' }}>
                        <label for="tidakaktif" class="form-label">TIDAK AKTIF</label><br/>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function validateForm() {
            var tahunAjaranInput = document.getElementById('tahun_ajaran').value;

            // Validasi tambahan jika diperlukan
            var regex = /^\d{4}\/\d{4}$/;
            if (!regex.test(tahunAjaranInput)) {
                alert('Format tahun ajaran tidak valid. Gunakan format YYYY/YYYY.');
                return false;
            }

            // Formulir valid, kirim ke server
            return true;
        }
    </script>
@endpush