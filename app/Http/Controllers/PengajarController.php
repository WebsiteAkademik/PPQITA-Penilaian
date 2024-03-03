<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PenilaianPelajaran;
use App\Models\PenilaianTahfidz;
use App\Models\TahunAjaran;
use App\Models\KategoriPelajaran;
use App\Models\SubKategoriPelajaran;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\SetupMataPelajaran;
use App\Models\DetailSetupMataPelajaran;
use App\Models\Pengajar;
use App\Models\Siswa;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PengajarController extends Controller
{
    // Penilaian Tahfidz
    public function listpenilaiantahfidz(){
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.pengajaradmin.penilaiantahfidz.index', ['penilaiantahfidz' => []]);
        }

        $penilaiantahfidz = PenilaianTahfidz::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
        
        return view('pages.admin.pengajaradmin.penilaiantahfidz.index', ['penilaiantahfidz' => $penilaiantahfidz]);
    }

    // public function showFormpenilaiantahfidz(){
    //     $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

    //     if (!$tahunAjaranAktif) {
    //         return view('pages.admin.akademik.mapel.form', ['mapel' => []]);
    //     }

    //     $penilaiantahfidz = KategoriPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
    //     $subkategori = SubKategoriPelajaran::all();

    //     return view('pages.admin.akademik.mapel.form', ['kategori' => $kategori, 'subkategori' => $subkategori,]);
    // }

    // public function mapelPost(Request $request){
    //     $globalValidatorData = [
    //         'kode_mata_pelajaran' => 'required|unique:mata_pelajarans,kode_mata_pelajaran',
    //         'nama_mata_pelajaran' => 'required',
    //         'kkm' => 'required',
    //         'kategori_pelajaran_id' => 'required',
    //         'sub_kategori_pelajaran_id' => 'required',
    //     ];

    //     $globalValidator = Validator::make($request->all(), $globalValidatorData);

    //     if ($globalValidator->fails()) {
    //         Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan validasi data dengan database sudah benar!');
    //         return redirect()->back()->withErrors($globalValidator)->withInput();
    //     }

    //     $data = $request->all();

    //     try {
    //         // Mendapatkan tahun ajaran aktif
    //         $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->firstOrFail();
            
    //         // Memasukkan ID tahun ajaran aktif ke data yang akan disimpan
    //         $data['tahun_ajaran_id'] = $tahunAjaranAktif->id;
    
    //         // Mengecek apakah terdapat nama mata pelajaran yang sama pada tahun ajaran aktif yang sama
    //         $subkategoriSama = MataPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)
    //             ->where('sub_kategori_pelajaran_id', $data['sub_kategori_pelajaran_id'])
    //             ->where('nama_mata_pelajaran', $data['nama_mata_pelajaran'])
    //             ->first();

    //         if ($subkategoriSama) {
    //             Alert::error('Gagal! (E002)', 'Nama Mata Pelajaran yang sama sudah ada pada sub kategori ini!');
    //             return redirect()->back()->withInput();
    //         }

    //         // Membuat Sub kategori pelajaran
    //         $mapel = MataPelajaran::create($data);
    
    //         Alert::success('Berhasil', 'Mata Pelajaran berhasil disimpan!');
    //         return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil disimpan!');
    //     } catch (\Exception $e) {
    //         Alert::error('Gagal! (E006)', 'Cek kembali kesesuaian isi form dengan validasi database');
    //         return redirect()->back()->withInput();
    //     }
    // }

    // public function editmapel($id){
    //     $mapel = MataPelajaran::findOrFail($id);

    //     $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

    //     if (!$tahunAjaranAktif) {
    //         return view('pages.admin.akademik.mapel.edit', ['mapel' => []]);
    //     }

    //     $kategori = KategoriPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
    //     $subkategori = SubKategoriPelajaran::all();

    //     return view('pages.admin.akademik.mapel.edit', ['mapel' => $mapel, 'kategori' => $kategori, 'subkategori' => $subkategori,]);
    // }

    // public function updatemapel(Request $request, $id){
    //     $validatedData = Validator::make($request->all(), [
    //         'kode_mata_pelajaran' => ['required', Rule::unique('mata_pelajarans', 'kode_mata_pelajaran')->ignore($id)],
    //         'nama_mata_pelajaran' => ['required', Rule::unique('mata_pelajarans')->where(function ($query) use ($request) {
    //             return $query->where('sub_kategori_pelajaran_id', $request->sub_kategori_pelajaran_id);
    //         })->ignore($id)],
    //         'kkm' => 'required',
    //         'kategori_pelajaran_id' => 'required',
    //         'sub_kategori_pelajaran_id' => 'required',
    //     ]);
    
    //     if ($validatedData->fails()) {
    //         Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode sub kategori yang sama atau nama sub kategori pada kategori pelajaran yang sama!');
    //         return redirect()->back()->withErrors($validatedData)->withInput();
    //     }
    
    //     $mapel = MataPelajaran::findOrFail($id);
    
    //     $mapel->fill([
    //         'kode_sub_kategori' => $request->kode_sub_kategori,
    //         'nama_sub_kategori' => $request->nama_sub_kategori,
    //         'kkm' => $request->kkm,
    //         'kategori_pelajaran_id' => $request->kategori_pelajaran_id,
    //         'sub_kategori_pelajaran_id' => $request->sub_kategori_pelajaran_id,
    //     ])->save();
    
    //     Alert::success('Berhasil', 'Mata Pelajaran berhasil diperbarui!');
    //     return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil diperbarui!');
    // }

    // public function deletemapel($id){
    //     $mapel = MataPelajaran::findOrFail($id);
    //     $mapel->delete();
    //     return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil dihapus!');
    // }
    
    // Penilaian Pelajaran
    public function listpenilaianpelajaran(){
        $user = Auth::user();
        $pengajar = Pengajar::where('user_id', $user->id)->first();
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        
        $penilaianpelajaran = PenilaianPelajaran::where('pengajar_id', $pengajar->id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->get();
        
        return view('pages.admin.pengajaradmin.penilaianpelajaran.index', [
            'penilaianpelajaran' => $penilaianpelajaran,
        ]);
    }
    

    public function showFormpenilaianpelajaran(){
        $user = Auth::user();
        $pengajar = Pengajar::where('user_id', $user->id)->first();
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
    
        $setup = SetupMataPelajaran::where('pengajar_id', $pengajar->id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->get();
    
        $kelas = collect();
        
        foreach ($setup as $setup) {
            $kelas->push(Kelas::where('id', $setup->kelas_id)->first());
        }

        $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunAjaranAktif, $pengajar) {
            $query->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('pengajar_id', $pengajar->id);
        })->get();

        $mapel = collect();
        foreach ($detail as $detail) {
            $mapel->push(MataPelajaran::where('id', $detail->mata_pelajaran_id)->first());
        }

        $siswa = Siswa::all();

        return view('pages.admin.pengajaradmin.penilaianpelajaran.form', [
            'siswa' => $siswa,
            'mapel' => $mapel,
            'kelas' => $kelas,
            'pengajar' => $pengajar,
            'tahunAjaranAktif' => $tahunAjaranAktif
        ]);
    }

    public function penilaianpelajaranPost(Request $request){
        $user = Auth::user();
        $pengajar = Pengajar::where('user_id', $user->id)->first();
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        $globalValidatorData = [
            'tanggal_penilaian' => 'required',
            'kelas_id' => 'required',
            'siswa_id' => 'required',
            'mata_pelajaran_id' => 'required',
            'nilai' => 'required',
        ];

        $globalValidator = Validator::make($request->all(), $globalValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan validasi data dengan database sudah benar!');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();

        try {
            $data['tahun_ajaran_id'] = $tahunAjaranAktif->id;
            $data['pengajar_id'] = $pengajar->id;
            $kelas = $request->kelas_id;
            $siswa = $request->siswa_id;
            $mapel = $request->mata_pelajaran_id;
    
            // Mengecek apakah terdapat nama mata pelajaran yang sama pada tahun ajaran aktif yang sama
            $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunAjaranAktif, $pengajar, $kelas) {
                $query->where('tahun_ajaran_id', $tahunAjaranAktif->id)->where('pengajar_id', $pengajar->id)->where('kelas_id', $kelas);})
                ->where('mata_pelajaran_id', $mapel)->exists();
            
            if (!$detail) {
                Alert::error('Gagal! (E003)', 'Anda tidak mengampu mata pelajaran ini pada kelas ini!');
                return redirect()->back()->withInput();
            }

            $nilai = $request->nilai;
            $kkmMapel = MataPelajaran::where('id', $mapel)->first();
            $kkm = $kkmMapel->kkm;

            if($nilai < $kkm){
                $data['keterangan'] = "Belum Tercapai";
            } elseif ($nilai >= $kkm){
                $data['keterangan'] = "Tercapai";
            }
                
            // Membuat Sub kategori pelajaran
            $penilaian = PenilaianPelajaran::create($data);
    
            Alert::success('Berhasil', 'Nilai Siswa berhasil disimpan!');
            return redirect()->route('penilaianpelajaran.index')->with('success', 'Nilai siswa berhasil disimpan!');
        } catch (\Exception $e) {
            Alert::error('Gagal! (E006)', 'Cek kembali kesesuaian isi form dengan validasi database'.$e->getMessage());
            return redirect()->back()->withInput();
        }
    }

