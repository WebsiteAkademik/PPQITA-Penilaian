@extends('layouts.base')

@section('title')
    Beranda
@endsection

@push('script')
    <script>
        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'reload-captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha)
                }
            });
        });
        const myModal = new bootstrap.Modal('#modalShow1', {
            keyboard: false
        })
        const modalToggle = document.getElementById('modalShow1');
        myModal.show(modalToggle);
    </script>
@endpush

@section('content')
    <div class="modal" tabindex="-1" id="modalShow">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <img src="{{ asset('assets/poster/penerimaan-2024-2025.jpeg') }}" alt="poster penerimaan"
                                style="width: 100%;margin:10px">
                        </div>
                        <div class="col-md-6 col-12">
                            <h6 class="text-muted mt-3 mt-md-0" style="font-size: 1.2rem;">PENERIMAAN PESERTA DIDIK BARU<br>2024/2025</h6>
                            <h4 style="color: var(--primary-color);font-weight:700;font-size:2.6rem;">BEBAS UANG GEDUNG</h4>
                            <a href="https://wa.me/+6281250004905?text=Assalamu'alaikum%20Saya%20ingin%20bertanya%20tentang%20PMB%20PoltekBPI" target="_blank" class="btn text-white my-4 px-4 py-2"
                                style="background-color: var(--primary-color);font-size:1.1rem;"><i class="fa-solid fa-phone-volume me-1"></i>Tanya Admin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumbotron -->
    <section class="jumbotron" style="background: url(../assets/galeri/bengkel1.webp) no-repeat;background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 pt-5">
                    <div class="p-4 w-75 text-uppercase text-white" style="background-color: #B90000;">
                        <div>
                        <h2 class="fs-2" style="opacity:2;  font-weight: 700;">PENERIMAAN PESERTA DIDIK BARU</h2>                            
                        </div>

                    </div>
                    <div class="p-4" style="background-color: #FF9090;font-size: 18px;opacity: 0.9;">
                        <p style="color:#fff">SMK PANCASILA 1 WONOGIRI <br/>TAHUN PELAJARAN 2024/2025</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    {{-- Gelombang Pendaftaran --}}
    <section class="gelombang-pendaftaran" id="gelombang-pendaftaran">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h2>INFORMASI UMUM</h2>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 col-12">
                    <div class="card position-relative">
                        <img src="{{ asset('assets/galeri/smk-praktek1.jpg') }}" alt="image gelombang"
                            style="width:100%;height: 25rem;object-position:top center;object-fit: cover;">
                        <div class="card-body bg-white" style="position: absolute;bottom: -10px;right:2rem;left:2rem;bo">
                            <h4>PROGRAM KEAHLIAN</h4>
                            <ul>
                                <li>Teknik Pemesinan (TP)</li>
                                <li>Teknik Pengelasan (TLAS)</li>
                                <li>Teknik Kendaraan Ringan 0tomotif (TKRO)</li>
                                <li>Teknik dan Bisnis Sepeda Motor (TBSM)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="card position-relative">
                        <img src="{{ asset('assets/galeri/smk-praktek2.jpg') }}" alt="image gelombang"
                            style="width:100%;height: 25rem;object-position:top center;object-fit: cover;">
                        <div class="card-body bg-white" style="position: absolute;bottom: -10px;right:2rem;left:2rem;bo">
                            <h4>SYARAT</h4>
                            <ul>
                                <li>Mengisi formulir pendaftaran</li>
                                <li>Mengumpulkan foto copy Kartu Keluarga 1 lembar</li>
                                <li>Mengumpulkan foto copy Akta Kelahiran 1 lembar</li>
                                <li>Mengumpulkan foto copy NISN 1 lembar</li>
                                <li>Mengumpulkan foto copy kartu PIP/ KPS/ PKH 1 lembar bagi yang memiliki</li>
                                <li>Mengumpulkan foto copy sertifikat lomba bagi yang memiliki</li>
                                <li>Mengumpulkan foto 3×4 hitam putih sebanyak 4 lembar</li>
                                
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Biaya Pendidikan --}}
    <section class="biaya-pendidikan" id="biaya-pendidikan">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <center style="margin:30px 10px 30px 10px">
                        <img src="assets/galeri/smk-praktek3.jpg" alt="" 
                        width="75%" style="box-shadow:5px 5px 10px;border-radius:10px 10px 10px 10px ">
                    </center>    
                </div>
                <div class="col-md-12 col-12">
                    <h2><span style="color: var(--primary-color)">Waktu dan  </span> Cara Pendaftaran</h2>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <table border="1" cellpadding="15" cellspacing="0" class="tablte table-striped" style="width: 100%">
                        <thead style="background-color: var(--primary-color);color:#fff;">
                            <tr>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Gelombang 1 ; 1 Desember 2023 - 31 Januari 2024 (Potongan Uang Gedung <b>Rp.600.000,-</b> </td>
                            </tr>
                            <tr>
                                <td>Gelombang 2 :  1 Februari 2024 - 31 April 2024 (Potongan Uang Gedung <b>Rp.300.000,-</b> </td>
                            </tr>
                            <tr>
                                <td>Gelombang 3 : 1 Mei 2024 - 15 Juli 2024</td>
                            </tr>
                        </tbody>
                        <thead style="background-color: var(--primary-color);color:#fff;">
                            <tr>
                                <th>Tata Cara</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <ul>
                                        <li>
                                        Datang langsung ke SMK Pancaslla 1 Wonogiri dengan membawa persyaratan di atas, atau
                                        </li>
                                        <li>
                                        Mendaftar secara ONLINE ke alamat http://ppdb.smkpancasila1wng.sch.id
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </section>
    
{{-- Pendaftaran --}}
    <section class="p-5" id="formpendaftaran" style="background-color: var(--primary-color);">
        <div class="container">
            <div class="row text-left justify-content-center text-white">
                <div class="col-12">
                    <div class="text-center">
                        <h2 class="mb-3">Form Pendaftaran SISWA BARU SMK PANCASILA 1 WONOGIRI 
                        </h2>
                        <a href="{{ route('daftar-online') }}" class="btn btn-light" style="padding:20px; margin-bottom:10px; border-radius: 30px 30px 30px 30px; box-shadow: 5px 5px 10px;hover{background-color:yellow} ; margin:10px"><strong>&#10551;&nbsp;&nbsp;DAFTAR </strong></a>
                        <a href="{{ route('dashboarduser') }}" class="btn btn-light" style="padding:20px;  margin:5px; box-shadow: 5px 5px 10px;hover{background-color:yellow}; border: 1px solid white;border-radius: 30px 30px 30px 30px; margin:10px; "><strong>&#10551;&nbsp;&nbsp;LOGIN</strong></a>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- Jalur Pendaftaran --}}
    <section class="jalur-pendaftaran" id="jalur-pendaftaran">
        <div class="container">
            <div class="row text-center">
                <h2><span style="color: var(--primary-color)"></span></h2>
            </div>
            <div class="row mt-4">
                <div class="col-12 jalur-tab">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="jalur-umum-tab" data-bs-toggle="tab"
                                data-bs-target="#jalur-umum" type="button" role="tab" aria-controls="jalur-umum"
                                aria-selected="true">KETENTUAN PPDB</button>
                            <button class="nav-link" id="jalur-prestasi-tab" data-bs-toggle="tab"
                                data-bs-target="#jalur-prestasi" type="button" role="tab"
                                aria-controls="jalur-prestasi" aria-selected="true">JIKA DITERIMA</button>
                            
                        </div>
                    </nav>
                    <div class="tab-content py-4 px-4" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="jalur-umum" role="tabpanel"
                            aria-labelledby="jalur-umum" tabindex="0">
                            <h6>Ketentuan PPDB </h6>
                            <ol>
                                <li>Bagi calon peserta didik yang sudah melakukan daftar ulang, akan dikembalikan 100% jika diterima di SMK Negeri 2 Wonogiri</li>
                                <li>Bagi calon peserta didik yang mendaftar di Kompetensi Keahlian Teknik Pengelasan akan mendapatkan keringanan biaya uang gedung 50%</li>
                                <li>Bagi calon peserta didik yang kembar, untuk uang gedung hanya di bebankan ke satu calon peserta didik</li>
                                <li>Bagi calon peserta didik yang memiliki saudara kandung baik di kelas XI maupun di kelasXII, bebas uang gedung yang dibuktikan dengan Kartu Keluarga.</li>
                            </ol>

                           
                        </div>
                        <div class="tab-pane fade show" id="jalur-prestasi" role="tabpanel"
                            aria-labelledby="jalur-prestasi" tabindex="0">
                            <h6>BAGI YANG DITERIMA HARAP MEMPERHATIKAN HAL-HAL SEBAGAI BERIKUT</h6>
                            <ol>
                                <li>Biaya daftar ulang sebesar Rp. 1.000.000,00 (Satu Juta Seratus Ribu Rupiah) dengan rincian untuk pembayaran Seragam
                                <ol>

                                    <li>
                                        Seragam ( OSIS 1 Stel, Batik YPP 1 baju, Pramuka 1 stel, Olahraga 1 stel, Wearpack 1 pcs, Topi 1 pcs, Atrtbut 1 paket., Dasi 1 pcs) <b>Rp 1000.000,00</b>
                                    </li>
                                    <li>
                                    Daftar Ulang pendaftaran s/d 15 Juli 2024
                                    </li>
                                    <li>
                                    Bisa dibayarkan setelah pengumuman hasil PPDB
                                    </li>
                                </ol>
                                </li>
                                
                                <li>Pembayaran ke bagian TU:
                                    <ol>
                                        <li>
                                            Senin – Sabtu pukul 08.00 – 13.00 WIB kecuali Jum’at pukul 08.00 – 11.00 WIB. atau,
                                        </li>
                                        <li>
                                            transfer melalui <b>Bank BNI</b> Nomor Rekening 0628447093; <b>Bank BRI</b> Nomor Rekening 0158-01-025986-50-9; atas nama SMK Pancasila 1 Wonogiri
                                        </li>
                                    </ol>                                    
                                </li>
                                <li>UangBagi yang tidak melakukan daftar ulang sampai tanggal 4 Jull 2022 dianggap mengundurkan diri</li>
                                <li>Dana pembangunan sekolah akan dirapatkan terlebih dahulu setelah di terima di SMK Pancasila 1 Wonogiri</li>
                            </ol>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @endsection
