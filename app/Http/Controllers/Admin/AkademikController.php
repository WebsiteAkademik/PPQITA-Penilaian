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
    //Sub Kategori Pelajaran
    //Mata Pelajaran
    //Pengajar
}