//     public function editmapel($id){
//         $mapel = MataPelajaran::findOrFail($id);

//         $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

//         if (!$tahunAjaranAktif) {
//             return view('pages.admin.akademik.mapel.edit', ['mapel' => []]);
//         }

//         $kategori = KategoriPelajaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
//         $subkategori = SubKategoriPelajaran::all();

//         return view('pages.admin.akademik.mapel.edit', ['mapel' => $mapel, 'kategori' => $kategori, 'subkategori' => $subkategori,]);
//     }

//     public function updatemapel(Request $request, $id){
//         $validatedData = Validator::make($request->all(), [
//             'kode_mata_pelajaran' => ['required', Rule::unique('mata_pelajarans', 'kode_mata_pelajaran')->ignore($id)],
//             'nama_mata_pelajaran' => ['required', Rule::unique('mata_pelajarans')->where(function ($query) use ($request) {
//                 return $query->where('sub_kategori_pelajaran_id', $request->sub_kategori_pelajaran_id);
//             })->ignore($id)],
//             'kkm' => 'required',
//             'kategori_pelajaran_id' => 'required',
//             'sub_kategori_pelajaran_id' => 'required',
//         ]);
    
//         if ($validatedData->fails()) {
//             Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode sub kategori yang sama atau nama sub kategori pada kategori pelajaran yang sama!');
//             return redirect()->back()->withErrors($validatedData)->withInput();
//         }
    
//         $mapel = MataPelajaran::findOrFail($id);
    
//         $mapel->fill([
//             'kode_sub_kategori' => $request->kode_sub_kategori,
//             'nama_sub_kategori' => $request->nama_sub_kategori,
//             'kkm' => $request->kkm,
//             'kategori_pelajaran_id' => $request->kategori_pelajaran_id,
//             'sub_kategori_pelajaran_id' => $request->sub_kategori_pelajaran_id,
//         ])->save();
    
//         Alert::success('Berhasil', 'Mata Pelajaran berhasil diperbarui!');
//         return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil diperbarui!');
//     }

    public function deletepenilaianpelajaran($id){
        $nilai = PenilaianPelajaran::findOrFail($id);
        $nilai->delete();
        return redirect()->route('penilaianpelajaran.index')->with('success', 'Nilai pelajaran berhasil dihapus!');
    }
 }
