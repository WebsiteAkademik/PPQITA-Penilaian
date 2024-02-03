<?php

namespace App\Http\Controllers;

use App\Models\JadwalTest;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class JadwalTestController extends Controller
{
    public function showForm(){
        // Ambil data pendaftar dari database
        $pendaftar = Pendaftaran::all();

        // Kirim data pendaftar ke view
        return view('jadwaltest.form', ['pendaftars' => $pendaftar]);
        
        // return view('jadwaltest.form'); // kode sebelumnya
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'nama_calon_siswa' => 'required',
            'tanggal_test' => 'required',
            'jam_test' => 'required',
            'jenis_test' => 'required',
            'pic_test' => 'required',
        ]);

        JadwalTest::create($validatedData);

        Alert::success('Berhasil', 'Jadwal test berhasil disimpan!');
        return redirect()->route('dashboard')->with('success', 'Jadwal Test Berhasil Disimpan');
        
    }

    public function list(){
    // Ambil data jadwal test dari database
    $jadwalTests = JadwalTest::all();

    // Kirim data jadwal test ke view
    return view('jadwaltest.list', ['jadwalTests' => $jadwalTests]);
    }

    public function edit($id)
    {
        $jadwalTest = JadwalTest::find($id);
        // Lakukan operasi edit atau tampilkan form edit
        return view('pages.admin.edit_jadwaltest', compact('jadwalTest'));
    }
    
    public function indexuser()
    {
        $user = Auth::user();
        // Untuk mengambil data jadwal test sesuai dengan user yang login
        $jadwalTests = JadwalTest::where('nama_calon_siswa', $user->name)->get();
        // Untuk menampilkan halaman jadwaltestuser
        return view('pages.menuuser.jadwaltestuser', compact('jadwalTests'));
    }

}
