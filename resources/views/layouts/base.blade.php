<!DOCTYPE html>
<html lang="en" id="home">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="title" content="PPDB SKAPANSA">
    <meta name="description" content="Penerimaan Siswa Baru SMK Pancasila 1 Wonogiri">
    <title>@yield('title') - SMK PANCASILA 1 WONOGIRI</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <link rel="shortcut icon" href="{{ asset('assets/logo-smk-pancasila-wonogiri.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="shortcut icon" href="{{ asset('assets/galeri/logo-smk-pancasila-wonogiri.png') }}" type="image/x-icon" />

    {{-- FontAwesome Icon --}}
    <script src="https://kit.fontawesome.com/b30b4ab1e3.js" crossorigin="anonymous"></script>

    @stack('style')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light navbar-expand-lg bg-white sticky-top py-3">
        <div class="container">
            
            <div class="row">
                <div class="col-3">
                    <a class="navbar-brand" href="/">
                        <img src="{{ asset('assets/galeri/logo-smk-pancasila-wonogiri.png') }}" alt="logo" width="100" />
        
                    </a>    
                </div>
                <div class="col-7">
                    <h2>SMK Pancasila 1 Wonogiri</h2>
                     <p style="font-size:14px;">Jln. Jend. Sudirman No. 106, Sukorejo,Giritirto, Kec. Wonogiri, Kab. Wonogiri, Jawa Tengah, 57611</p>
                </div>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}"
                            href="{{ route('home') }}" target="_blank">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('daftar-online') ? 'active' : '' }}"
                            href="{{ route('daftar-online') }}">Daftar Online</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('kontak') ? 'active' : '' }}"
                            href="{{ route('kontak') }}">Kontak</a>
                    </li>
                    
                    <li class="nav-item ps-3">
                        <a class="btn text-white px-4 py-2 {{ Request::is('login-user') ? 'active' : '' }}"
                            style="background-color: #B90000; border-radius: 20px;"
                            href="{{ route('dashboarduser') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    {{-- Footer --}}
    <footer class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12">
                <div class="row">
                    <div class="col-2">
                        <a class="navbar-brand" href="/">
                            <img src="{{ asset('assets/galeri/logo-smk-pancasila-wonogiri.png') }}" alt="logo" width="50" />
                        </a>    
                    </div>
                    <div class="col-8">
                        <h2>SMK Pancasila 1 Wonogiri</h2>
                    </div>
                </div>
            <p class="my-3">Lulusan Berkualitas, Kompeten, Kompetitif dan Nasionalis.</p>
                    <div class="social-media mt-5">
                        <a href="https://www.tiktok.com/@skapansawng.official?lang=en" class="social-media-item text-white text-decoration-none" target="_blank">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                        <a href="https://www.youtube.com/channel/UCLqEikfCgt5h7EWpKmDZsbg" class="social-media-item text-white text-decoration-none" target="_blank">
                            <i class="fa-brands fa-youtube">
                                
                            </i>
                        </a>
                        <a href="https://www.instagram.com/smkpancasila1wonogiri/" class="social-media-item text-white text-decoration-none" target="_blank">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-2 col-12 mt-md-0 mt-5">
                    <h5 style="color: #FF6600;">Kunjungi</h5>
                    <ul class="footer-profile-list mt-3">
                        <li class="footer-profile-list-item">
                            <a href="https://smkpancasila1wng.sch.id" target ="_blank">
                                Website utama
                            </a>
                        </li>
                        <li class="footer-profile-list-item">
                            <a href="https://smkpancasila1wng.sch.id/profil/" target ="_blank">
                                Profil Sekolah
                            </a>
                        </li>
                        <li class="footer-profile-list-item">
                            <a href="https://smkpancasila1wng.sch.id/profil-guru/" target ="_blank">
                                Profil Guru
                            </a>
                        </li>
                        <li class="footer-profile-list-item">
                            <a href="https://psb.smkpancasila1wng.sch.id/kontak/" target="_blank">
                                Kontak Kami
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2 col-12">
                    <h5 style="color: #FF6600;">Fasilitas</h5>
                    <ul class="footer-profile-list mt-3">
                        <li class="footer-profile-list-item">
                            <a href="#">
                                Perpustakaan
                            </a>
                        </li>
                        <li class="footer-profile-list-item">
                            <a href="#">
                                Ruang Kelas
                            </a>
                        </li>
                        <li class="footer-profile-list-item">
                            <a href="#">
                                Student Lounge
                            </a>
                        </li>
                        <li class="footer-profile-list-item">
                            <a href="#">
                                Laboratorium Komputer
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-12">
                    <h5 style="color: #FF6600;">Hubungi Kami</h5>
                    <ul class="footer-profile-list mt-3">
                        <li class="footer-profile-list-item">
                            Jln. Jend. Sudirman No. 106, Sukorejo, Giritirto, Kec. Wonogiri, Kab. Wonogiri, Jawa Tengah, 57611

                        </li>
                        <li class="footer-profile-list-item">
                            &#x1F4E7; &nbsp; smkps1wng@gmail.com
                        </li>
                        <li class="footer-profile-list-item">
                             &#128222; &nbsp; (0273) 321028
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    @stack('script')
    @include('sweetalert::alert')
</body>

</html>
