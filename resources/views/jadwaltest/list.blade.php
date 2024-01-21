@extends('layouts.admin')

@section('title', 'Daftar Jadwal Test Pendaftar')

@section('content')
    <div class="container">
        <h1>Daftar Jadwal Test Pendaftar</h1>
        <br>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">No Pendaftaran</th>
                    <th scope="col">Tanggal Test</th>
                    <th scope="col">Jam Test</th>
                    <th scope="col">Metode Test</th>
                    <th scope="col">Informasi Tambahan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalTests as $jadwalTest)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $jadwalTest->no_pendaftaran }}</td>
                        <td>{{ $jadwalTest->tanggal_test }}</td>
                        <td>{{ $jadwalTest->jam_test }}</td>
                        <td>{{ $jadwalTest->metode_test }}</td>
                        <td>{{ $jadwalTest->info_test }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('jadwaltest.form') }}" class="btn btn-primary mb-3">Kembali ke Input Jadwal Test</a>
    </div>
@endsection
