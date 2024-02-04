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
                    <th scope="col">Nama Calon Siswa</th>
                    <th scope="col">Tanggal Test</th>
                    <th scope="col">Jam Test</th>
                    <th scope="col">Jenis Test</th>
                    <th scope="col">PIC</th>
                </tr>
            </thead>

            {{-- button yang mengarah ke form edit jadwal test --}}
            <tbody>
                @foreach ($jadwalTests as $jadwalTest)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $jadwalTest->nama_calon_siswa }}</td>
                        <td>{{ $jadwalTest->tanggal_test }}</td>
                        <td>{{ $jadwalTest->jam_test }}</td>
                        <td>{{ $jadwalTest->jenis_test }}</td>
                        <td>{{ $jadwalTest->pic_test }}</td>
                        <td>
                            <a href="{{ route('jadwaltest.edittest', $jadwalTest->id) }}" class="btn btn-warning">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        {{-- button yang mengarah ke form input jadwal test --}}
        <a href="{{ route('jadwaltest.form') }}" class="btn btn-primary mb-3">Input Jadwal Test</a> 
    </div>
@endsection
