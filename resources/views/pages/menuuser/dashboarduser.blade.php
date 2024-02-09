@extends('layouts.adminuser')

@section('title')
    Dashboard USER
@endsection

@push('style')
<style>
    .table tr td {
        text-align: left;
    }
</style>
@endpush

@section('content')


    
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <center><h2 class="card-title fw-semibold mb-4">SELAMAT ANDA TELAH BERHASIL MELAKUKAN PENDAFTARAN
                        PENERIMAAN PESERTA DIDIK BARU <br>PPQIT AL MAHIR Surakarta<br>TAHUN AJARAN 2024 / 2025
                    </h2></center>
                    <h3 class="card-title fw-semibold mb-4">Ketentuan Yang Dilakukan Setelah Melaksanakan Pendaftaran Adalah Sebagai Berikut :</h3>
                    
                        <ol  type="1">
                            <li>
                               <p><strong> Download formulir pendaftaran dan Surat keputusan PPDB </strong>   </p> 
                            </li>
                            <li>
                                <p><strong>Bergabung group Whatsapp PPDB PPQITA 2024/2025 </strong></p>
                            </li>        
                            <li>
                                <p><strong>Melakukan regristrasi sebesar Rp. 300.000, 00 ( Satu Juta rupiah ) untuk pembayaran Seragam. Jadwal Daftar Ulang dapat diumumkan setelah pengumuman hasil PPDB
                                Biaya pendaftaran bisa dilakukan dengan cara transfer pembayaran melalui Bank BSI No rekening xxxxx / Bank BRI No rekening xxx atasnama Yayasan Al Mahir atau datang langsung ke Pondok PPQITA Colomadu. 
                                </strong></p>
                            </li>
                            <li style="">
                                <p><strong> berkas ke PPQITA : </strong>
                                <ul style="list-style-type:circle; padding-left:30px">
                                    <li>Fotocopy Kartu Keluarga</li>
                                    <li>Fotocopy Akta Kelahiran</li>
                                    <li>Fotocopy NISN</li>
                                    <li>Fotocopy PIP/KPS/PKH (Bagi yang memiliki)</li>
                                    <li>Foto Hitam putih ukuran 3X4</li>
                                
                                </ul></p>
                            </li>

                        </ol>
                    <b class="fw-semibold mb-4">Konfirmasi Pembayaran Ke : LINK (<a href="https://wa.me/+6281239616477">Share on WhatsApp</a>)</b>

                    <div class="row mt-6">
                        <div class="col-4 col-lg-5">
                            <a href="{{ route('cetak_pdf', $pendaftars->first()->no_nisn) }}" target="_blank" class="btn btn-success">Download</a>
                        </div>
                        <div class="col-4 col-lg-5">
                            @if($pendaftars->first()->status == "DITOLAK")
                                <h4 style="font-weight: bold; font-size: 24px">Status : TIDAK DITERIMA</h4>
                            @else 
                                <h4 style="font-weight: bold; font-size: 24px">Status : {{ $pendaftars->first()->status }}</h4>
                            @endif
                        </div>
                    </div>

                    <table border='0' class="table">
                        <tbody>
                            <tr>
                                <th style="width:220px">No Pendaftar</th>
                                <td style="width: 10px">:</td>
                                <td>{{ $pendaftars->first()->no_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <th>No NISN</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->no_nisn }}</td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->nama_calon_siswa }}</td>
                            </tr>
                            <tr>
                                <th>Tempat dan Tanggal Lahir</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->tempat_lahir }}, {{ $pendaftars->first()->tanggal_lahir }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Kartu Keluarga</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->no_kartu_keluarga }}</td>
                            </tr>
                            <tr>
                                <th>Tinggi Badan</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->tinggi_badan }} cm</td>
                            </tr>
                            <tr>
                                <th>Berat Badan</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->berat_badan }} kg</td>
                            </tr>
                            <tr>
                                <th>Penyakit Kronis</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->penyakit_kronis }}</td>
                            </tr>
                            <tr>
                                <th>Sekolah Asal</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->asal_sekolah }}</td>
                            </tr>
                            <tr>
                                <th>Nama Ayah</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->nama_ayah ? $pendaftars->first()->nama_ayah : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan Ayah</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->pekerjaan_ayah ?$pendaftars->first()->pekerjaan_ayah : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama Ibu</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->nama_ibu ? $pendaftars->first()->nama_ibu : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan Ibu</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->pekerjaan_ibu ?$pendaftars->first()->pekerjaan_ibu : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Penghasilan Perbulan</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->penghasilan_per_bulan }}</td>
                            </tr>
                            <tr>
                                <th>Nomor WhatsApp Ortu</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->no_telepon_ortu }}</td>
                            </tr>
                            <tr>
                                <th>Nomor WhatsApp Anak</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->no_wa_anak }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->alamat_rumah }}, {{ $pendaftars->first()->dukuh }}, {{ $pendaftars->first()->kelurahan }}, {{ $pendaftars->first()->kabupaten }}, {{ $pendaftars->first()->kecamatan }}</td>
                            </tr>
                            <tr>
                                <th>Kode Pos</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->kodepos }}</td>
                            </tr>
                            <tr>
                                <th>Asal Sekolah</th>
                                <td>:</td>
                                <td>{{ $pendaftars->first()->asal_sekolah }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
