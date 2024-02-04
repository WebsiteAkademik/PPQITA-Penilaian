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
        return redirect()->route('jadwaltest.list')->with('success', 'Jadwal test updated successfully');
    }

    public function edittest($id){
        // Retrieve the jadwal test based on the $id
        $jadwalTest = JadwalTest::findOrFail($id);
    
        // Return the view for editing the jadwal test
        return view('jadwaltest.edittest', compact('jadwalTest'));
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
