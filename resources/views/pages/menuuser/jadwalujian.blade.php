@extends('layouts.adminuser')

@section('title', 'Jadwal Ujian Siswa')

@section('content')
    <div class="container">
        <h1>Jadwal Ujian</h1>
        <br>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Tanggal Ujian</th>
                    <th scope="col">Jam Ujian</th>
                    <th scope="col">Mata Pelajaran</th>
                    <th scope="col">Jenis Ujian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalujian as $jadwalujian)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $jadwalujian->tanggal_ujian }}</td>
                        <td>{{ $jadwalujian->jam_ujian }}</td>
                        <td>{{ $jadwalujian->mataPelajaran()->nama_mata_pelajaran }}</td>
                        <td>{{ $jadwalujian->jenis_ujian }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
@endsection
