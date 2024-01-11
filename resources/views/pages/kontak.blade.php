@extends('layouts.base')

@section('title')
    Kontak
@endsection

@push('script')
@endpush

@section('content')
    <!-- Jumbotron -->
    <section class="jumbotron" style="background: url(../assets/galeri/bengkel3.webp) no-repeat;background-size:cover;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12 pt-5">
                    <div class="p-4 text-uppercase w-75 m-auto text-center text-white" style="background-color: #FF914D">
                        <h2 class="fs-2">Follow Terus Kami</h2>
                    </div>
                    <div class="p-4 text-white text-center" style="background-color: var(--primary-color);font-size: 18px;">
                        <p>Sosial Media Dan Alamat SMK Pancasila 1 Wonogiri</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Galeri --}}
    <section>
        <div class="container" ">
            <div class="row">
                <div class="col-md-8 col-12" style="border-radius: 1rem;">
                    <iframe
                        src="https://maps.google.com/maps?q=SMK%20Pancasila%201%20Wonogiri&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                        style="border:0;height:100%;width:100%;border-radius:1rem;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="col-md-4 col-12 p-5 text-white"
                    style="background-color: var(--primary-color);border-radius: 1rem;">
                    <h2 class="mt-5">Hubungi Kami</h2>
                    <ul class="list-group mb-5 gap-2">
                        <li class="list-group-item bg-transparent border-0 text-white gap-2 d-flex align-items-center">
                            <i class="fas fa-map-marker-alt fs-4 ms-1 me-2"></i>
                            <span>Jl. Jend. Sudirman No.106, Sukorejo, Giritirto, Kec. Wonogiri, Kabupaten Wonogiri, Jawa Tengah 57611</span>
                        </li>
                        <li class="list-group-item bg-transparent border-0 text-white gap-2 d-flex align-items-center">
                            <i class="fab fa-whatsapp fs-4 me-2"></i>
                            <span>
                            <a href="https://wa.me/?text=Assalamu'alaikum%20Saya%20ingin%20bertanya%20tentang%20PMB%20SMKPancasila"
                                target="_blank" style="text-decoration: none;color:white">
                                Nomor Whatsapp
                            </a>
                            </span>
                        </li>
                        <li class="list-group-item bg-transparent border-0 text-white gap-2 d-flex align-items-center">
                            <i class="fas fa-phone-alt fs-4 me-2"></i>
                            <span>(0273) 321028</span>
                        </li>
                        <li class="list-group-item bg-transparent border-0 text-white gap-2 d-flex align-items-center">
                            <i class="fas fa-envelope fs-4 me-2"></i>
                            <span>smkps1wng@gmail.com</span>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-between gap-2">
                        <div style="background-color:white;width:3.5rem;height:3.5rem;border-radius:20rem;">
                            <a href="https://wa.me/+6281250004905?text=Assalamu'alaikum%20Saya%20ingin%20bertanya%20tentang%20PMB%20PoltekBPI"
                                target="_blank"
                                style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;color:var(--dark-color);text-decoration:none;font-size:1.5rem">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                        <div style="background-color:white;width:3.5rem;height:3.5rem;border-radius:20rem;">
                            <a href="https://www.tiktok.com/@skapansawng.official?lang=en" target="_blank"
                                style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;color:var(--dark-color);text-decoration:none;font-size:1.5rem">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        </div>
                        <div style="background-color:white;width:3.5rem;height:3.5rem;border-radius:20rem;">
                            <a href="https://www.youtube.com/channel/UCLqEikfCgt5h7EWpKmDZsbg" target="_blank"
                                style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;color:var(--dark-color);text-decoration:none;font-size:1.5rem">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                        <div style="background-color:white;width:3.5rem;height:3.5rem;border-radius:20rem;">
                            <a href="https://www.instagram.com/smkpancasila1wonogiri/" target="_blank"
                                style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;color:var(--dark-color);text-decoration:none;font-size:1.5rem">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
