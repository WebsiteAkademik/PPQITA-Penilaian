<?php

use App\Models\Pendaftar;
use App\Models\Pendaftaran;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Admin\PendaftaranOnlineController;
use App\Http\Controllers\Admin\AkademikController;
use App\Http\Controllers\JadwalTestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PengajarController;
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



// Login 
Route::get('/', function (){
    return view('pages.user.login');
})->name('homelogin');

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

    // Penilaian Tahfidz
    Route::get('/data_penilaiantahfidz', [PengajarController::class, 'listpenilaiantahfidz'])->name('penilaiantahfidz.index');
    Route::get('/data_penilaiantahfidz/form', [PengajarController::class, 'showFormpenilaiantahfidz'])->name('penilaiantahfidz.form');
    Route::post('/data_penilaiantahfidz/form', [PengajarController::class, 'penilaiantahfidzPost'])->name('penilaiantahfidz.formPOST');
    Route::get('/data_penilaiantahfidz/edit/{id}', [PengajarController::class, 'editpenilaiantahfidz'])->name('penilaiantahfidz.edit');
    Route::put('/data_penilaiantahfidz/edit/{id}', [PengajarController::class, 'updatepenilaiantahfidz'])->name('penilaiantahfidz.update');
    Route::delete('/data_penilaiantahfidz/{id}/delete', [PengajarController::class, 'deletepenilaiantahfidz'])->name('penilaiantahfidz.delete');

    // Penilaian Pelajaran
    Route::get('/data_penilaianpelajaran', [PengajarController::class, 'listpenilaianpelajaran'])->name('penilaianpelajaran.index');
    Route::get('/data_penilaianpelajaran/form', [PengajarController::class, 'showFormpenilaianpelajaran'])->name('penilaianpelajaran.form');
    Route::post('/data_penilaianpelajaran/form', [PengajarController::class, 'penilaianpelajaranPost'])->name('penilaianpelajaran.formPOST');
    Route::get('/data_penilaianpelajaran/edit/{id}', [PengajarController::class, 'editpenilaianpelajaran'])->name('penilaianpelajaran.edit');
    Route::put('/data_penilaianpelajaran/edit/{id}', [PengajarController::class, 'updatepenilaianpelajaran'])->name('penilaianpelajaran.update');
    Route::delete('/data_penilaianpelajaran/{id}/delete', [PengajarController::class, 'deletepenilaianpelajaran'])->name('penilaianpelajaran.delete');
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
        $tahunajar = TahunAjaran::all();


        $data = [
            'pendaftars' => $pendaftars,
            'jadwalTests' => $jadwalTests,
            'pendaftarbaruCount' => $pendaftarbaruCount,
            'pendaftartestCount' => $pendaftartestCount,
            'diterimaCount' => $diterimaCount,
            'ditolakCount' => $ditolakCount,
            'tahunajar' => $tahunajar,
        ];
        return view('pages.admin.dashboard', $data);
    })->name('dashboard');

    // menu user
    
    //Akademik
    //Tahun Ajaran
    Route::get('/data_tahun-ajar', [AkademikController::class, 'listtahunajar'])->name('tahunajar.index');
    Route::get('/data_tahun-ajar/form', [AkademikController::class, 'showFormtahunajar'])->name('tahunajar.form');
    Route::post('/data_tahun-ajar/form', [AkademikController::class, 'tahunajarPost'])->name('tahunajar.formPOST');
    Route::get('/data_tahun-ajar/edit/{id}', [AkademikController::class, 'edittahunajar'])->name('tahunajar.edit');
    Route::put('/data_tahun-ajar/edit/{id}', [AkademikController::class, 'updatetahunajar'])->name('tahunajar.update');
    Route::delete('/data_tahun-ajar/{id}/delete', [AkademikController::class, 'deletetahunajar'])->name('tahunajar.delete');
    
    //Kategori Pelajaran
    Route::get('/data_kategori', [AkademikController::class, 'listkategori'])->name('kategori.index');
    Route::get('/data_kategori/form', [AkademikController::class, 'showFormkategori'])->name('kategori.form');
    Route::post('/data_kategori/form', [AkademikController::class, 'kategoriPost'])->name('kategori.formPOST');
    Route::get('/data_kategori/edit/{id}', [AkademikController::class, 'editkategori'])->name('kategori.edit');
    Route::put('/data_kategori/edit/{id}', [AkademikController::class, 'updatekategori'])->name('kategori.update');
    Route::delete('/data_kategori/{id}/delete', [AkademikController::class, 'deletekategori'])->name('kategori.delete');
    
    //Sub Kategori Pelajaran
    Route::get('/data_subkategori', [AkademikController::class, 'listsubkategori'])->name('subkategori.index');
    Route::get('/data_subkategori/form', [AkademikController::class, 'showFormsubkategori'])->name('subkategori.form');
    Route::post('/data_subkategori/form', [AkademikController::class, 'subkategoriPost'])->name('subkategori.formPOST');
    Route::get('/data_subkategori/edit/{id}', [AkademikController::class, 'editsubkategori'])->name('subkategori.edit');
    Route::put('/data_subkategori/edit/{id}', [AkademikController::class, 'updatesubkategori'])->name('subkategori.update');
    Route::delete('/data_subkategori/{id}/delete', [AkademikController::class, 'deletesubkategori'])->name('subkategori.delete');

    //Mata Pelajaran
    Route::get('/data_mapel', [AkademikController::class, 'listmapel'])->name('mapel.index');
    Route::get('/data_mapel/form', [AkademikController::class, 'showFormmapel'])->name('mapel.form');
    Route::post('/data_mapel/form', [AkademikController::class, 'mapelPost'])->name('mapel.formPOST');
    Route::get('/data_mapel/edit/{id}', [AkademikController::class, 'editmapel'])->name('mapel.edit');
    Route::put('/data_mapel/edit/{id}', [AkademikController::class, 'updatemapel'])->name('mapel.update');
    Route::delete('/data_mapel/{id}/delete', [AkademikController::class, 'deletemapel'])->name('mapel.delete');
    
    //Kelas
    Route::get('/data_kelas', [AkademikController::class, 'listkelas'])->name('kelas.index');
    Route::get('/data_kelas/form', [AkademikController::class, 'showFormkelas'])->name('kelas.form');
    Route::post('/data_kelas/form', [AkademikController::class, 'kelasPost'])->name('kelas.formPOST');
    Route::get('/data_kelas/edit/{id}', [AkademikController::class, 'editkelas'])->name('kelas.edit');
    Route::put('/data_kelas/edit/{id}', [AkademikController::class, 'updatekelas'])->name('kelas.update');
    
    //Jadwal Ujian
    Route::get('/data_jadwalujian', [AkademikController::class, 'listjadwalujian'])->name('jadwalujian.index');
    Route::get('/data_jadwalujian/form', [AkademikController::class, 'showFormjadwalujian'])->name('jadwalujian.form');
    Route::post('/data_jadwalujian/form', [AkademikController::class, 'jadwalujianPost'])->name('jadwalujian.formPOST');
    Route::get('/data_jadwalujian/edit/{id}', [AkademikController::class, 'editjadwalujian'])->name('jadwalujian.edit');
    Route::put('/data_jadwalujian/edit/{id}', [AkademikController::class, 'updatejadwalujian'])->name('jadwalujian.update');
    Route::delete('/data_jadwalujian/delete/{id}', [AkademikController::class, 'deletejadwalujian'])->name('jadwalujian.delete');

    //Pengajar
    Route::get('/data_pengajar', [AkademikController::class, 'listpengajar'])->name('pengajar.index');
    Route::get('/data_pengajar/form', [AkademikController::class, 'showFormpengajar'])->name('pengajar.form');
    Route::post('/data_pengajar/form', [AkademikController::class, 'pengajarPost'])->name('pengajar.formPOST');
    Route::get('/data_pengajar/edit/{id}', [AkademikController::class, 'editpengajar'])->name('pengajar.edit');
    Route::put('/data_pengajar/edit/{id}', [AkademikController::class, 'updatepengajar'])->name('pengajar.update');
    Route::delete('/data_pengajar/{id}/delete', [AkademikController::class, 'deletepengajar'])->name('pengajar.delete');

    //Setup Mata Pelajaran
    Route::get('/data_setup', [AkademikController::class, 'listsetup'])->name('setup.index');
    Route::get('/data_setup/form', [AkademikController::class, 'showFormsetup'])->name('setup.form');
    Route::post('/data_setup/form', [AkademikController::class, 'setupPost'])->name('setup.formPOST');
    Route::get('/data_setup/edit/{id}', [AkademikController::class, 'editsetup'])->name('setup.edit');
    Route::put('/data_setup/edit/{id}', [AkademikController::class, 'updatesetup'])->name('setup.update');
    Route::delete('/data_setup/{id}/delete', [AkademikController::class, 'deletesetup'])->name('setup.delete');

    Route::get('/data_setup/{id}/detail', [AkademikController::class, 'listdetailsetup'])->name('detail.index');
    Route::get('/data_setup/{id}/detail/form', [AkademikController::class, 'showFormdetailsetup'])->name('detail.form');
    Route::post('/data_setup/{id}/detail/form', [AkademikController::class, 'detailsetupPost'])->name('detail.formPOST');
    Route::get('/data_setup/{id}/detail/edit/{id2}', [AkademikController::class, 'editdetailsetup'])->name('detail.edit');
    Route::put('/data_setup/{id}/detail/edit/{id2}', [AkademikController::class, 'updatedetailsetup'])->name('detail.update');
    Route::delete('/data_setup/{id}/detail/{id2}/delete', [AkademikController::class, 'deletedetailsetup'])->name('detail.delete');
    
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
        $pendaftars = Pendaftaran::where('user_id','=',auth()->user()->id )->get();
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
    // Cek Profile Siswa
    // History Nilai
});