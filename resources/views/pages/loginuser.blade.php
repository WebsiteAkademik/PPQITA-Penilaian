@extends('layouts.base')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('title')
    Login
@endsection

@section('content')
    <div class="parent-form" style="margin:20px">
        <main class="form-signin m-auto">
            <form action="" method="POST">
                @csrf
                <h1>LOGIN PENDAFTAR</h1>
                @if (session()->has('loginError'))
                    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                        {{ session('loginError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="form-floating">
                    <input type="username" name="email" class="form-control" id="floatingInput"
                        placeholder="isikan username pendaftaran anda">
                    <label for="floatingInput">USERID</label>
                </div>
                <div class="form-floating mt-2">
                    <input type="password" name="password" class="form-control" id="floatingPassword"
                        placeholder="isikan password pendaftaran anda">
                    <label for="floatingPassword">PASSWORD</label>
                </div>

                <div class="checkbox mb-4 mt-2">
                    <label>
                        <input type="checkbox" name="rememberme" value="rememberme"> Remember me
                    </label>
                </div>
                <button class="w-100 btn btn-lg mb-3 text-white" style="background-color: var(--primary-color);"
                    type="submit">Login</button>

                <h4><a href="{{ route('daftar-online') }}">Daftar Sekarang</a></h4>    
            </form>
        </main>
    </div>
@endsection
