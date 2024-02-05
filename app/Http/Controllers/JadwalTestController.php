<?php

namespace App\Http\Controllers;

use App\Models\JadwalTest;
use App\Models\Pendaftaran;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


class JadwalTestController extends Controller
{
    public function showForm(){
        // Ambil data pendaftar dengan status "MENUNGGU" dari database
        $pendaftarMenunggu = Pendaftaran::where('status', 'MENUNGGU')->get();

        // Kirim data pendaftar ke view
        return view('jadwaltest.form', ['pendaftars' => $pendaftarMenunggu]);
    }

    public function store(Request $request){
        $globalValidator = Validator::make($request->all(), [
            'pendaftaran_id' => 'required',
            'tanggal_test' => 'required',
            'jam_test' => 'required',
            'jenis_test' => 'required',
            'pic_test' => 'required',
        ]);

        $validatedData = $request->validate([
            'pendaftaran_id' => 'required',
            'tanggal_test' => 'required',
            'jam_test' => 'required',
            'jenis_test' => 'required',
            'pic_test' => 'required',
        ]);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $pendaftaran_id = $request->all()["pendaftaran_id"];

        if(Pendaftaran::where('id', $pendaftaran_id)->where("status", "MENUNGGU")->count() == 0){
            Alert::error('Gagal! (E008)', 'Terjadi kesalahan karena terdapat penyuntikan yang tidak sesuai dengan tabel');
            return redirect()->back()->withInput();
        }        

        // Memastikan peserta dengan status "MENUNGGU" dan nama_calon_siswa sesuai dengan db
        $pendaftar = Pendaftaran::where('id', $validatedData['pendaftaran_id'])
            ->where('status', 'MENUNGGU')
            ->first();

        if (!$pendaftar) {
            // Peserta tidak ditemukan atau tidak berstatus "MENUNGGU"
            Alert::error('Gagal', 'Peserta tidak dapat dijadwalkan.');
            return redirect()->back();
        }

        // Mengecek apakah peserta sudah memiliki jadwal test
        $existingJadwal = JadwalTest::where('pendaftaran_id', $validatedData['pendaftaran_id'])->first();

        if ($existingJadwal) {
            // Jika peserta sudah memiliki jadwal test
            Alert::error('Gagal', 'Peserta sudah memiliki jadwal test.');
            return redirect()->back();
        }

        // Buat jadwal test
        JadwalTest::create($validatedData);

        // Update status peserta menjadi "TEST" setelah dijadwalkan
        $pendaftar->update(['status' => 'TEST']);

        Alert::success('Berhasil', 'Jadwal test berhasil disimpan!');
        return redirect()->route('dashboard')->with('success', 'Jadwal Test Berhasil Disimpan');
    }

    public function list(){
    // Ambil data jadwal test dari database
    $jadwalTests = JadwalTest::all();

    // Kirim data jadwal test ke view
    return view('jadwaltest.list', ['jadwalTests' => $jadwalTests]);
    }

    public function update(Request $request, $id){
        // 1. Retrieve the jadwal test to be updated
        $jadwalTest = JadwalTest::findOrFail($id);

        $validatedData = $request->validate([
            'tanggal_test' => 'required',
            'jam_test' => 'required',
            'jenis_test' => 'required',
            'pic_test' => 'required',
        ]);

        $jadwalTest->update($validatedData);
        return redirect()->route('jadwaltest.list')->with('success', 'Jadwal test berhasil diperbaharui!');
    }

    public function edittest($id){
        // Retrieve the jadwal test based on the $id
        $jadwalTest = JadwalTest::findOrFail($id);
    
        // Return the view for editing the jadwal test
        return view('jadwaltest.edittest', compact('jadwalTest'));
    }

    public function delete($id){
        $jadwalTest = JadwalTest::findOrFail($id);
        $jadwalTest->delete();
        return redirect()->route('jadwaltest.list')->with('success', 'Jadwal test berhasil dihapus!');
    }

    public function indexuser()
    {
        $user = Auth::user();
        // Untuk mengambil data jadwal test sesuai dengan user yang login
        
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        if (!$pendaftaran){
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->intended('/login');
        }

        $jadwalTests = JadwalTest::where("pendaftaran_id", $pendaftaran->id)->get();

        // Untuk menampilkan halaman jadwaltestuser
        return view('pages.menuuser.jadwaltestuser', [
            'jadwalTests' => $jadwalTests,
        ]);
    }

}
