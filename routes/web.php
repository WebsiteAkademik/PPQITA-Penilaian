<?php

use App\Models\Pendaftar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\JadwalTestController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cetak_pdf/{no_nisn}', [HomeController::class, 'cetak_pdf'])->name('cetak_pdf');
Route::get('/cetak_laporan/', [HomeController::class, 'cetak_laporan'])->name('cetak_laporan');
Route::get('/export-pendaftar',[HomeController::class, 'exportPendaftar'])->name('export-pendaftar');


Route::get('/daftar-online', [HomeController::class, 'daftarOnline'])->name('daftar-online');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
//Route::post('/logins', [AuthController::class, 'loginUser'])->name('login');
Route::get('/reload-captcha', [HomeController::class, 'reloadCaptcha'])->name('reload-captcha');
//insert tabel daftar
Route::post('/daftar', [HomeController::class, 'daftar'])->name('daftar');

// Login 
Route::get('/login', function (){
    return view('pages.user.login');
})->name('login-user');

Route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');

// Route::middleware('guest')->group(function () {
//     Route::get('/loginuser', [AuthController::class, 'loginViewUser'])->name('login-user');
//     Route::get('/admin-login', [AuthController::class, 'loginView'])->name('loginView');
//     Route::post('/admin-login', [AuthController::class, 'login'])->name('login');
//     Route::post('/loginuser', [AuthController::class, 'loginUser'])->name('loginuser');

// });


Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        $pendaftarCount = Pendaftar::count();
        $pendaftars = Pendaftar::latest()->limit(5)->get();

        $data = [
            'pendaftars' => $pendaftars,
            'pendaftarCount' => $pendaftarCount
        ];
        return view('pages.admin.dashboard', $data);
    })->name('dashboard');

    // menu user
    
    // Pendaftar
    Route::get('/pendaftar', [PendaftaranController::class, 'index'])->name('pendaftar.index');
    Route::get('/pendaftar/{slug}', [PendaftaranController::class, 'detail'])->name('pendaftar.detail');
    Route::put('/pendaftar/{id}', [PendaftaranController::class, 'update'])->name('pendaftar.update');
    Route::delete('/pendaftar/{id}/delete', [PendaftaranController::class, 'destroy'])->name('pendaftar.destroy');

    //Laporan Rekap
    Route::get('/rekap', [PendaftaranController::class, 'rekap'])->name('rekap.index');
});

Route::middleware('auth')->prefix('dashboarduser')->group(function () {
    Route::get('/', function () {
        $pendaftarCount = Pendaftar::count();

        //$pendaftars = Pendaftar::latest()->limit(5)->get();
        //auth()->user()->name
        $pendaftars = DB::table('pendaftars')
                   ->where('no_nisn','=',auth()->user()->name )
                   ->get();
        $data = [
            'pendaftars' => $pendaftars,
            'pendaftarCount' => $pendaftarCount
        ];
        return view('pages.menuuser.dashboarduser', $data);
    })->name('dashboarduser');

    // route untuk form
    Route::get('/jadwaltest/form', [JadwalTestController::class, 'showform'])->name('jadwaltest.form');
    Route::post('/jadwaltest.store', [JadwalTestController::class, 'store'])->name(
        'jadwaltest.store');
    Route::get('/jadwaltest/list', [JadwalTestController::class, 'list'])->name('jadwaltest.list');

    // menu user
    Route::get('/pendaftar', [PendaftaranController::class, 'indexuser'])->name('pendaftar.indexuser');
    // Pendaftar
    Route::get('/pendaftar/{no_nisn}', [PendaftaranController::class, 'detailbynisn'])->name('pendaftar.detailuser');
    
});
