<?php

namespace App\Http\Controllers;

use App\Models\JadwalTest;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class JadwalTestController extends Controller
{
    public function showForm(){
        // Ambil data pendaftar dari database
        $pendaftar = Pendaftar::all();

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

}
