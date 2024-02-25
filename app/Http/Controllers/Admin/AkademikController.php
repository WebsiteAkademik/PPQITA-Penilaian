<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TahunAjaran;
use App\Models\KategoriPelajaran;
use App\Models\SubKategoriPelajaran;
use App\Models\MataPelajaran;
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
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada tahun ajaran yang sama!');
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
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode kategori yang sama!');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();

        try {
            // Mendapatkan tahun ajaran aktif
            $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->firstOrFail();
            
            // Memasukkan ID tahun ajaran aktif ke data yang akan disimpan
            $data['tahun_ajaran_id'] = $tahunAjaranAktif->id;

            // Mengecek apakah terdapat nama kategori yang sama pada tahun ajaran aktif yang sama
                $kategoriSama = KategoriPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                    ->where('nama_kategori', $data['nama_kategori'])
                    ->first();

            if ($kategoriSama) {
                Alert::error('Gagal! (E002)', 'Nama kategori yang sama sudah ada pada tahun ajaran ini!');
                return redirect()->back()->withInput();
            }
    
            // Membuat kategori pelajaran
            $kategori = KategoriPelajaran::create($data);
    
            Alert::success('Berhasil', 'Kategori Pelajaran berhasil disimpan!');
            return redirect()->route('kategori.index')->with('success', 'Kategori Pelajaran berhasil disimpan!');
        } catch (\Exception $e) {
            Alert::error('Gagal! (E006)', 'Cek kembali kesesuaian isi form dengan validasi database');
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }

    public function editkategori($id){
        $kategori = KategoriPelajaran::findOrFail($id);
    
        return view('pages.admin.akademik.kategorimapel.edit', compact('kategori'));
    }

    public function updatekategori(Request $request, $id){
        $kategori = KategoriPelajaran::findOrFail($id);

        // Validasi data yang diupdate
        $validatedData = $request->validate([
            'kode_kategori' => 'required|unique:kategori_pelajarans,kode_kategori',
            'nama_kategori' => 'required',
        ]);

        // Update data kategori pelajaran
        try {
            // Periksa dan update data jika tersedia dalam permintaan
            if ($request->has('kode_kategori')) {
                $kategori->kode_kategori = $validatedData['kode_kategori'];
            }

            if ($request->has('nama_kategori')) {
                $kategori->nama_kategori = $validatedData['nama_kategori'];
            }

            $kategori->update($validatedData);
            return redirect()->route('kategori.index')->with('success', 'Kategori Pelajaran berhasil diperbaharui!');
        } catch (\Exception $e) {
            // Tangani jika terjadi kesalahan saat update
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }

    public function deletekategori($id){
        $kategori = KategoriPelajaran::findOrFail($id);
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori Pelajaran berhasil dihapus!');
    }

    //Sub Kategori Pelajaran
    public function listsubkategori(){
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.akademik.subkategorimapel.index', ['kategori' => []]);
        }

        $subkategori = SubKategoriPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
        
        return view('pages.admin.akademik.subkategorimapel.index', ['subkategori' => $subkategori]);
    }

    public function showFormsubkategori(){
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.akademik.subkategorimapel.form', ['kategori' => []]);
        }

        $kategori = KategoriPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
        
        return view('pages.admin.akademik.subkategorimapel.form', ['kategori' => $kategori]);
    }

    public function subkategoriPost(Request $request){
        $globalValidatorData = [
            'kode_sub_kategori' => 'required|unique:sub_kategori_pelajarans,kode_sub_kategori',
            'nama_sub_kategori' => 'required',
            'kategori_pelajaran_id' => 'required',
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode yang sama!');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();
        $kategori_pelajaran_id = $request->all()["kategori_pelajaran_id"];

        try {
            // Mendapatkan tahun ajaran aktif
            $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->firstOrFail();
            
            // Memasukkan ID tahun ajaran aktif ke data yang akan disimpan
            $data['tahun_ajaran_id'] = $tahunAjaranAktif->id;
    
            // Membuat kategori pelajaran
            $subkategori = SubKategoriPelajaran::create($data);
    
            Alert::success('Berhasil', 'Sub Kategori Pelajaran berhasil disimpan!');
            return redirect()->route('subkategori.index')->with('success', 'Sub Kategori Pelajaran berhasil disimpan!');
        } catch (\Exception $e) {
            Alert::error('Gagal! (E006)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withInput();
        }
    }

    public function editsubkategori($id){
        $subkategori = SubKategoriPelajaran::findOrFail($id);

        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.akademik.subkategorimapel.edit', ['kategori' => []]);
        }

        $kategori = KategoriPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
    
        return view('pages.admin.akademik.subkategorimapel.edit', ['subkategori' => $subkategori,'kategori' => $kategori]);
    }

    public function updatesubkategori(Request $request, $id){
        $subkategori = SubKategoriPelajaran::findOrFail($id);

        // Validasi data yang diupdate
        $validatedData = $request->validate([
            'kode_sub_kategori' => 'required|unique:sub_kategori_pelajarans,kode_sub_kategori',
            'nama_sub_kategori' => 'required',
            'kategori_pelajaran_id' => 'required',
        ]);
        
        $kategori_pelajaran_id = $request->all()["kategori_pelajaran_id"];
        
        // Update data Sub kategori pelajaran
        try {
            if ($request->has('kode_sub_kategori')) {
                $subkategori->kode_sub_kategori = $validatedData['kode_sub_kategori'];
            }

            if ($request->has('nama_sub_kategori')) {
                $subkategori->nama_sub_kategori = $validatedData['nama_sub_kategori'];
            }

            if ($request->has('kategori_pelajaran_id')) {
                $subkategori->kategori_pelajaran_id = $validatedData['kategori_pelajaran_id'];
            }

            $subkategori->update($validatedData);
            return redirect()->route('subkategori.index')->with('success', 'Sub Kategori Pelajaran berhasil diperbaharui!');
        } catch (\Exception $e) {
            // Tangani jika terjadi kesalahan saat update
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }

    public function deletesubkategori($id){
        $subkategori = SubKategoriPelajaran::findOrFail($id);
        $subkategori->delete();
        return redirect()->route('subkategori.index')->with('success', 'Sub Kategori Pelajaran berhasil dihapus!');
    }

    //Mata Pelajaran
    //Pengajar
}
