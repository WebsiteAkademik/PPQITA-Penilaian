<?php

use App\Models\Pendaftar;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Admin\PendaftaranOnlineController;
use App\Http\Controllers\JadwalTestController;
use App\Http\Controllers\LoginController;
use App\Models\JadwalTest;
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

Route::get('/daftar-online', [PendaftaranOnlineController::class, 'daftarOnlineGET'])->name('daftar-online');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
//Route::post('/logins', [AuthController::class, 'loginUser'])->name('login');
Route::get('/reload-captcha', [HomeController::class, 'reloadCaptcha'])->name('reload-captcha');
//insert tabel daftar
Route::post('/daftar-online', [PendaftaranOnlineController::class, 'daftarOnlinePOST'])->name('daftar');

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
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//role -> pengajar
Route::middleware('auth', 'cekrole:pengajar')->prefix('dashboardpengajar')->group(function () {
    Route::get('/', function () {
        $pendaftarCount = Pendaftaran::count();
        $pendaftars = Pendaftaran::latest()->limit(5)->get();

        $data = [
            'pendaftars' => $pendaftars,
            'pendaftarCount' => $pendaftarCount
        ];
        return view('pages.admin.dashboardpengajar', $data);
    })->name('dashboardpengajar');
});

//role -> admin
Route::middleware('auth', 'cekrole:admin')->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        $pendaftarbaruCount = Pendaftaran::where('status', 'BARU')->count();
        $pendaftartestCount = Pendaftaran::where('status', 'TEST')->count();
        $diterimaCount = Pendaftaran::where('status', 'DITERIMA')->count();
        $ditolakCount = Pendaftaran::where('status', 'DITOLAK')->count();
        $pendaftars = Pendaftaran::latest()->limit(5)->get();
        $jadwalTests = JadwalTest::all();

        $data = [
            'pendaftars' => $pendaftars,
            'jadwalTests' => $jadwalTests,
            'pendaftarbaruCount' => $pendaftarbaruCount,
            'pendaftartestCount' => $pendaftartestCount,
            'diterimaCount' => $diterimaCount,
            'ditolakCount' => $ditolakCount
        ];
        return view('pages.admin.dashboard', $data);
    })->name('dashboard');

    // menu user
    
    // Pendaftar
    Route::get('/pendaftar-baru', [PendaftaranOnlineController::class, 'index'])->name('pendaftar.index');
    Route::post('/pendaftar-baru', [PendaftaranOnlineController::class, 'indexPOST'])->name('pendaftar.indexUpdateStatusMenunggu');
    Route::get('/pendaftar-test', [PendaftaranOnlineController::class, 'listTest'])->name('pendaftar.listTest');
    Route::post('/pendaftar-test/diterima', [PendaftaranOnlineController::class, 'listTestDiterimaPOST'])->name('pendaftar.updateStatusDiterima');
    Route::post('/pendaftar-test/ditolak', [PendaftaranOnlineController::class, 'listTestDitolakPOST'])->name('pendaftar.updateStatusDitolak');
    Route::get('/pendaftar-diterima', [PendaftaranOnlineController::class, 'listTerima'])->name('pendaftar.listTerima');
    Route::get('/pendaftar-ditolak', [PendaftaranOnlineController::class, 'listTolak'])->name('pendaftar.listTolak');
    Route::get('/pendaftar/{no_nisn}', [PendaftaranOnlineController::class, 'detail'])->name('pendaftar.detail');
    Route::put('/pendaftar/{id}', [PendaftaranOnlineController::class, 'update'])->name('pendaftar.update');
    Route::delete('/pendaftar/{id}/delete', [PendaftaranOnlineController::class, 'destroy'])->name('pendaftar.destroy');
    
    // Jadwal test
    Route::get('/jadwaltest/form', [JadwalTestController::class, 'showform'])->name('jadwaltest.form');
    Route::post('/jadwaltest.store', [JadwalTestController::class, 'store'])->name('jadwaltest.store');
    Route::get('/jadwaltest/list', [JadwalTestController::class, 'list'])->name('jadwaltest.list');
    Route::get('/jadwaltest/edittest/{id}', 'App\Http\Controllers\JadwalTestController@edittest')->name('jadwaltest.edittest');
    Route::put('/jadwaltest/{id}', [JadwalTestController::class, 'update'])->name('jadwaltest.update');
    Route::delete('/jadwaltest/{id}', [JadwalTestController::class, 'delete'])->name('jadwaltest.delete');

    // Laporan Profile
    Route::get('/profile', [PendaftaranOnlineController::class, 'profile'])->name('profile.index');

    // Laporan Rekap
    Route::get('/rekap', [PendaftaranOnlineController::class, 'indexrekap'])->name('rekap.index');
    Route::get('/rekap/filter', [PendaftaranOnlineController::class, 'filter'])->name('rekap.filter');
    Route::get('/rekap/cetak_laporan', [PendaftaranOnlineController::class, 'cetak_laporan'])->name('cetak_laporan');
    Route::get('/rekap/export-pendaftar',[PendaftaranOnlineController::class, 'exportPendaftar'])->name('export-pendaftar');
    });

//role -> user
Route::middleware('auth', 'cekrole:user')->prefix('dashboarduser')->group(function () {
    Route::get('/', function () {
        $pendaftarCount = Pendaftaran::count();

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

    Route::get('/profile', [PendaftaranOnlineController::class, 'profileGET'])->name('pendaftar.profile');
    Route::post('/profile', [PendaftaranOnlineController::class, 'profilePOST'])->name('pendaftar.profileUpdate');
    // menu user
    Route::get('/pendaftar', [PendaftaranController::class, 'indexuser'])->name('pendaftar.indexuser');
    // Pendaftar
    Route::get('/pendaftar/{no_nisn}', [PendaftaranController::class, 'detailbynisn'])->name('pendaftar.detailuser');
    // Jadwal Test User
    Route::get('/jadwaltest', [JadwalTestController::class, 'indexuser'])->name('jadwaltestuser');
});
