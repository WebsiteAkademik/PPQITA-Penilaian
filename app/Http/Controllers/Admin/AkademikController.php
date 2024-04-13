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
use App\Exports\exportRekapNilai;

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
            'tahun_ajaran' => 'required',
            'semester' => 'required',
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

        $semesterada = TahunAjaran::where('tahun_ajaran', $request->tahun_ajaran)
                    ->where('semester', $request->semester)
                    ->exists();
        
        if($semesterada){
            Alert::error('Gagal! (E008)', 'Tahun Ajaran dengan semester ini sudah ada!');
            return redirect()->back()->withInput();
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
            'tahun_ajaran' => 'required',
            'semester' => 'required',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        // Periksa apakah ada tahun ajaran dan semester yang sama
        $semesterada = TahunAjaran::where('id', '!=', $id)
            ->where('tahun_ajaran', $validatedData['tahun_ajaran'])
            ->where('semester', $validatedData['semester'])
            ->exists();

        if($semesterada){
            Alert::error('Gagal! (E008)', 'Tahun Ajaran dengan semester ini sudah ada!');
            return redirect()->back()->withInput();
        }

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
        $idtahun = TahunAjaran::where('id', $id)->first();
        //Periksa apakah data tahun ajaran digunakan dalam tabel lain
        $tahundipakai = TahunAjaran::withWhereHas('kategoriPelajaran', function ($query) use ($idtahun){
            $query->where('tahun_ajaran_id', $idtahun->id);
        })->exists();
        
        if($tahundipakai){
            Alert::warning('Peringatan!!!', 'Data tahun ajaran tidak dapat dihapus karena telah digunakan pada data lain!');
            return redirect()->back();
        }

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

        $kategoridipakai = KategoriPelajaran::withWhereHas('mataPelajaran', function ($query) use ($kategori) {
            $query->where('kategori_pelajaran_id', $kategori->id);
        })->exists();

        if($kategoridipakai){
            Alert::warning('Peringatan!!!', 'Data kategori pelajaran tidak dapat dihapus karena telah digunakan pada data lain');
            return redirect()->back();
        }

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

        $subkategoridipakai = SubKategoriPelajaran::withWhereHas('mataPelajaran', function ($query) use ($subkategori) {
            $query->where('sub_kategori_pelajaran_id', $subkategori->id);
        })->exists();

        if($subkategoridipakai){
            Alert::warning('Peringatan!!!', 'Data sub kategori pelajaran tidak dapat dihapus karena telah digunakan pada data lain');
            return redirect()->back();
        }

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

        $mapeldipakai = MataPelajaran::whereHas('detailSetupMataPelajaran', function($query) use ($mapel) {
            $query->where('mata_pelajaran_id', $mapel->id);
        })->exists();
        
        if($mapeldipakai){
            Alert::warning('Peringatan!!!', 'Data Mata pelajaran ini tidak dapat dihapus karena telah digunakan pada data lain!');
            return redirect()->back();
        }

        $mapel->delete();
        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil dihapus!');
    }

    //Kelas
    public function listkelas(){
        $kelas = Kelas::all();
    
        return view('pages.admin.akademik.kelas.index', ['kelas' => $kelas]);
    }

    public function showFormkelas(){
        $pengajar = Pengajar::all();

        return view('pages.admin.akademik.kelas.form', ['pengajar' => $pengajar]);
    }

    public function kelasPost(Request $request){
        $globalValidatorData = [
            'kelas' => 'required|unique:kelas,kelas',
            'pengajar_id' => 'required',
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada data yang sama!');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $pengajarada = Kelas::where('pengajar_id', $request->pengajar_id)
                    ->exists();
        
        if($pengajarada){
            Alert::error('Gagal! (E010)', 'Pengajar telah menjadi wali kelas dari kelas lain!');
            return redirect()->back()->withInput();
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

        $pengajar = Pengajar::all();
    
        return view('pages.admin.akademik.kelas.edit', ['pengajar' => $pengajar, 'kelas' => $kelas]);
    }

    public function updatekelas(Request $request, $id){
        $kelas = Kelas::findOrFail($id);

        // Validasi data yang diupdate
        $validatedData = $request->validate([
            'kelas' => ['required', Rule::unique('kelas', 'kelas')->ignore($id)],
            'pengajar_id' => 'required',
        ]);

        $pengajarada = Kelas::where('id', '!=', $id)
                    ->where('pengajar_id', $validatedData['pengajar_id'])
                    ->exists();
        
        if($pengajarada){
            Alert::error('Gagal! (E010)', 'Pengajar telah menjadi wali kelas dari kelas lain!');
            return redirect()->back()->withInput();
        }

        // Update data Kelas
        try {
            $kelas->update($validatedData);
            return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbaharui!');
        } catch (\Exception $e) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan validasi data benar!');
            return redirect()->back()->withInput();
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
            'username' => 'required|alpha_dash|unique:users,email',
            'password' => 'required'
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Terdapat username yang sama dalam database, ganti username lain!');
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

        $pengajardipakai = Pengajar::withWhereHas('setupMataPelajaran', function ($query) use ($pengajar) {
            $query->where('pengajar_id', $pengajar->id);
        })->exists();

        if($pengajardipakai){
            Alert::warning('Peringatan!!!', 'Data pengajar tidak dapat dihapus karena telah digunakan pada data lain!');
            return redirect()->back();
        }
        
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

            // Mengecek apakah terdapat setup mata pelajaran yang sama pada tahun ajaran aktif yang sama
            $setupSama = SetupMataPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->where('kelas_id', $data['kelas_id'])
                ->where('pengajar_id', $data['pengajar_id'])
                ->first();

            if ($setupSama) {
                Alert::error('Gagal! (E002)', 'Setup dengan ketentuan yang sama sudah ada!');
                return redirect()->back()->withInput();
            }

            $setup = SetupMataPelajaran::create($data);
            Alert::success('Berhasil', 'Setup Mata Pelajaran berhasil disimpan!');
            return redirect()->route('detail.index', $setup->id)->with('success', 'Setup Mata Pelajaran berhasil disimpan!');

        }
        catch(\Exception $e){
            Alert::error('Gagal! (E006)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withError($e)->withInput();
        }

        Alert::success('Berhasil', 'Setup Mata Pelajaran berhasil disimpan!');

        return redirect()->route('detail.index', $setup->id)->with('success', 'Setup Mata Pelajaran berhasil disimpan!');

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
        $kelas = Kelas::where('id', $setup->kelas_id)->first();
        $pengajar = Pengajar::where('id', $setup->pengajar_id)->first();

        $globalValidatorData = [
            'jam_pelajaran' => 'required',
            'mata_pelajaran_id' => 'required',
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada data yang sama!');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();
        $Detailada = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunajar, $kelas) {
                $query->where('tahun_ajaran_id', $tahunajar->id)
                ->where('kelas_id', $kelas->id);
            })
            ->where('mata_pelajaran_id', $data['mata_pelajaran_id'])
            ->first();
        
        $mapel = MataPelajaran::where('id', $data['mata_pelajaran_id'])->first();

        if($Detailada){
            Alert::error('Gagal! (E002)', 'Mata pelajaran ini sudah ada dalam setup untuk tahun ajaran dan kelas ini!');
            return redirect()->back();
        }

        try{
            // Memasukkan ID tahun ajaran aktif ke data yang akan disimpan
            $data['tahun_ajaran_id'] = $tahunajar->id;
            $data['setup_mata_pelajaran_id'] = $setup->id;
            $data['kkm'] = $mapel->kkm;

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
        $kelas = Kelas::where('id', $setup->kelas_id)->first();
        
        $validatedData = Validator::make($request->all(), [
            'jam_pelajaran' => 'required',
            'mata_pelajaran_id' => 'required',
            'kkm' => 'required'
        ]);
    
        if ($validatedData->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode sub kategori yang sama atau nama sub kategori pada kategori pelajaran yang sama!');
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        
        $Detailada = DetailSetupMataPelajaran::whereHas('setupMataPelajaran', function($query) use ($tahunajar, $kelas) {
            $query->where('tahun_ajaran_id', $tahunajar->id)
                  ->where('kelas_id', $kelas->id);
        })
        ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
        ->where('id', '!=', $id2)
        ->first();
    
        if ($Detailada) {
            Alert::error('Gagal! (E002)', 'Mata pelajaran ini sudah ada dalam setup untuk tahun ajaran dan kelas yang sama!');
            return redirect()->back();
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

    public function editsiswaprofile($id){
        $siswa = Siswa::findOrFail($id);
    
        return view('pages.admin.akademik.siswa.edit', ['siswa' => $siswa]);
    }

    public function updatesiswaprofile(Request $request, $id){
        $siswa = Siswa::findOrFail($id);

        $globalValidatorData = [
            "no_nisn" => "required",
            "nama_siswa" => "required",
            "tempat_lahir" => "required",
            "tanggal_lahir" => "required",
            "jenis_kelamin" => "required",
            "no_kartu_keluarga" => "required",
            "no_induk_keluarga" => "required",
            "agama" => "required",
            "tinggi_badan" => "required",
            "berat_badan" => "required",
            "no_wa_anak" => "required",
            "penyakit_kronis" => "required",
            "alamat_rumah" => "required",
            "dukuh" => "required",
            "kelurahan" => "required",
            "kecamatan" => "required",
            "kabupaten" => "required",
            "kodepos" => "required",
            "asal_sekolah" => "required",
            "no_telepon_ortu" => "required",
        ];

        $ayahValidatorData = array_replace([], $globalValidatorData, [
            "nama_ayah" => "required",
            "pekerjaan_ayah" => "required",
        ]);

        $ibuValidatorData = array_replace([], $globalValidatorData, [
            "nama_ibu" => "required",
            "pekerjaan_ibu" => "required",
        ]);

        $bothValidatorData = array_replace([], $globalValidatorData, [
            "nama_ayah" => "required",
            "pekerjaan_ayah" => "required",
            "nama_ibu" => "required",
            "pekerjaan_ibu" => "required",
        ]);

        $globalValidator = Validator::make($request->all(), $globalValidatorData);
        $ayahValidator = Validator::make($request->all(), $ayahValidatorData);
        $ibuValidator = Validator::make($request->all(), $ibuValidatorData);
        $bothValidator = Validator::make($request->all(), $bothValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek pada form profile apakah ada kesalahan yang terjadi');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();
        $data['ayah_hidup'] = $request->has('ayah_hidup') ? ($request->all()["ayah_hidup"] == "1") : false;
        $data['ibu_hidup'] = $request->has('ibu_hidup') ? ($request->all()["ibu_hidup"] == "1") : false;
        $data['nama_ayah'] = "";
        $data['nama_ibu'] = "";
        $data['pekerjaan_ayah'] = "";
        $data['pekerjaan_ibu'] = "";

        if($data['ayah_hidup'] && $data['ibu_hidup']){
            if ($bothValidator->fails()) {
                Alert::error('Gagal! (E002)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
                return redirect()->back()->withErrors($bothValidator)->withInput();
            } else {
                $data['nama_ayah'] = $request->all()["nama_ayah"];
                $data['nama_ibu'] = $request->all()["nama_ibu"];
                $data['pekerjaan_ayah'] = $request->all()["pekerjaan_ayah"];
                $data['pekerjaan_ibu'] = $request->all()["pekerjaan_ibu"];
            }
        } elseif ($data["ayah_hidup"]) {
            if ($ayahValidator->fails()) {
                Alert::error('Gagal! (E003)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
                return redirect()->back()->withErrors($ayahValidator)->withInput();
            } else {
                $data['nama_ayah'] = $request->all()["nama_ayah"];
                $data['pekerjaan_ayah'] = $request->all()["pekerjaan_ayah"];
            }
        } elseif ($data["ibu_hidup"]) {
            if ($ibuValidator->fails()) {
                Alert::error('Gagal! (E004)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
                return redirect()->back()->withErrors($ibuValidator)->withInput();
            } else {
                $data['nama_ibu'] = $request->all()["nama_ibu"];
                $data['pekerjaan_ibu'] = $request->all()["pekerjaan_ibu"];
            }
        }

        $noNisnValid = Siswa::where('id', '!=', $siswa->id)->where('no_nisn', $data['no_nisn'])->count();
        if($noNisnValid != 0){
            Alert::error('Gagal! (E005)', 'NISN sudah terdaftar');
            return redirect()->back()->withInput();
        }

        $newData = [];
        foreach ($siswa->toArray() as $key => $value) {
            if(isset($data[$key])){
                if($value != $data[$key])
                    $newData[$key] = $data[$key];
            }
        }
        try{
            $siswa->update($newData);

            Alert::success('Berhasil', 'Data Profil Siswa berhasil diperbarui!');    
            return redirect()->route('siswa.index');
        }
        catch(Exception $e){
            Alert::error('Gagal! (E006)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withError($e)->withInput();
        }
    }

    public function updatekelassiswa(Request $request, $id){
        $validatedData = Validator::make($request->all(), [
            'kelas_id' => 'required',
        ]);

        $siswa = Siswa::findOrFail($id);

        $siswa->fill([
            'kelas_id' => $request->kelas_id,
        ])->save();

        Alert::success('Berhasil', 'Kelas Siswa berhasil diperbarui!');
        return redirect()->back();
    }

    //Rekap Penilaian
    public function listrekappenilaianpelajaran(){
        $kelas = Kelas::all();
    
        return view('pages.admin.akademik.rekappenilaian.listrekappenilaianpelajaran', ['kelas' => $kelas]);
    }

    public function indexrekappenilaianpelajaran($id){
        $tahunajar = TahunAjaran::where('status', 'aktif')->first();
        $kelas = Kelas::findOrFail($id);

        $setup = SetupMataPelajaran::where('tahun_ajaran_id', $tahunajar->id)->where('kelas_id', $kelas->id)->get();
        $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunajar, $kelas) {
            $query->where('tahun_ajaran_id', $tahunajar->id)
            ->where('kelas_id', $kelas->id);
        })->get();

        $subTahfidz = SubKategoriPelajaran::where('nama_sub_kategori', 'Tahfidz')->first();

        $mapel = collect();

        foreach($detail as $d){
            $mapelTahfidz = MataPelajaran::where('id', $d->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subTahfidz->id)
                ->first();
            if(!$mapelTahfidz){
                $mapel->push(MataPelajaran::where('id', $d->mata_pelajaran_id)->first());
            }
        }

        // Ambil siswa sesuai kelas dan nilai sesuai dengan mata pelajaran yang ada
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();
        $rekapNilai = [];

        foreach ($siswa as $s) {
            $nilaiSiswa = [];

            foreach ($mapel as $mapelItem) {
                // Penilaian pelajaran umum, bukan tahfidz atau dinniyah
                $nilai = PenilaianPelajaran::where('siswa_id', $s->id)
                    ->where('mata_pelajaran_id', $mapelItem->id)
                    ->avg('nilai');

                $nilaiSiswa[] = [
                    'mapel' => $mapelItem,
                    'nilai' => number_format($nilai, 2),
                ];
            }

            $rekapNilai[] = [
                'siswa' => $s,
                'nilai' => $nilaiSiswa,
            ];
        }

        return view('pages.admin.akademik.rekappenilaian.rekappenilaianpelajaran', ['kelas' => $kelas, 'tahunajar' => $tahunajar, 'mapel' => $mapel, 'rekapNilai' => $rekapNilai]);
    }

    public function export_rekappenilaianpelajaran($id){
        $kelas = Kelas::findOrFail($id);
        $tahunajar = TahunAjaran::where('status', 'aktif')->first();

        $setup = SetupMataPelajaran::where('tahun_ajaran_id', $tahunajar->id)->where('kelas_id', $kelas->id)->get();
        $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunajar, $kelas) {
            $query->where('tahun_ajaran_id', $tahunajar->id)
            ->where('kelas_id', $kelas->id);
        })->get();

        $subTahfidz = SubKategoriPelajaran::where('nama_sub_kategori', 'Tahfidz')->first();

        $mapel = collect();

        foreach($detail as $d){
            $mapelTahfidz = MataPelajaran::where('id', $d->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subTahfidz->id)
                ->first();
            if(!$mapelTahfidz){
                $mapel->push(MataPelajaran::where('id', $d->mata_pelajaran_id)->first());
            }
        }

        // Ambil siswa sesuai kelas dan nilai sesuai dengan mata pelajaran yang ada
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();
        $rekapNilai = [];

        foreach ($siswa as $s) {
            $nilaiSiswa = [];

            foreach ($mapel as $mapelItem) {
                // Penilaian pelajaran umum, bukan tahfidz atau dinniyah
                $nilai = PenilaianPelajaran::where('siswa_id', $s->id)
                    ->where('mata_pelajaran_id', $mapelItem->id)
                    ->avg('nilai');

                $nilaiSiswa[] = [
                    'mapel' => $mapelItem,
                    'nilai' => number_format($nilai, 2),
                ];
            }

            $rekapNilai[] = [
                'siswa' => $s,
                'nilai' => $nilaiSiswa,
            ];
        }

        $totalRataRataKelas = 0;
		$totalSiswa = count($rekapNilai);
		foreach($rekapNilai as $rekap){
			foreach($rekap['nilai'] as $nilai){
				$totalRataRataKelas += $nilai['nilai'];
			}
		}
		$rataRataKelas = $totalSiswa > 0 ? $totalRataRataKelas / ($totalSiswa * count($mapel)) : 0;

        $rekapNilai = collect($rekapNilai);

        $export = new ExportRekapNilai($rekapNilai, $mapel, $rataRataKelas);

        return Excel::download($export, 'Rekap_Penilaian_Pelajaran_Kelas_'.$kelas->kelas.'.xlsx');
    }

    public function cetak_rekappenilaianpelajaran($id){
        $kelas = Kelas::findOrFail($id);
        $tahunajar = TahunAjaran::where('status', 'aktif')->first();

        $setup = SetupMataPelajaran::where('tahun_ajaran_id', $tahunajar->id)->where('kelas_id', $kelas->id)->get();
        $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunajar, $kelas) {
            $query->where('tahun_ajaran_id', $tahunajar->id)
            ->where('kelas_id', $kelas->id);
        })->get();

        $subTahfidz = SubKategoriPelajaran::where('nama_sub_kategori', 'Tahfidz')->first();

        $mapel = collect();

        foreach($detail as $d){
            $mapelTahfidz = MataPelajaran::where('id', $d->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subTahfidz->id)
                ->first();
            if(!$mapelTahfidz){
                $mapel->push(MataPelajaran::where('id', $d->mata_pelajaran_id)->first());
            }
        }

        // Ambil siswa sesuai kelas dan nilai sesuai dengan mata pelajaran yang ada
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();
        $rekapNilai = [];

        foreach ($siswa as $s) {
            $nilaiSiswa = [];

            foreach ($mapel as $mapelItem) {
                // Penilaian pelajaran umum, bukan tahfidz atau dinniyah
                $nilai = PenilaianPelajaran::where('siswa_id', $s->id)
                    ->where('mata_pelajaran_id', $mapelItem->id)
                    ->avg('nilai');

                $nilaiSiswa[] = [
                    'mapel' => $mapelItem,
                    'nilai' => number_format($nilai, 2),
                ];
            }

            $rekapNilai[] = [
                'siswa' => $s,
                'nilai' => $nilaiSiswa,
            ];
        }

        $pdf = PDF::loadView('pages.admin.akademik.rekappenilaian.cetakpenilaianpelajaran', ['kelas' => $kelas, 'tahunajar' => $tahunajar, 'mapel' => $mapel, 'rekapNilai' => $rekapNilai]);
        return $pdf->stream('Rekap Penilaian Pelajaran Kelas '.$kelas->kelas.'.pdf');
    }

    public function listrekappenilaiantahfidz(){
        $kelas = Kelas::all();
    
        return view('pages.admin.akademik.rekappenilaian.listrekappenilaiantahfidz', ['kelas' => $kelas]);
    }

    public function indexrekappenilaiantahfidz($id){
        $tahunajar = TahunAjaran::where('status', 'aktif')->first();
        $kelas = Kelas::findOrFail($id);

        $setup = SetupMataPelajaran::where('tahun_ajaran_id', $tahunajar->id)->where('kelas_id', $kelas->id)->get();
        $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunajar, $kelas) {
            $query->where('tahun_ajaran_id', $tahunajar->id)
            ->where('kelas_id', $kelas->id);
        })->get();

        $subTahfidz = SubKategoriPelajaran::where('nama_sub_kategori', 'Tahfidz')->first();

        $mapel = collect();

        foreach($detail as $d){
            $mapelTahfidz = MataPelajaran::where('id', $d->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subTahfidz->id)
                ->first();
            if($mapelTahfidz){
                $mapel->push(MataPelajaran::where('id', $d->mata_pelajaran_id)->first());
            }
        }

        // Ambil siswa sesuai kelas dan nilai sesuai dengan mata pelajaran yang ada
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();
        $rekapNilai = [];

        foreach ($siswa as $s) {
            $nilaiSiswa = [];

            foreach ($mapel as $mapelItem) {
                // Penilaian pelajaran umum, bukan tahfidz atau dinniyah
                $nilai = PenilaianTahfidz::where('siswa_id', $s->id)
                    ->where('mata_pelajaran_id', $mapelItem->id)
                    ->avg('nilai');

                $nilaiSiswa[] = [
                    'mapel' => $mapelItem,
                    'nilai' => number_format($nilai, 2),
                ];
            }

            $rekapNilai[] = [
                'siswa' => $s,
                'nilai' => $nilaiSiswa,
            ];
        }

        return view('pages.admin.akademik.rekappenilaian.rekappenilaiantahfidz', ['kelas' => $kelas, 'tahunajar' => $tahunajar, 'mapel' => $mapel, 'rekapNilai' => $rekapNilai]);
    }

    public function export_rekappenilaiantahfidz($id){
        $kelas = Kelas::findOrFail($id);
        $tahunajar = TahunAjaran::where('status', 'aktif')->first();

        $setup = SetupMataPelajaran::where('tahun_ajaran_id', $tahunajar->id)->where('kelas_id', $kelas->id)->get();
        $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunajar, $kelas) {
            $query->where('tahun_ajaran_id', $tahunajar->id)
            ->where('kelas_id', $kelas->id);
        })->get();

        $subTahfidz = SubKategoriPelajaran::where('nama_sub_kategori', 'Tahfidz')->first();

        $mapel = collect();

        foreach($detail as $d){
            $mapelTahfidz = MataPelajaran::where('id', $d->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subTahfidz->id)
                ->first();
            if($mapelTahfidz){
                $mapel->push(MataPelajaran::where('id', $d->mata_pelajaran_id)->first());
            }
        }

        // Ambil siswa sesuai kelas dan nilai sesuai dengan mata pelajaran yang ada
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();
        $rekapNilai = [];

        foreach ($siswa as $s) {
            $nilaiSiswa = [];

            foreach ($mapel as $mapelItem) {
                // Penilaian pelajaran umum, bukan tahfidz atau dinniyah
                $nilai = PenilaianTahfidz::where('siswa_id', $s->id)
                    ->where('mata_pelajaran_id', $mapelItem->id)
                    ->avg('nilai');

                $nilaiSiswa[] = [
                    'mapel' => $mapelItem,
                    'nilai' => number_format($nilai, 2),
                ];
            }

            $rekapNilai[] = [
                'siswa' => $s,
                'nilai' => $nilaiSiswa,
            ];
        }

        $totalRataRataKelas = 0;
		$totalSiswa = count($rekapNilai);
		foreach($rekapNilai as $rekap){
			foreach($rekap['nilai'] as $nilai){
				$totalRataRataKelas += $nilai['nilai'];
			}
		}
		$rataRataKelas = $totalSiswa > 0 ? $totalRataRataKelas / ($totalSiswa * count($mapel)) : 0;

        $rekapNilai = collect($rekapNilai);

        $export = new ExportRekapNilai($rekapNilai, $mapel, $rataRataKelas);

        return Excel::download($export, 'Rekap_Penilaian_Tahfidz_Kelas_'.$kelas->kelas.'.xlsx');
    }

    public function cetak_rekappenilaiantahfidz($id){
        $kelas = Kelas::findOrFail($id);
        $tahunajar = TahunAjaran::where('status', 'aktif')->first();

        $setup = SetupMataPelajaran::where('tahun_ajaran_id', $tahunajar->id)->where('kelas_id', $kelas->id)->get();
        $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunajar, $kelas) {
            $query->where('tahun_ajaran_id', $tahunajar->id)
            ->where('kelas_id', $kelas->id);
        })->get();

        $subTahfidz = SubKategoriPelajaran::where('nama_sub_kategori', 'Tahfidz')->first();

        $mapel = collect();

        foreach($detail as $d){
            $mapelTahfidz = MataPelajaran::where('id', $d->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subTahfidz->id)
                ->first();
            if($mapelTahfidz){
                $mapel->push(MataPelajaran::where('id', $d->mata_pelajaran_id)->first());
            }
        }

        // Ambil siswa sesuai kelas dan nilai sesuai dengan mata pelajaran yang ada
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();
        $rekapNilai = [];

        foreach ($siswa as $s) {
            $nilaiSiswa = [];

            foreach ($mapel as $mapelItem) {
                // Penilaian pelajaran umum, bukan tahfidz atau dinniyah
                $nilai = PenilaianTahfidz::where('siswa_id', $s->id)
                    ->where('mata_pelajaran_id', $mapelItem->id)
                    ->avg('nilai');

                $nilaiSiswa[] = [
                    'mapel' => $mapelItem,
                    'nilai' => number_format($nilai, 2),
                ];
            }

            $rekapNilai[] = [
                'siswa' => $s,
                'nilai' => $nilaiSiswa,
            ];
        }

        $pdf = PDF::loadView('pages.admin.akademik.rekappenilaian.cetakpenilaiantahfidz', ['kelas' => $kelas, 'tahunajar' => $tahunajar, 'mapel' => $mapel, 'rekapNilai' => $rekapNilai]);
        return $pdf->stream('Rekap Penilaian Tahfidz Kelas'. $kelas->kelas .'.pdf');
    }

    //Rekap Rapor
    public function listrekapraporuas(){
        $kelas = Kelas::all();
    
        return view('pages.admin.akademik.rapor.rekapraporuas', ['kelas' => $kelas]);
    }

    public function indexrekapraporuas($id){
        $tahunajar = TahunAjaran::where('status', 'aktif')->first();
        $kelas = Kelas::findOrFail($id);

        $siswa = Siswa::where('kelas_id', $kelas->id)->get();
    
        return view('pages.admin.akademik.rapor.raporuas', ['kelas' => $kelas, 'siswa' => $siswa, 'tahunajar' => $tahunajar]);
    }

    public function cetak_raporuas($id){
        $siswa = Siswa::findorfail($id);
        $tahunajar = TahunAjaran::where('status', 'aktif')->first();
        $kelas = Kelas::where('id', $siswa->kelas_id)->first();

        $setup = SetupMataPelajaran::where('tahun_ajaran_id', $tahunajar->id)->where('kelas_id', $kelas->id)->get();
        $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunajar, $kelas) {
            $query->where('tahun_ajaran_id', $tahunajar->id)
            ->where('kelas_id', $kelas->id);
        })->get();

        $subTahfidz = SubKategoriPelajaran::where('nama_sub_kategori', 'Tahfidz')->first();
        $subDinniyah = SubKategoriPelajaran::where('nama_sub_kategori', 'Dinniyah')->first();

        $mapelumum = collect();
        $mapeltahfidz = collect();
        $mapeldinniyah = collect();

        foreach ($detail as $detail) {
            $mapelTahfidz = MataPelajaran::where('id', $detail->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subTahfidz->id)
                ->first();
            $mapelDinniyah = MataPelajaran::where('id', $detail->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subDinniyah->id)
                ->first();
            if(!$mapelTahfidz && !$mapelDinniyah){
                $mapelumum->push(MataPelajaran::where('id', $detail->mata_pelajaran_id)->first());
            }
            if ($mapelDinniyah) {
                $mapeldinniyah->push(MataPelajaran::where('id', $detail->mata_pelajaran_id)->first());
            }
            if ($mapelTahfidz) {
                $mapeltahfidz->push(MataPelajaran::where('id', $detail->mata_pelajaran_id)->first());
            }
        }

        $penilaianumum = [];
        $nilaiumum_kelas = [];

        foreach ($mapelumum as $mapel) {
            $nilaiumum_kelas[$mapel->id] = PenilaianPelajaran::where('mata_pelajaran_id', $mapel->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->avg('nilai');
        }

        foreach ($mapelumum as $mapel) {
            $penilaian = PenilaianPelajaran::where('mata_pelajaran_id', $mapel->id)
                ->where('siswa_id', $siswa->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->get();
            
            // Hitung rata-rata nilai jika ada penilaian
            $nilai_rata_rata = number_format($penilaian->avg('nilai'), 2);

            $keterangan = $penilaian->isEmpty() ? '' : $penilaian->first()->keterangan;
        
            // Tentukan deskripsi berdasarkan kondisi nilai
            if ($nilai_rata_rata >= $mapel->kkm && $nilai_rata_rata > ($nilaiumum_kelas[$mapel->id] ?? 0)) {
                $keterangan = 'Terlampaui';
            }

            // Tambahkan data penilaian ke array penilaian umum
            $penilaianumum[] = [
                'mapel' => $mapel,
                'nilai' => $nilai_rata_rata,
                'keterangan' => $keterangan,
            ];
        }

        $penilaiandinniyah = [];
        $nilaidinniyah_kelas = [];

        foreach ($mapeldinniyah as $mapel) {
            $nilaidinniyah_kelas[$mapel->id] = PenilaianPelajaran::where('mata_pelajaran_id', $mapel->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->avg('nilai');
        }

        foreach ($mapeldinniyah as $mapel) {
            $penilaian = PenilaianPelajaran::where('mata_pelajaran_id', $mapel->id)
                ->where('siswa_id', $siswa->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->get();
            
            // Hitung rata-rata nilai jika ada penilaian
            $nilai_rata_rata = number_format($penilaian->avg('nilai'), 2);

            $keterangan = $penilaian->isEmpty() ? '' : $penilaian->first()->keterangan;
        
            // Tentukan deskripsi berdasarkan kondisi nilai
            if ($nilai_rata_rata >= $mapel->kkm && $nilai_rata_rata > ($nilaidinniyah_kelas[$mapel->id] ?? 0)) {
                $keterangan = 'Terlampaui';
            }

            // Tambahkan data penilaian ke array penilaian umum
            $penilaiandinniyah[] = [
                'mapel' => $mapel,
                'nilai' => $nilai_rata_rata,
                'keterangan' => $keterangan,
            ];
        }

        $penilaiantahfidz = [];
        $nilaitahfidz_kelas = [];

        foreach ($mapeltahfidz as $mapel) {
            $nilaitahfidz_kelas[$mapel->id] = PenilaianTahfidz::where('mata_pelajaran_id', $mapel->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->avg('nilai');
        }

        foreach ($mapeltahfidz as $mapel) {
            $penilaian = PenilaianTahfidz::where('mata_pelajaran_id', $mapel->id)
                ->where('siswa_id', $siswa->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->get();
            
            // Hitung rata-rata nilai jika ada penilaian
            $nilai_rata_rata = number_format($penilaian->avg('nilai'), 2);

            $keterangan = $penilaian->isEmpty() ? '' : $penilaian->first()->keterangan;
        
            // Tentukan deskripsi berdasarkan kondisi nilai
            if ($nilai_rata_rata >= $mapel->kkm && $nilai_rata_rata > ($nilaitahfidz_kelas[$mapel->id] ?? 0)) {
                $keterangan = 'Terlampaui';
            }

            // Tambahkan data penilaian ke array penilaian umum
            $penilaiantahfidz[] = [
                'mapel' => $mapel,
                'nilai' => $nilai_rata_rata,
                'keterangan' => $keterangan,
            ];
        }

        // Menggabungkan semua penilaian menjadi satu array
        $semuaPenilaian = array_merge($penilaianumum, $penilaiantahfidz, $penilaiandinniyah);

        $nilaitotal_umum = 0;
        $count_nilaitotal_umum = 0;

        foreach ($semuaPenilaian as $penilaian) {
            $nilaitotal_umum += $penilaian['nilai'];
            $count_nilaitotal_umum++;
        }

        if ($count_nilaitotal_umum > 0) {
            $nilai_rata_rata_total = number_format($nilaitotal_umum / $count_nilaitotal_umum, 2);
        } else {
            $nilai_rata_rata_total = 0; // Ini opsional, sesuai kebutuhan aplikasi Anda
        }

        $rapor = PDF::loadView  ('pages.admin.akademik.rapor.cetakraporuas', ['siswa' => $siswa, 'kelas' => $kelas, 'tahunajar' => $tahunajar, 'nilaitotal_umum' => $nilaitotal_umum, 'nilai_rata_rata_total' => $nilai_rata_rata_total, 'nilaiumum_kelas' => $nilaiumum_kelas, 'nilaitahfidz_kelas' => $nilaitahfidz_kelas, 'nilaidinniyah_kelas' => $nilaidinniyah_kelas, 'penilaiantahfidz' => $penilaiantahfidz, 'penilaiandinniyah' => $penilaiandinniyah, 'penilaianumum' => $penilaianumum])->setPaper('A4', 'portrait');
        return $rapor->stream('rapor_{{ $siswa->no_nisn }}.pdf');
    }

    public function listrekapraporuts(){
        $kelas = Kelas::all();
    
        return view('pages.admin.akademik.rapor.rekapraporuts', ['kelas' => $kelas]);
    }

    public function indexrekapraporuts($id){
        $tahunajar = TahunAjaran::where('status', 'aktif')->first();
        $kelas = Kelas::findOrFail($id);

        $siswa = Siswa::where('kelas_id', $kelas->id)->get();
    
        return view('pages.admin.akademik.rapor.raporuts', ['kelas' => $kelas, 'siswa' => $siswa, 'tahunajar' => $tahunajar]);
    }

    public function cetak_raporuts($id){
        $siswa = Siswa::findorfail($id);
        $tahunajar = TahunAjaran::where('status', 'aktif')->first();
        $kelas = Kelas::where('id', $siswa->kelas_id)->first();

        $setup = SetupMataPelajaran::where('tahun_ajaran_id', $tahunajar->id)->where('kelas_id', $kelas->id)->get();
        $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunajar, $kelas) {
            $query->where('tahun_ajaran_id', $tahunajar->id)
            ->where('kelas_id', $kelas->id);
        })->get();

        $subTahfidz = SubKategoriPelajaran::where('nama_sub_kategori', 'Tahfidz')->first();
        $subDinniyah = SubKategoriPelajaran::where('nama_sub_kategori', 'Dinniyah')->first();

        $mapelumum = collect();
        $mapeltahfidz = collect();
        $mapeldinniyah = collect();

        foreach ($detail as $detail) {
            $mapelTahfidz = MataPelajaran::where('id', $detail->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subTahfidz->id)
                ->first();
            $mapelDinniyah = MataPelajaran::where('id', $detail->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subDinniyah->id)
                ->first();
            if(!$mapelTahfidz && !$mapelDinniyah){
                $mapelumum->push(MataPelajaran::where('id', $detail->mata_pelajaran_id)->first());
            }
            if ($mapelDinniyah) {
                $mapeldinniyah->push(MataPelajaran::where('id', $detail->mata_pelajaran_id)->first());
            }
            if ($mapelTahfidz) {
                $mapeltahfidz->push(MataPelajaran::where('id', $detail->mata_pelajaran_id)->first());
            }
        }

        $penilaianumum = [];
        $nilaiumum_kelas = [];

        foreach ($mapelumum as $mapel) {
            $nilaiumum_kelas[$mapel->id] = PenilaianPelajaran::where('mata_pelajaran_id', $mapel->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->where('jenis_ujian', 'UTS')
                ->avg('nilai');
        }

        foreach ($mapelumum as $mapel) {
            $penilaian = PenilaianPelajaran::where('mata_pelajaran_id', $mapel->id)
                ->where('siswa_id', $siswa->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->where('jenis_ujian', 'UTS')
                ->get();
            
            // Hitung rata-rata nilai jika ada penilaian
            $nilai_rata_rata = number_format($penilaian->avg('nilai'), 2);

            $keterangan = $penilaian->isEmpty() ? '' : $penilaian->first()->keterangan;
        
            // Tentukan deskripsi berdasarkan kondisi nilai
            if ($nilai_rata_rata >= $mapel->kkm && $nilai_rata_rata > ($nilaiumum_kelas[$mapel->id] ?? 0)) {
                $keterangan = 'Terlampaui';
            }

            // Tambahkan data penilaian ke array penilaian umum
            $penilaianumum[] = [
                'mapel' => $mapel,
                'nilai' => $nilai_rata_rata,
                'keterangan' => $keterangan,
            ];
        }

        $penilaiandinniyah = [];
        $nilaidinniyah_kelas = [];

        foreach ($mapeldinniyah as $mapel) {
            $nilaidinniyah_kelas[$mapel->id] = PenilaianPelajaran::where('mata_pelajaran_id', $mapel->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->where('jenis_ujian', 'UTS')
                ->avg('nilai');
        }

        foreach ($mapeldinniyah as $mapel) {
            $penilaian = PenilaianPelajaran::where('mata_pelajaran_id', $mapel->id)
                ->where('siswa_id', $siswa->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->where('jenis_ujian', 'UTS')
                ->get();
            
            // Hitung rata-rata nilai jika ada penilaian
            $nilai_rata_rata = number_format($penilaian->avg('nilai'), 2);

            $keterangan = $penilaian->isEmpty() ? '' : $penilaian->first()->keterangan;
        
            // Tentukan deskripsi berdasarkan kondisi nilai
            if ($nilai_rata_rata >= $mapel->kkm && $nilai_rata_rata > ($nilaidinniyah_kelas[$mapel->id] ?? 0)) {
                $keterangan = 'Terlampaui';
            }

            // Tambahkan data penilaian ke array penilaian umum
            $penilaiandinniyah[] = [
                'mapel' => $mapel,
                'nilai' => $nilai_rata_rata,
                'keterangan' => $keterangan,
            ];
        }

        $penilaiantahfidz = [];
        $nilaitahfidz_kelas = [];

        foreach ($mapeltahfidz as $mapel) {
            $nilaitahfidz_kelas[$mapel->id] = PenilaianTahfidz::where('mata_pelajaran_id', $mapel->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->avg('nilai');
        }

        foreach ($mapeltahfidz as $mapel) {
            $penilaian = PenilaianTahfidz::where('mata_pelajaran_id', $mapel->id)
                ->where('siswa_id', $siswa->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->get();
            
            // Hitung rata-rata nilai jika ada penilaian
            $nilai_rata_rata = number_format($penilaian->avg('nilai'), 2);

            $keterangan = $penilaian->isEmpty() ? '' : $penilaian->first()->keterangan;
        
            // Tentukan deskripsi berdasarkan kondisi nilai
            if ($nilai_rata_rata >= $mapel->kkm && $nilai_rata_rata > ($nilaitahfidz_kelas[$mapel->id] ?? 0)) {
                $keterangan = 'Terlampaui';
            }

            // Tambahkan data penilaian ke array penilaian umum
            $penilaiantahfidz[] = [
                'mapel' => $mapel,
                'nilai' => $nilai_rata_rata,
                'keterangan' => $keterangan,
            ];
        }

        // Menggabungkan semua penilaian menjadi satu array
        $semuaPenilaian = array_merge($penilaianumum, $penilaiantahfidz, $penilaiandinniyah);

        $nilaitotal_umum = 0;
        $count_nilaitotal_umum = 0;

        foreach ($semuaPenilaian as $penilaian) {
            $nilaitotal_umum += $penilaian['nilai'];
            $count_nilaitotal_umum++;
        }

        if ($count_nilaitotal_umum > 0) {
            $nilai_rata_rata_total = number_format($nilaitotal_umum / $count_nilaitotal_umum, 2);
        } else {
            $nilai_rata_rata_total = 0; // Ini opsional, sesuai kebutuhan aplikasi Anda
        }

        $rapor = PDF::loadView  ('pages.admin.akademik.rapor.cetakraporuts', ['siswa' => $siswa, 'kelas' => $kelas, 'tahunajar' => $tahunajar, 'nilaitotal_umum' => $nilaitotal_umum, 'nilai_rata_rata_total' => $nilai_rata_rata_total, 'nilaiumum_kelas' => $nilaiumum_kelas, 'nilaitahfidz_kelas' => $nilaitahfidz_kelas, 'nilaidinniyah_kelas' => $nilaidinniyah_kelas, 'penilaiantahfidz' => $penilaiantahfidz, 'penilaiandinniyah' => $penilaiandinniyah, 'penilaianumum' => $penilaianumum])->setPaper('A4', 'portrait');
        return $rapor->stream('rapor-uts_{{ $siswa->no_nisn }}.pdf');
    }
}