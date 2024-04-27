@extends('layouts.pengajar')

@section('title')
    Form Penilaian Pelajaran
@endsection

@section('content')
    <div class="col-lg-12 d-flex align-items-stretch" id="form-container">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('penilaianpelajaran.index') }}" class="btn btn-primary m-1">Batal</a>
                </div><br/>
                <h5 class="card-title fs-6 fw-semibold mb-4">Form Penilaian Pelajaran</h5>
                <!-- Formulir input penilaian pelajaran -->
                <form method="post" action="{{ route('penilaianpelajaran.formPOST') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="tanggal_penilaian" class="form-label">Tanggal Penilaian</label>
                        <input required type="date" class="form-control" name="tanggal_penilaian" id="tanggal_penilaian" value="{{ old('tanggal_penilaian') }}">
                    </div>
                    <div class="mb-3" hidden>
                        <label for="nama_pengajar" class="form-label">Pengajar</label>
                        <input required type="hidden" class="form-control" name="pengajar_id" id="pengajar_id" value="{{ $pengajar -> id }}">
                        <input disabled type="text" class="form-control" name="pengajar_id" id="pengajar_id" value="{{ $pengajar -> nama_pengajar }}">
                    </div>
                    <div class="mb-3" hidden>
                        <label for="tahun_ajaran" class="form-label">Pengajar</label>
                        <input required type="hidden" class="form-control" name="tahun_ajaran_id" id="tahun_ajaran_id" value="{{ $tahunAjaranAktif -> id }}">
                        <input disabled type="text" class="form-control" name="tahun_ajaran_id" id="tahun_ajaran_id" value="{{ $tahunAjaranAktif -> tahun_ajaran }}">
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="form-select" onchange="inputClass()" required>
                            <option value="" disabled selected>--- Pilih Kelas ---</option>
                            @foreach ($kelas as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">Siswa</label>
                        <select name="siswa_id" id="siswa_id" class="form-select" required>
                            <option value="" disabled selected>--- Pilih Nama Siswa ---</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_mata_pelajaran" class="form-label">Mata Pelajaran</label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select" required>
                            <option value="" disabled selected>--- Pilih Mata Pelajaran ---</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_ujian" class="form-label">Jenis Penilaian</label>
                        <select required class="form-select" id="jenis_ujian" name="jenis_ujian" value="{{ old('jenis_ujian') }}">
                            <option {{ old('jenis_ujian') == '' ? 'selected' : '' }} disabled>--- Pilih Jenis Penilaian ---</option>
                            <option {{ old('jenis_ujian') == 'Penilaian Harian' ? 'selected' : '' }} value="Penilaian Harian">Penilaian Harian</option>
                            <option {{ old('jenis_ujian') == 'UTS' ? 'selected' : '' }} value="UTS">UTS</option>
                            <option {{ old('jenis_ujian') == 'UAS' ? 'selected' : '' }} value="UAS">UAS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nilai" class="form-label">Nilai</label>
                        <input required type="number" class="form-control" name="nilai" id="nilai" value="{{ old('nilai') }}" placeholder="">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function inputClass(){
            getSiswa();
            getMapel();
        }

        function getSiswa() {
            var kelasId = document.getElementById('kelas_id').value;
            var pengajarId = document.getElementById('pengajar_id').value;
            var tahunajarId = document.getElementById('tahun_ajaran_id').value;
            var siswaSelect = document.getElementById('siswa_id');

            siswaSelect.innerHTML = '<option value="" disabled selected>--- Pilih Nama Siswa ---</option>';

            @foreach ($siswa as $siswa)
                if ({{ $siswa->kelas_id }} == kelasId) {
                    var option = document.createElement('option');
                    option.value = '{{ $siswa->id }}';
                    option.text = '{{ $siswa->nama_siswa }}';
                    siswaSelect.appendChild(option);
                }
            @endforeach
        }

        function getMapel() {
            var kelasId = document.getElementById('kelas_id').value;
            var pengajarId = document.getElementById('pengajar_id').value;
            var tahunajarId = document.getElementById('tahun_ajaran_id').value;
            var mapelSelect = document.getElementById('mata_pelajaran_id');

            mapelSelect.innerHTML = '<option value="" disabled selected>--- Pilih Mata Pelajaran ---</option>';

            fetch(`{{ route('fetchMapelUmum', ['kelasId' => ':kelasId', 'tahunajarId' => ':tahunajarId', 'pengajarId' => ':pengajarId']) }}`.replace(':kelasId', kelasId).replace(':tahunajarId', tahunajarId).replace(':pengajarId', pengajarId))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP error ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate select options with fetched data
                    data.forEach(mapels => {
                        var option = document.createElement('option');
                        option.value = mapels.id;
                        option.text = mapels.nama_mata_pelajaran;
                        mapelSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }
    </script>
@endpush