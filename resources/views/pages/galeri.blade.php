@extends('layouts.base')

@section('title')
    Galeri
@endsection

@push('script')
@endpush

@section('content')
    <!-- Jumbotron -->
    <section class="jumbotron" style="background: url(../assets/jumbotron-3.jpg) no-repeat;background-size:cover;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12 pt-5">
                    <div class="p-4 text-uppercase w-75 m-auto text-center text-white" style="background-color: #FF914D">
                        <h2 class="fs-2">Galeri</h2>
                    </div>
                    <div class="p-4 text-white text-center" style="background-color: var(--primary-color);font-size: 18px;">
                        <p>Aktivitas - Aktivitas Di Kampus Poltek BPI</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Galeri --}}
    <section class="galeri m-auto">
        <div class="container">
            <div class="row no-gutter text-left justify-content-center text-white">
                <div class="col-md-4 col-12 mb-5 ml-5">
                    <img src="{{ asset('assets/galeri/gallery1.JPG') }}" style="width: 100%"
                        alt="galeri image poltek bpi">
                </div>
                <div class="col-md-4 col-12 mb-5 ml-5">
                    <img src="{{ asset('assets/galeri/gallery2.JPG') }}" style="width: 100%"
                        alt="galeri image poltek bpi">
                </div>
                <div class="col-md-4 col-12 mb-5 ml-5">
                    <img src="{{ asset('assets/galeri/gallery3.JPG') }}" style="width: 100%"
                        alt="galeri image poltek bpi">
                </div>
                <div class="col-md-4 col-12 mb-5 ml-5">
                    <img src="{{ asset('assets/galeri/gallery4.JPG') }}" style="width: 100%"
                        alt="galeri image poltek bpi">
                </div>
                <div class="col-md-4 col-12 mb-5 ml-5">
                    <img src="{{ asset('assets/galeri/gallery5.JPG') }}" style="width: 100%"
                        alt="galeri image poltek bpi">
                </div>
                <div class="col-md-4 col-12 mb-5 ml-5">
                    <img src="{{ asset('assets/galeri/gallery6.JPG') }}" style="width: 100%"
                        alt="galeri image poltek bpi">
                </div>
            </div>
        </div>
    </section>
@endsection
