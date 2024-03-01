<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TahunAjaran;
use App\Models\KategoriPelajaran;
use App\Models\SubKategoriPelajaran;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\SetupMataPelajaran;
use App\Models\DetailSetupMataPelajaran;
use App\Models\Pengajar;
use App\Models\Siswa;
use App\Models\PenilaianPelajaran;
use App\Models\PenilaianTahfidz;
use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
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
        catch(\Exception $e){
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

    //Kelas
    public function listkelas(){
        $kelas = Kelas::all();
    
        return view('pages.admin.akademik.kelas.index', ['kelas' => $kelas]);
    }

    public function showFormkelas(){
        return view('pages.admin.akademik.kelas.form');
    }

    public function kelasPost(Request $request){
        $globalValidatorData = [
            'kelas' => 'required|unique:kelas,kelas',
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada data yang sama!');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();
        
        try{
            $kelas = Kelas::create($data);
        }
        catch(\Exception $e){
            $kelas->delete();
            Alert::error('Gagal! (E006)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withError($e)->withInput();
        }

        Alert::success('Berhasil', 'Kelas berhasil disimpan!');

        return redirect()->route('kelas.index')->with('success', 'Kelas Berhasil Disimpan');
    }

    public function editkelas($id){
        $kelas = Kelas::findOrFail($id);
    
        return view('pages.admin.akademik.kelas.edit', compact('kelas'));
    }

    public function updatekelas(Request $request, $id){
        $kelas = Kelas::findOrFail($id);

        // Validasi data yang diupdate
        $validatedData = $request->validate([
            'kelas' => 'required|unique:kelas,kelas',
        ]);

        // Update data Kelas
        try {
            $kelas->update($validatedData);
            return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbaharui!');
        } catch (\Exception $e) {
            // Tangani jika terjadi kesalahan saat update
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }

    //Jadwal Ujian
    public function listjadwalujian(){
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.akademik.jadwalujian.index', ['jadwalujian' => []]);
        }
        
        $jadwalujian = JadwalUjian::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
    
        return view('pages.admin.akademik.jadwalujian.index', ['jadwalujian' => $jadwalujian]);
    }

    public function showFormjadwalujian(){
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $kelas = Kelas::all();

        $mapel = MataPelajaran::where('tahun_ajaran_id', $tahunAjaran->id)->get();
        
        return view('pages.admin.akademik.jadwalujian.form', ['tahunAjaran' => $tahunAjaran, 'kelas' => $kelas, 'mapel' => $mapel]);
    }

    public function jadwalujianPost(Request $request){
        $globalValidatorData = [
            'tanggal_ujian' => 'required',
            'jam_ujian' => 'required',
            'kelas_id' => 'required',
            'jenis_ujian' => 'required',
            'mata_pelajaran_id' => 'required',
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada data yang sama!');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();
        
        try{
            $jadwalujian = JadwalUjian::create($data);
        }
        catch(\Exception $e){
            Alert::error('Gagal! (E006)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withError($e)->withInput();
        }

        Alert::success('Berhasil', 'Jadwal Ujian berhasil disimpan!');

        return redirect()->route('jadwalujian.index')->with('success', 'Jadwal Ujian Berhasil Disimpan');
    }

    public function deletejadwalujian($id){
        $jadwalujian = JadwalUjian::findOrFail($id);
        
        try {
            $jadwalujian->delete();
            return redirect()->route('jadwalujian.index')->with('success', 'Jadwal Ujian berhasil dihapus!');
        } catch (\Exception $e) {
            // Tangani jika terjadi kesalahan saat menghapus
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }    

     public function editjadwalujian($id){
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();

        $kelas = Kelas::all();

        $mapel = MataPelajaran::where('tahun_ajaran_id', $tahunAjaran->id)->get();

        $jadwalujian = JadwalUjian::findOrFail($id);
        
        return view('pages.admin.akademik.jadwalujian.edit', ['tahunAjaran' => $tahunAjaran, 'kelas' => $kelas, 'mapel' => $mapel, 'jadwalujian' => $jadwalujian]);
     }

     public function updatejadwalujian(Request $request, $id){
         $jadwalujian = JadwalUjian::findOrFail($id);

         // Validasi data yang diupdate
        $validatedData = $request->validate([
            'tanggal_ujian' => 'required',
            'jam_ujian' => 'required',
            'kelas_id' => 'required',
            'jenis_ujian' => 'required',
            'mata_pelajaran_id' => 'required',
        ]);

         // Update data Jadwal Ujian
         try {
             $jadwalujian->update($validatedData);
             return redirect()->route('jadwalujian.index')->with('success', 'Jadwal Ujian berhasil diperbaharui!');
         } catch (\Exception $e) {
             // Tangani jika terjadi kesalahan saat update
             return redirect()->back()->withErrors([$e->getMessage()])->withInput();
         }
     }

    //Pengajar
    public function listpengajar(){
        $pengajar = Pengajar::all();
        
        return view('pages.admin.akademik.pengajar.index', ['pengajar' => $pengajar]);
    }

    public function showFormpengajar(){
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.akademik.pengajar.form', ['mapel' => []]);
        }

        $mapel = MataPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();

        return view('pages.admin.akademik.pengajar.form', ['mapel' => $mapel,]);
    }

    public function pengajarPost(Request $request){
        $globalValidatorData = [
            'nama_pengajar' => 'required',
            'alamat' => 'required',
            'no_wa_pengajar' => 'required',
            'username' => 'required|alpha_dash|unique:users,name',
            'password' => 'required'
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan validasi data dengan database sudah benar!');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();

        $dataUser = [
            "name" => $data['nama_pengajar'],
            "email" => $data['username'],
            "role" => "pengajar",
            "password" => Hash::make($data['password']),
        ];

        unset($data['username']);
        unset($data['password']);
        $user = NULL;
        try {
            $user = User::create($dataUser);
        } catch (\Exception $e) {
            Alert::error('Gagal! (E005)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withError($e)->withInput();
        }

        $data["user_id"] = $user->id;

        try {
            $pengajar = Pengajar::create($data);
    
            Alert::success('Berhasil', 'Pengajar berhasil disimpan!');
            return redirect()->route('pengajar.index')->with('success', 'Pengajar berhasil disimpan!');
        } catch (\Exception $e) {
            Alert::error('Gagal! (E006)', 'Cek kembali kesesuaian isi form dengan validasi database');
            return redirect()->back()->withInput();
        }
    }

    public function editpengajar($id){
        $pengajar = Pengajar::findOrFail($id);

        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.akademik.pengajar.edit', ['pengajar' => []]);
        }

        $mapel = MataPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();

        return view('pages.admin.akademik.pengajar.edit', ['pengajar' => $pengajar, 'mapel' => $mapel,]);
    }

    public function updatepengajar(Request $request, $id){
        $validatedData = Validator::make($request->all(), [
            'nama_pengajar' => 'required',
            'alamat' => 'required',
            'no_wa_pengajar' => 'required',
        ]);
    
        if ($validatedData->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode sub kategori yang sama atau nama sub kategori pada kategori pelajaran yang sama!');
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
    
        $pengajar = Pengajar::findOrFail($id);
    
        $pengajar->fill([
            'nama_pengajar' => $request->nama_pengajar,
            'alamat' => $request->alamat,
            'no_wa_pengajar' => $request->no_wa_pengajar,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
        ])->save();
    
        Alert::success('Berhasil', 'Data Pengajar berhasil diperbarui!');
        return redirect()->route('pengajar.index')->with('success', 'Data Pengajar berhasil diperbarui!');
    }

    public function deletepengajar($id){
        $pengajar = Pengajar::findOrFail($id);
        $user = User::where('id', $pengajar->user_id);
        $user->delete();
        $pengajar->delete();
        return redirect()->route('pengajar.index')->with('success', 'Data Pengajar berhasil dihapus!');
    }

    //Setup Mata Pelajaran
    public function listsetup(){
        $setup = SetupMataPelajaran::all();
        
        return view('pages.admin.akademik.setupmapel.index', ['setup' => $setup]);
    }

    public function showFormsetup(){
        $kelas = Kelas::all();

        $pengajar = Pengajar::all();

        return view('pages.admin.akademik.setupmapel.form', ['kelas' => $kelas, 'pengajar' => $pengajar,]);
    }

    public function setupPost(Request $request){
        // Mendapatkan tahun ajaran aktif
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->firstOrFail();

        $globalValidatorData = [
            'tanggal_setup' => 'required',
            'kelas_id' => 'required',
            'pengajar_id' => 'required'
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada data yang sama!');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();
        
        try{
            // Memasukkan ID tahun ajaran aktif ke data yang akan disimpan
            $data['tahun_ajaran_id'] = $tahunAjaranAktif->id;

            // Mengecek apakah terdapat nama mata pelajaran yang sama pada tahun ajaran aktif yang sama
            $setupSama = SetupMataPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->where('kelas_id', $data['kelas_id'])
                ->where('pengajar_id', $data['pengajar_id'])
                ->first();

            if ($setupSama) {
                Alert::error('Gagal! (E002)', 'Setup dengan ketentuan yang sama sudah ada!');
                return redirect()->back()->withInput();
            }

            $setup = SetupMataPelajaran::create($data);
            Alert::success('Berhasil', 'Pengajar berhasil disimpan!');
            return redirect()->route('setup.index')->with('success', 'Setup Mata Pelajaran berhasil disimpan!');
        }
        catch(\Exception $e){
            $kelas->delete();
            Alert::error('Gagal! (E006)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withError($e)->withInput();
        }

        Alert::success('Berhasil', 'Setup Mata Pelajaran berhasil disimpan!');

        return redirect()->route('setup.index')->with('success', 'Setup Mata Pelajaran Berhasil Disimpan');
    }

    public function editsetup($id){
        $setup = SetupMataPelajaran::findOrFail($id);

        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.akademik.pengajar.edit', ['pengajar' => []]);
        }

        $kelas = Kelas::all();

        $pengajar = Pengajar::all();

        $mapel = MataPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();

        return view('pages.admin.akademik.setupmapel.edit', ['pengajar' => $pengajar, 'mapel' => $mapel, 'kelas' => $kelas, 'setup' => $setup]);
    }

    public function updatesetup(Request $request, $id){
        $validatedData = Validator::make($request->all(), [
            'tanggal_setup' => 'required',
            'kelas_id' => 'required',
            'pengajar_id' => 'required'
        ]);
    
        if ($validatedData->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode sub kategori yang sama atau nama sub kategori pada kategori pelajaran yang sama!');
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
    
        $setup = SetupMataPelajaran::findOrFail($id);

        $setupSama = SetupMataPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('kelas_id', $request->kelas_id)
            ->where('pengajar_id', $request->pengajar_id)
            ->first();

        if ($setupSama) {
            Alert::error('Gagal! (E002)', 'Setup dengan ketentuan yang sama sudah ada!');
            return redirect()->back()->withInput();
        }
    
        $setup->fill([
            'tanggal_setup' => $request->tanggal_setup,
            'kelas_id' => $request->kelas_id,
            'pengajar_id' => $request->pengajar_id,
        ])->save();
    
        Alert::success('Berhasil', 'Setup Mata Pelajaran berhasil diperbarui!');
        return redirect()->route('setup.index')->with('success', 'Setup Mata Pelajaran berhasil diperbarui!');
    }

    public function deletesetup($id){
        $setup = SetupMataPelajaran::findOrFail($id);
        $setup->delete();
        return redirect()->route('setup.index')->with('success', 'Setup Mata Pelajaran berhasil dihapus!');
    }

    //Setup Mata Pelajaran Detail
    public function listdetailsetup($id){
        $setup = SetupMataPelajaran::findOrFail($id);
        $detail = DetailSetupMataPelajaran::where('setup_mata_pelajaran_id', $setup->id)->get();

        $tahunajar = TahunAjaran::where('id', $setup->tahun_ajaran_id)->first();

        $pengajar = Pengajar::where('id', $setup->pengajar_id)->first();

        $kelas = Kelas::where('id', $setup->kelas_id)->first();

        return view('pages.admin.akademik.setupmapel.detail.index', ['setup' => $setup, 'detail' => $detail, 'tahunajar' => $tahunajar, 'pengajar' => $pengajar, 'kelas' => $kelas]);
    }

    public function showFormdetailsetup($id){
        $setup = SetupMataPelajaran::findOrFail($id);

        $tahunajar = TahunAjaran::where('id', $setup->tahun_ajaran_id)->first();

        $mapel = MataPelajaran::where('tahun_ajaran_id', $tahunajar->id)->get();

        return view('pages.admin.akademik.setupmapel.detail.form', ['setup' => $setup, 'mapel' => $mapel, 'tahunajar' => $tahunajar]);
    }

    public function detailsetupPost(Request $request, $id){
        $setup = SetupMataPelajaran::findOrFail($id);
        $tahunajar = TahunAjaran::where('id', $setup->tahun_ajaran_id)->first();

        $globalValidatorData = [
            'jam_pelajaran' => 'required',
            'mata_pelajaran_id' => 'required',
            'kkm' => 'required'
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada data yang sama!');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();
        $Detailada = DetailSetupMataPelajaran::where('tahun_ajaran_id', $tahunajar->id)
            ->where('mata_pelajaran_id', $data['mata_pelajaran_id'])
            ->first();

        if($Detailada){
            Alert::error('Gagal! (E002)', 'Mata pelajaran ini sudah ada dalam setup untuk tahun ajaran ini!');
            return redirect()->back();
        }

        try{
            // Memasukkan ID tahun ajaran aktif ke data yang akan disimpan
            $data['tahun_ajaran_id'] = $tahunajar->id;
            $data['setup_mata_pelajaran_id'] = $setup->id;

            $detail = DetailSetupMataPelajaran::create($data);
        }
        catch(Exception $e){
            Alert::error('Gagal! (E006)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withError($e)->withInput();
        }

        Alert::success('Berhasil', 'Detail Setup Mata Pelajaran berhasil disimpan!');

        return redirect()->route('detail.index', $setup->id)->with('success', 'Detail Setup Mata Pelajaran Berhasil Disimpan');
    }

    public function editdetailsetup($id, $id2){
        $setup = SetupMataPelajaran::findOrFail($id);
        $detail = DetailSetupMataPelajaran::findOrFail($id2);

        $tahunajar = TahunAjaran::where('id', $setup->tahun_ajaran_id)->first();

        $mapel = MataPelajaran::where('tahun_ajaran_id', $tahunajar->id)->get();

        return view('pages.admin.akademik.setupmapel.detail.edit', ['setup' => $setup, 'detail' => $detail, 'mapel' => $mapel,]);
    }

    public function updatedetailsetup(Request $request, $id, $id2){
        $setup = SetupMataPelajaran::findOrFail($id);
        $tahunajar = TahunAjaran::where('id', $setup->tahun_ajaran_id)->first();
        
        $validatedData = Validator::make($request->all(), [
            'jam_pelajaran' => 'required',
            'mata_pelajaran_id' => ['required', Rule::unique('detail_setup_mata_pelajarans', 'mata_pelajaran_id')->where(function ($query) use ($tahunajar, $request) {
                return $query->where('tahun_ajaran_id', $tahunajar->id);
            })->ignore($id2)],
            'kkm' => 'required'
        ]);
    
        if ($validatedData->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode sub kategori yang sama atau nama sub kategori pada kategori pelajaran yang sama!');
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        
        $detail = DetailSetupMataPelajaran::findOrFail($id2);

        $detail->fill([
            'jam_pelajaran' => $request->jam_pelajaran,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'kkm' => $request->kkm,
        ])->save();
    
        Alert::success('Berhasil', 'Detail Setup Mata Pelajaran berhasil diperbarui!');
        return redirect()->route('detail.index', $setup->id)->with('success', 'Detail Setup Mata Pelajaran berhasil diperbarui!');
    }

    public function deletedetailsetup($id, $id2){
        $setup = SetupMataPelajaran::findOrFail($id);
        $detail = DetailSetupMataPelajaran::findOrFail($id2);
        $detail->delete();
        return redirect()->route('detail.index', $setup->id)->with('success', 'Detail Setup Mata Pelajaran berhasil dihapus!');
    }

    public function listsiswa(){
        $siswa = Siswa::all();
        $kelas = Kelas::all();
    
        return view('pages.admin.akademik.siswa.index', ['siswa' => $siswa, 'kelas' => $kelas]);
    }

    public function updatekelassiswa($id){
        $siswa = Siswa::findOrFail($id);
    }
}







