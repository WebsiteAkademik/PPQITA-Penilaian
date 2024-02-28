<!DOCTYPE html>
<html lang="en" id="home">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="title" content="PPQITA">
    <meta name="description" content="Website Akademik PPQITA">
    <title>@yield('title') - PPQITA</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <link rel="shortcut icon" href="{{ asset('assets/logo_ppqita.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="shortcut icon" href="{{ asset('assets/galeri/logo_ppqita.png') }}" type="image/x-icon" />

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
                        <img src="{{ asset('assets/galeri/logo_ppqita.png') }}" alt="logo" width="100">
                    </a>    
                </div>
                <div class="col-9" style="padding-top: 30px; padding-left: 30px">
                    <h2>PPQIT Al Mahir</h2>
                </div>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    @yield('content')

    {{-- Footer --}}
    <footer class="py-1 fixed-bottom" style="background-color: #023b5c">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="row">
                        <div class="col-12">
                            <a class="navbar-brand" href="/">
                                <img src="{{ asset('assets/galeri/logo_ppqita_kotak.png') }}" alt="logo" width="25%" />
                            </a>
                        </div>
                    </div>
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
