@extends('layouts.adminuser')

@section('title', 'Jadwal Test Pendaftar Siswa')

@section('content')
    <div class="container">
        <h1>Jadwal Test</h1>
        <br>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Calon Siswa</th>
                    <th scope="col">Tanggal Test</th>
                    <th scope="col">Jam Test</th>
                    <th scope="col">Jenis Test</th>
                    <th scope="col">PIC</th>
                    <th scope="col">No. Telepon/WhatsApp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalTests as $jadwalTest)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $jadwalTest->pendaftaran()->nama_calon_siswa }}</td>
                        <td>{{ $jadwalTest->tanggal_test }}</td>
                        <td>{{ $jadwalTest->jam_test }}</td>
                        <td>{{ $jadwalTest->jenis_test }}</td>
                        <td>{{ $jadwalTest->pic_test }}</td>
                        <td>{{ $jadwalTest->pendaftaran()->no_wa_anak }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
@endsection
