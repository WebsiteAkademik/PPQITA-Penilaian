<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TahunAjaran;
use App\Models\KategoriPelajaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class AkademikController extends Controller
{
    
    //Tahun Ajar
    public function listtahunajar(){
        $tahunajar = TahunAjaran::all();
    
        return view('pages.admin.akademik.tahunajar.index', ['tahunajar' => $tahunajar]);
    }

    public function showFormtahunajar(){
        return view('pages.admin.akademik.tahunajar.form');
    }

    public function tahunajarPost(Request $request){
        $globalValidatorData = [
            'tahun_ajaran' => 'required|unique:tahun_ajarans,tahun_ajaran',
            'status' => 'required',
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();

        if ($data['status'] === 'aktif') {
            TahunAjaran::where('status', 'aktif')->update(['status' => 'tidak aktif']);
        }
        
        $tahunajar = NULL;
        
        try{
            $tahunajar = TahunAjaran::create($data);
        }
        catch(Exception $e){
            $tahunajar->delete();
            Alert::error('Gagal! (E006)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withError($e)->withInput();
        }

        Alert::success('Berhasil', 'Tahun Ajaran berhasil disimpan!');

        return redirect()->route('tahunajar.index')->with('success', 'Tahun Ajaran Berhasil Disimpan');
    }

    public function edittahunajar($id){
        // Retrieve the jadwal test based on the $id
        $tahunajar = TahunAjaran::findOrFail($id);
    
        // Return the view for editing the jadwal test
        return view('pages.admin.akademik.tahunajar.edit', compact('tahunajar'));
    }

    public function updatetahunajar(Request $request, $id){
        $tahunajar = TahunAjaran::findOrFail($id);

        // Validasi data yang diupdate
        $validatedData = $request->validate([
            'tahun_ajaran' => 'required|unique:tahun_ajarans,tahun_ajaran,'.$id,
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        // Periksa apakah status diubah menjadi 'aktif'
        if ($validatedData['status'] === 'aktif') {
            // Mengubah status tahun ajaran lainnya menjadi 'tidak aktif'
            TahunAjaran::where('id', '!=', $id)->update(['status' => 'tidak aktif']);
        }

        // Update data tahun ajaran
        try {
            $tahunajar->update($validatedData);
            return redirect()->route('tahunajar.index')->with('success', 'Tahun Ajaran berhasil diperbaharui!');
        } catch (\Exception $e) {
            // Tangani jika terjadi kesalahan saat update
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }

    public function deletetahunajar($id){
        $tahunajar = TahunAjaran::findOrFail($id);
        $tahunajar->delete();
        return redirect()->route('tahunajar.index')->with('success', 'Tahun Ajaran berhasil dihapus!');
    }

    //Kategori Pelajaran
    public function listkategori(){
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.akademik.kategorimapel.index', ['kategori' => []]);
        }

        $kategori = KategoriPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
        
        return view('pages.admin.akademik.kategorimapel.index', ['kategori' => $kategori]);
    }

    public function showFormkategori(){
        return view('pages.admin.akademik.kategorimapel.form');
    }

    public function kategoriPost(Request $request){
        $globalValidatorData = [
            'kode_kategori' => 'required|unique:kategori_pelajarans,kode_kategori',
            'nama_kategori' => 'required',
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();

        try {
            // Mendapatkan tahun ajaran aktif
            $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->firstOrFail();
            
            // Memasukkan ID tahun ajaran aktif ke data yang akan disimpan
            $data['tahun_ajaran_id'] = $tahunAjaranAktif->id;
    
            // Membuat kategori pelajaran
            $kategori = KategoriPelajaran::create($data);
    
            Alert::success('Berhasil', 'Kategori Pelajaran berhasil disimpan!');
            return redirect()->route('kategori.index')->with('success', 'Kategori Pelajaran berhasil disimpan!');
        } catch (\Exception $e) {
            Alert::error('Gagal! (E006)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withError($e)->withInput();
        }
    }

    //Sub Kategori Pelajaran


    //Mata Pelajaran
    //Pengajar
}
