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
use Illuminate\Validation\Rule;
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
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->firstOrFail();

        $validatedData = Validator::make($request->all(), [
            'kode_kategori' => ['required', Rule::unique('kategori_pelajarans', 'kode_kategori')->ignore($id)],
            'nama_kategori' => ['required', Rule::unique('kategori_pelajarans', 'nama_kategori')->where(function ($query) use ($tahunAjaranAktif, $request) {
                return $query->where('tahun_ajaran_id', $tahunAjaranAktif->id);
            })->ignore($id)],
        ]);
        
        if ($validatedData->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode kategori yang sama atau nama kategori yang sama!');
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
    
        $kategori = KategoriPelajaran::findOrFail($id);
    
        $kategori->fill([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
        ])->save();
    
        Alert::success('Berhasil', 'Kategori Pelajaran berhasil diperbarui!');
        return redirect()->route('kategori.index')->with('success', 'Kategori Pelajaran berhasil diperbarui!');
        
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
            return view('pages.admin.akademik.subkategorimapel.index', ['subkategori' => []]);
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
            'kategori_id' => 'required',
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode yang sama!');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();

        try {
            // Mendapatkan tahun ajaran aktif
            $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->firstOrFail();
            
            // Memasukkan ID tahun ajaran aktif ke data yang akan disimpan
            $data['tahun_ajaran_id'] = $tahunAjaranAktif->id;
    
            // Mengecek apakah terdapat nama kategori yang sama pada tahun ajaran aktif yang sama
            $kategoriSama = SubKategoriPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->where('kategori_id', $data['kategori_id'])
                ->where('nama_sub_kategori', $data['nama_sub_kategori'])
                ->first();

            if ($kategoriSama) {
                Alert::error('Gagal! (E002)', 'Nama Sub kategori yang sama sudah ada pada kategori dan tahun ajaran ini!');
                return redirect()->back()->withInput();
            }

            // Membuat Sub kategori pelajaran
            $subkategori = SubKategoriPelajaran::create($data);
    
            Alert::success('Berhasil', 'Sub Kategori Pelajaran berhasil disimpan!');
            return redirect()->route('subkategori.index')->with('success', 'Sub Kategori Pelajaran berhasil disimpan!');
        } catch (\Exception $e) {
            Alert::error('Gagal! (E006)', 'Cek kembali kesesuaian isi form dengan validasi database');
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
        $validatedData = Validator::make($request->all(), [
            'kode_sub_kategori' => ['required', Rule::unique('sub_kategori_pelajarans', 'kode_sub_kategori')->ignore($id)],
            'nama_sub_kategori' => ['required', Rule::unique('sub_kategori_pelajarans')->where(function ($query) use ($request) {
                return $query->where('kategori_id', $request->kategori_id);
            })->ignore($id)],
            'kategori_id' => 'required',
        ]);
    
        if ($validatedData->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode sub kategori yang sama atau nama sub kategori pada kategori pelajaran yang sama!');
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
    
        $subkategori = SubKategoriPelajaran::findOrFail($id);
    
        $subkategori->fill([
            'kode_sub_kategori' => $request->kode_sub_kategori,
            'nama_sub_kategori' => $request->nama_sub_kategori,
            'kategori_id' => $request->kategori_id,
        ])->save();
    
        Alert::success('Berhasil', 'Sub Kategori Pelajaran berhasil diperbarui!');
        return redirect()->route('subkategori.index')->with('success', 'Sub Kategori Pelajaran berhasil diperbarui!');
    }

    public function deletesubkategori($id){
        $subkategori = SubKategoriPelajaran::findOrFail($id);
        $subkategori->delete();
        return redirect()->route('subkategori.index')->with('success', 'Sub Kategori Pelajaran berhasil dihapus!');
    }

    //Mata Pelajaran
    public function listmapel(){
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.akademik.mapel.index', ['mapel' => []]);
        }

        $mapel = MataPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
        
        return view('pages.admin.akademik.mapel.index', ['mapel' => $mapel]);
    }

    public function showFormmapel(){
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.akademik.mapel.form', ['mapel' => []]);
        }

        $kategori = KategoriPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
        $subkategori = SubKategoriPelajaran::all();

        return view('pages.admin.akademik.mapel.form', ['kategori' => $kategori, 'subkategori' => $subkategori,]);
    }

    public function mapelPost(Request $request){
        $globalValidatorData = [
            'kode_mata_pelajaran' => 'required|unique:mata_pelajarans,kode_mata_pelajaran',
            'nama_mata_pelajaran' => 'required',
            'kkm' => 'required',
            'kategori_pelajaran_id' => 'required',
            'sub_kategori_pelajaran_id' => 'required',
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan validasi data dengan database sudah benar!');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();

        try {
            // Mendapatkan tahun ajaran aktif
            $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->firstOrFail();
            
            // Memasukkan ID tahun ajaran aktif ke data yang akan disimpan
            $data['tahun_ajaran_id'] = $tahunAjaranAktif->id;
    
            // Mengecek apakah terdapat nama mata pelajaran yang sama pada tahun ajaran aktif yang sama
            $subkategoriSama = MataPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->where('sub_kategori_pelajaran_id', $data['sub_kategori_pelajaran_id'])
                ->where('nama_mata_pelajaran', $data['nama_mata_pelajaran'])
                ->first();

            if ($subkategoriSama) {
                Alert::error('Gagal! (E002)', 'Nama Mata Pelajaran yang sama sudah ada pada sub kategori ini!');
                return redirect()->back()->withInput();
            }

            // Membuat Sub kategori pelajaran
            $mapel = MataPelajaran::create($data);
    
            Alert::success('Berhasil', 'Mata Pelajaran berhasil disimpan!');
            return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil disimpan!');
        } catch (\Exception $e) {
            Alert::error('Gagal! (E006)', 'Cek kembali kesesuaian isi form dengan validasi database');
            return redirect()->back()->withInput();
        }
    }

    public function editmapel($id){
        $mapel = MataPelajaran::findOrFail($id);

        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.akademik.mapel.edit', ['mapel' => []]);
        }

        $kategori = KategoriPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
        $subkategori = SubKategoriPelajaran::all();

        return view('pages.admin.akademik.mapel.edit', ['mapel' => $mapel, 'kategori' => $kategori, 'subkategori' => $subkategori,]);
    }

    public function updatemapel(Request $request, $id){
        $validatedData = Validator::make($request->all(), [
            'kode_mata_pelajaran' => ['required', Rule::unique('mata_pelajarans', 'kode_mata_pelajaran')->ignore($id)],
            'nama_mata_pelajaran' => ['required', Rule::unique('mata_pelajarans')->where(function ($query) use ($request) {
                return $query->where('sub_kategori_pelajaran_id', $request->sub_kategori_pelajaran_id);
            })->ignore($id)],
            'kkm' => 'required',
            'kategori_pelajaran_id' => 'required',
            'sub_kategori_pelajaran_id' => 'required',
        ]);
    
        if ($validatedData->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode sub kategori yang sama atau nama sub kategori pada kategori pelajaran yang sama!');
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
    
        $mapel = MataPelajaran::findOrFail($id);
    
        $mapel->fill([
            'kode_sub_kategori' => $request->kode_sub_kategori,
            'nama_sub_kategori' => $request->nama_sub_kategori,
            'kkm' => $request->kkm,
            'kategori_pelajaran_id' => $request->kategori_pelajaran_id,
            'sub_kategori_pelajaran_id' => $request->sub_kategori_pelajaran_id,
        ])->save();
    
        Alert::success('Berhasil', 'Mata Pelajaran berhasil diperbarui!');
        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil diperbarui!');
    }

    public function deletemapel($id){
        $mapel = MataPelajaran::findOrFail($id);
        $mapel->delete();
        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil dihapus!');
    }

    //Pengajar
}
