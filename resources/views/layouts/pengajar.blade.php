<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - PPQITA</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/galeri/logo_ppqita.png') }}" />
    <link rel="stylesheet" href="{{ asset('admin/src/assets/css/styles.min.css') }}" />

    {{-- FontAwesome Icon --}}
    <script src="https://kit.fontawesome.com/b30b4ab1e3.js" crossorigin="anonymous"></script>

    @stack('style')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between mt-2">
                    <a href="{{ route('dashboardpengajar') }}" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/galeri/logo_ppqita.png') }}" width="25%" alt="logo img" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <hr>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ Request::is('/') ? 'active' : '' }}"
                                href="{{ route('dashboardpengajar') }}" aria-expanded="false">
                                <span>
                                    <i class="fa-solid fa-house"></i>
                                </span>
                                <span class="hide-menu">Dashboard Pengajar</span>
                            </a>
                        </li>
                        <hr>
                        <li class="sidebar-item">
                            <a class="sidebar-link @if (Request::is('/pendaftar')) active @endif"
                                href="{{ route('dashboardpengajar') }}" aria-expanded="false">
                                <span>
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </span>
                                <span class="hide-menu">Penilaian Tahfidz</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link @if (Request::is('/rekap')) active @endif"
                                href="{{ route('dashboardpengajar') }}" aria-expanded="false">
                                <span>
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </span>
                                <span class="hide-menu">Penilaian Pelajaran</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link @if (Request::is('/rekap')) active @endif"
                                href="{{ route('dashboardpengajar') }}" aria-expanded="false">
                                <span>
                                    <i class="fa-solid fa-calendar-check"></i>
                                </span>
                                <span class="hide-menu">Absensi Siswa</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link @if (Request::is('/rekap')) active @endif"
                                href="{{ route('dashboardpengajar') }}" aria-expanded="false">
                                <span>
                                    <i class="fa-regular fa-calendar-check"></i>
                                </span>
                                <span class="hide-menu">Absensi Pengajar</span>
                            </a>
                        </li>
                        <li class="sidebar-item d-grid" style="position: absolute;bottom: 20px;right: 0;left: 0;">
                            <button type="button" onclick="logout();"
                                class="btn btn-outline-danger mx-3 mt-2">Logout</button>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header" style="background-color: #35a4e2;">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <div class="d-flex align-items-center">
                                    <p class="text-white fs-4 mt-2" style="font-weight: 500">Hi,
                                        {{ auth()->user()->name }}</p>
                                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ asset('admin/src/assets/images/profile/user-1.jpg') }}"
                                            alt="" width="35" height="35" class="rounded-circle">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                        aria-labelledby="drop2">
                                        <div class="message-body d-grid">
                                            <button type="button" onclick="logout();"
                                                class="btn btn-outline-danger mx-3 mt-2 d-block">Logout</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="container-fluid">
                <!--  Row 1 -->
                @yield('content')
                <div class="py-6 px-6 text-center">
                    <p class="mb-0 fs-4">Copyright &copy; 2024 Made with ❤ By Tim Magang PTIK UNS x <a href="https://toekangdigital.com">Toekang Digital</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/src/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/src/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('admin/src/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('admin/src/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/src/assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('admin/src/assets/js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function logout() {
            $.ajax({
                type: 'post',
                url: "{{ route('logout') }}",
                data: [],
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Logout berhasil",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/"
                        }
                    });
                },
            });
        }
    </script>
    @stack('script')
    @include('sweetalert::alert')
</body>

</html>
