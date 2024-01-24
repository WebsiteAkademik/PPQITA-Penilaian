@extends('layouts.base')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('title')
    Login
@endsection

@section('content')
    <div class="parent-form">
        <main class="form-signin m-auto">
            <form action="{{ route('postlogin') }}" method="POST">
                @csrf
                <img class="mb-4" src="{{ asset('assets/galeri/logo-transparent.png') }}" alt="" style="width: 25%">
                <h1>LOGIN ADMIN</h1>
                @if (session()->has('loginError'))
                    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                        {{ session('loginError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="form-floating">
                    <input type="email" name="email" class="form-control" id="floatingInput"
                        placeholder="name@example.com">
                    <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating mt-2">
                    <input type="password" name="password" class="form-control" id="floatingPassword"
                        placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>

                <div class="checkbox mb-4 mt-2">
                    <label>
                        <input type="checkbox" name="rememberme" value="rememberme"> Remember me
                    </label>
                </div>
                <button class="w-100 btn btn-lg mb-3 text-white" style="background-color: var(--primary-color);"
                    type="submit">Login</button>
            </form>
        </main>
    </div>
@endsection
