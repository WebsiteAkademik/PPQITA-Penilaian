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
use App\Models\JadwalUjian;
use App\Models\Pengajar;
use App\Models\Siswa;
use DateTime;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PengajarController extends Controller
{
    // Penilaian Tahfidz
    public function listpenilaiantahfidz(){
        $user = Auth::user();
        $pengajar = Pengajar::where('user_id', $user->id)->first();
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        
        $penilaiantahfidz = PenilaianTahfidz::where('pengajar_id', $pengajar->id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('semester', $tahunAjaranAktif->semester)
            ->get();
        
        return view('pages.admin.pengajaradmin.penilaiantahfidz.index', [
            'penilaiantahfidz' => $penilaiantahfidz,
        ]);
    }

    public function showFormpenilaiantahfidz(){
        $user = Auth::user();
        $pengajar = Pengajar::where('user_id', $user->id)->first();
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        $subTahfidz = SubKategoriPelajaran::where('nama_sub_kategori', 'Tahfidz')->first();
        
        $setupTahfidz = SetupMataPelajaran::where('pengajar_id', $pengajar->id)
        ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
        ->get();

        $kelasTahfidz = collect();
        
        foreach ($setupTahfidz as $setup) {
            $kelasTahfidz->push(Kelas::where('id', $setup->kelas_id)->first());
        }

        $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunAjaranAktif, $pengajar) {
            $query->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('pengajar_id', $pengajar->id);
        })->get();

        $mapelTahfidz = collect();
        foreach ($detail as $detailItem) {
            $mapel = MataPelajaran::where('id', $detailItem->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subTahfidz->id)
                ->first();
            if ($mapel) {
                $mapelTahfidz->push($mapel);
            }
        }
        
        $siswa = Siswa::all();

        return view('pages.admin.pengajaradmin.penilaiantahfidz.form', [
            'siswa' => $siswa,
            'mapelTahfidz' => $mapelTahfidz,
            'kelasTahfidz' => $kelasTahfidz,
            'pengajar' => $pengajar,
            'tahunAjaranAktif' => $tahunAjaranAktif
        ]);
    }

    public function fetchMapelTahfidz($kelasId, $tahunAjaranId, $pengajarId) {
        $subTahfidz = SubKategoriPelajaran::where('nama_sub_kategori', 'Tahfidz')->first();

        $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($kelasId, $tahunAjaranId, $pengajarId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId)
                ->where('pengajar_id', $pengajarId)
                ->where('kelas_id', $kelasId);
        })->get();
    
        $mapels = $detail->map(function ($item, $key) use ($subTahfidz) {
            $mapel = MataPelajaran::where('id', $item->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subTahfidz->id)
                ->first();
            if($mapel) {
                return MataPelajaran::find($item->mata_pelajaran_id);
            }
            
        });
    
        return response()->json($mapels);
    }

    public function penilaiantahfidzPost(Request $request){
        $user = Auth::user();
        $pengajar = Pengajar::where('user_id', $user->id)->first();
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        
        $globalValidatorData = [
            'tanggal_penilaian' => 'required',
            'kelas_id' => 'required',
            'siswa_id' => 'required',
            'jenis_penilaian' => 'required',
            'nilai' => 'required',
            'mata_pelajaran_id' => 'required',
            'surat_awal' => 'required',
            'surat_akhir' => 'required',
            'ayat_awal' => 'required',
            'ayat_akhir' => 'required',
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
            $data['semester'] = $tahunAjaranAktif->semester;
            $kelas = $request->kelas_id;
            $siswa = $request->siswa_id;
            $mapel = MataPelajaran::where('id', $request->mata_pelajaran_id)->first();
    
            $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunAjaranAktif, $pengajar, $kelas) {
                $query->where('tahun_ajaran_id', $tahunAjaranAktif->id)->where('pengajar_id', $pengajar->id)->where('kelas_id', $kelas);})
                ->where('mata_pelajaran_id', $request->mata_pelajaran_id)->exists();
            
            if (!$detail) {
                Alert::error('Gagal! (E003)', 'Anda tidak mengampu mata pelajaran ini pada kelas ini!');
                return redirect()->back()->withInput();
            }

            $nilai = $request->nilai;
            $kkm = $mapel->kkm;

            if($nilai < $kkm){
                $data['keterangan'] = "Belum Tercapai";
            } elseif ($nilai >= $kkm){
                $data['keterangan'] = "Tercapai";
            }
                
            // Membuat Penilaian Pelajaran
            $penilaian = PenilaianTahfidz::create($data);
    
            Alert::success('Berhasil', 'Nilai Siswa berhasil disimpan!');
            return redirect()->route('penilaiantahfidz.index')->with('success', 'Nilai siswa berhasil disimpan!');
        } catch (\Exception $e) {
            Alert::error('Gagal! (E006)', 'Cek kembali kesesuaian isi form dengan validasi database'.$e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function editpenilaiantahfidz($id){
        $penilaian = PenilaianTahfidz::findOrFail($id);

        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.pengajaradmin.penilaiantahfidz.edit', ['penilaian' => []]);
        }

        return view('pages.admin.pengajaradmin.penilaiantahfidz.edit', ['penilaian' => $penilaian]);
    }

    public function updatepenilaiantahfidz(Request $request, $id){
        $validatedData = Validator::make($request->all(), [
            'tanggal_penilaian' => 'required',
            'jenis_penilaian' => 'required',
            'surat_awal' => 'required',
            'surat_akhir' => 'required',
            'ayat_awal' => 'required',
            'ayat_akhir' => 'required',
            'nilai' => 'required',
        ]);
        
        if ($validatedData->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada data yang kosong!');
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $penilaian = PenilaianTahfidz::findOrFail($id);
        $mapelTahfidz = MataPelajaran::where('id', $penilaian->mata_pelajaran_id)->first();
        $nilai = $request->nilai;
        $kkm = $mapelTahfidz->kkm;

        $keterangan = ($nilai < $kkm) ? "Belum Tercapai" : "Tercapai";
    
        $penilaian->fill([
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'jenis_penilaian' => $request->jenis_penilaian,
            'surat_awal' => $request->surat_awal,
            'surat_akhir' => $request->surat_akhir,
            'ayat_awal' => $request->ayat_awal,
            'ayat_akhir' => $request->ayat_akhir,
            'nilai' => $request->nilai,
            'keterangan' => $keterangan,
        ])->save();
    
        Alert::success('Berhasil', 'Nilai siswa berhasil diperbarui!');
        return redirect()->route('penilaiantahfidz.index')->with('success', 'Nilai siswa berhasil diperbarui!');
        
    }

    public function deletepenilaiantahfidz($id){
        $nilai = PenilaianTahfidz::findOrFail($id);
        $nilai->delete();
        return redirect()->route('penilaiantahfidz.index')->with('success', 'Nilai tahfidz siswa berhasil dihapus!');
    }
    
    // Penilaian Pelajaran
    public function listpenilaianpelajaran(){
        $user = Auth::user();
        $pengajar = Pengajar::where('user_id', $user->id)->first();
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        
        $penilaianpelajaran = PenilaianPelajaran::where('pengajar_id', $pengajar->id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('semester', $tahunAjaranAktif->semester)
            ->get();
        
        return view('pages.admin.pengajaradmin.penilaianpelajaran.index', [
            'penilaianpelajaran' => $penilaianpelajaran,
        ]);
    }
    

    public function showFormpenilaianpelajaran(){
        $user = Auth::user();
        $pengajar = Pengajar::where('user_id', $user->id)->first();
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        $subTahfidz = SubKategoriPelajaran::where('nama_sub_kategori', 'Tahfidz')->first();
    
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
        foreach ($detail as $detailItem) {
            $mapelTahfidz = MataPelajaran::where('id', $detailItem->mata_pelajaran_id)
                ->where('sub_kategori_pelajaran_id', $subTahfidz->id)
                ->first();
            if (!$mapelTahfidz) {
                $mapel->push(MataPelajaran::where('id', $detailItem->mata_pelajaran_id)->first());
            }
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

    public function fetchMapelUmum($kelasId, $tahunAjaranId, $pengajarId) {
        // Fetch mapel data based on $kelasId and $tahunAjaranId
        $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($kelasId, $tahunAjaranId, $pengajarId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId)
                ->where('pengajar_id', $pengajarId)
                ->where('kelas_id', $kelasId);
        })->get();
    
        $mapels = $detail->map(function ($item) {
            return MataPelajaran::find($item->mata_pelajaran_id);
        });
    
        return response()->json($mapels);
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
            'jenis_ujian' => 'required',
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
            $data['semester'] = $tahunAjaranAktif->semester;
            $kelas = $request->kelas_id;
            $siswa = $request->siswa_id;
            $mapel = $request->mata_pelajaran_id;
            $jenisUjian = $request->jenis_ujian;

            // Mengecek apakah sudah terdapat nilai ujian yang sama pada siswa tersebut
            $ujianAda = PenilaianPelajaran::where('siswa_id', $siswa)
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->where('semester', $data['semester'])
                ->where('mata_pelajaran_id', $mapel)
                ->where('jenis_ujian', $jenisUjian)
                ->exists();
    
            if ($jenisUjian !== 'Penilaian Harian' && $ujianAda) {
                Alert::error('Gagal! (E006)', 'Nilai ' . $jenisUjian . ' untuk siswa ini pada semester ini sudah ada!');
                return redirect()->back()->withInput();
            }
    
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
                
            // Membuat Penilaian Pelajaran
            $penilaian = PenilaianPelajaran::create($data);
    
            Alert::success('Berhasil', 'Nilai Siswa berhasil disimpan!');
            return redirect()->route('penilaianpelajaran.index')->with('success', 'Nilai siswa berhasil disimpan!');
        } catch (\Exception $e) {
            Alert::error('Gagal! (E006)', 'Cek kembali kesesuaian isi form dengan validasi database'.$e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function editpenilaianpelajaran($id){
        $penilaian = PenilaianPelajaran::findOrFail($id);

        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            return view('pages.admin.pengajaradmin.penilaianpelajaran.edit', ['penilaian' => []]);
        }

        return view('pages.admin.pengajaradmin.penilaianpelajaran.edit', ['penilaian' => $penilaian]);
    }

    public function updatepenilaianpelajaran(Request $request, $id){
        $validatedData = Validator::make($request->all(), [
            'tanggal_penilaian' => 'required',
            'jenis_ujian' => 'required',
            'mata_pelajaran_id' => 'required',
            'nilai' => 'required',
        ]);

        if ($validatedData->fails()) {
            Alert::error('Gagal! (E001)', 'Cek kembali data untuk memastikan tidak ada kode sub kategori yang sama atau nama sub kategori pada kategori pelajaran yang sama!');
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
    
        $mapel = $request->mata_pelajaran_id;
        $nilai = $request->nilai;
        $kkmMapel = MataPelajaran::where('id', $mapel)->first();
        $kkm = $kkmMapel->kkm;
        $jenisUjian = $request->jenis_ujian;
        $penilaian = PenilaianPelajaran::findOrFail($id);

        // Mengecek apakah sudah terdapat nilai ujian yang sama pada siswa tersebut
        $ujianAda = PenilaianPelajaran::where('id', '!=', $id)
                ->where('siswa_id', $penilaian->siswa_id)
                ->where('tahun_ajaran_id', $penilaian->tahun_ajaran_id)
                ->where('mata_pelajaran_id', $mapel)
                ->where('jenis_ujian', $jenisUjian)
                ->exists();
    
        if ($jenisUjian !== 'Penilaian Harian' && $ujianAda) {
            Alert::error('Gagal! (E006)', 'Nilai ' . $jenisUjian . ' untuk siswa ini pada semester ini sudah ada!');
            return redirect()->back()->withInput();
        }

        $keterangan = ($nilai < $kkm) ? "Belum Tercapai" : "Tercapai";
    
        $penilaian->fill([
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'jenis_ujian' => $request->jenis_ujian,
            'nilai' => $request->nilai,
            'keterangan' => $keterangan,
        ])->save();
    
        Alert::success('Berhasil', 'Nilai siswa berhasil diperbarui!');
        return redirect()->route('penilaianpelajaran.index')->with('success', 'Nilai siswa berhasil diperbarui!');
        
    }

    public function deletepenilaianpelajaran($id){
        $nilai = PenilaianPelajaran::findOrFail($id);
        $nilai->delete();
        return redirect()->route('penilaianpelajaran.index')->with('success', 'Nilai pelajaran berhasil dihapus!');
    }

    public function getEventsguru(Request $request){
        $start = $request->input("start", (new DateTime())->modify("-1 month")->format(DateTime::ATOM));
        $end = $request->input("end", (new DateTime())->modify("+1 month")->format(DateTime::ATOM));

        $d_start = strtotime($start);
        $d_end = strtotime($end);

        $user = Auth::user();
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        $pengajar = Pengajar::where('user_id', $user->id)->first();
        $setup = SetupMataPelajaran::where('pengajar_id', $pengajar->id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->get();
    
        $jadwal_ujian = collect();
        foreach($setup as $setupItem){
            $detail = DetailSetupMataPelajaran::where('setup_mata_pelajaran_id', $setupItem->id)->first();
        
            if($detail) {
                $jadwal = JadwalUjian::whereDate('tanggal_ujian', '>=', date('Y-m-d', $d_start))
                    ->whereDate('tanggal_ujian', '<=', date('Y-m-d', $d_end))
                    ->where('kelas_id', $setupItem->kelas_id)
                    ->where('mata_pelajaran_id', $detail->mata_pelajaran_id)
                    ->first();
    
                // Pastikan $jadwal bukan null sebelum ditambahkan ke koleksi
                if ($jadwal) {
                    $jadwal_ujian->push($jadwal);
                }
            }
        }
        
        $ret = array();

        /*
         * [
         *     {
         *         "resourceId": "d",
         *         "title": "event 1",
         *         "start": "2024-03-02",
         *         "end": "2024-03-04"
         *     }
         * ]
        */
        foreach($jadwal_ujian as $jadwal){
            $d_s = DateTime::createFromFormat("Y-m-d H:i:s", $jadwal->tanggal_ujian . " " . $jadwal->jam_ujian);
            $d_e = DateTime::createFromFormat("Y-m-d H:i:s", $jadwal->tanggal_ujian . " " . $jadwal->jam_ujian);

            $s = $d_s->format(DateTime::ATOM);
            $e = $d_e->format(DateTime::ATOM);

            // Tentukan warna background berdasarkan jenis ujian
            $backgroundColor = '';
            switch ($jadwal->jenis_ujian) {
                case 'Penilaian Harian':
                    $backgroundColor = 'blue';
                    break;
                case 'UTS':
                    $backgroundColor = 'green';
                    break;
                case 'UAS':
                    $backgroundColor = 'red';
                    break;
                default:
                    $backgroundColor = ''; // Atur warna default jika jenis ujian tidak cocok dengan kriteria di atas
            }

            $j = array(
                "resourceId" => $jadwal->id,
                "title" => "",
                "description" => "(Mulai: " . substr($jadwal->jam_ujian, 0, 5) . ")\n" . $jadwal->jenis_ujian . "\n" . $jadwal->mataPelajaran()->nama_mata_pelajaran . "\n" . $jadwal->kelas()->kelas,
                "start" => $s,
                "end" => $e,
                "backgroundColor" => $backgroundColor,
            );

            $ret[] = $j;
        }

        return response()->json($ret);
    }

    //Siswa//*
    public function getEvents(Request $request){
        $start = $request->input("start", (new DateTime())->modify("-1 month")->format(DateTime::ATOM));
        $end = $request->input("end", (new DateTime())->modify("+1 month")->format(DateTime::ATOM));

        $d_start = strtotime($start);
        $d_end = strtotime($end);

        $user = Auth::user();

        $siswa = Siswa::where('user_id', $user->id)->first();

        $jadwal_ujian = JadwalUjian::whereDate('tanggal_ujian', '>=', date('Y-m-d', $d_start))
                        ->whereDate('tanggal_ujian', '<=', date('Y-m-d', $d_end))
                        ->where('kelas_id', $siswa->kelas_id)
                        ->get();
        $ret = array();

        /*
         * [
         *     {
         *         "resourceId": "d",
         *         "title": "event 1",
         *         "start": "2024-03-02",
         *         "end": "2024-03-04"
         *     }
         * ]
        */
        foreach($jadwal_ujian as $jadwal){
            $d_s = DateTime::createFromFormat("Y-m-d H:i:s", $jadwal->tanggal_ujian . " " . $jadwal->jam_ujian);
            $d_e = DateTime::createFromFormat("Y-m-d H:i:s", $jadwal->tanggal_ujian . " " . $jadwal->jam_ujian);

            $s = $d_s->format(DateTime::ATOM);
            $e = $d_e->format(DateTime::ATOM);

            // Tentukan warna background berdasarkan jenis ujian
            $backgroundColor = '';
            switch ($jadwal->jenis_ujian) {
                case 'Penilaian Harian':
                    $backgroundColor = 'blue';
                    break;
                case 'UTS':
                    $backgroundColor = 'green';
                    break;
                case 'UAS':
                    $backgroundColor = 'red';
                    break;
                default:
                    $backgroundColor = ''; // Atur warna default jika jenis ujian tidak cocok dengan kriteria di atas
            }

            $j = array(
                "resourceId" => $jadwal->id,
                "title" => "",
                "description" => "(Mulai: " . substr($jadwal->jam_ujian, 0, 5) . ")\n" . $jadwal->jenis_ujian . "\n" . $jadwal->mataPelajaran()->nama_mata_pelajaran . "\n" . $jadwal->kelas()->kelas,
                "start" => $s,
                "end" => $e,
                "backgroundColor" => $backgroundColor,
            );

            $ret[] = $j;
        }

        return response()->json($ret);
    }

    public function viewNilai(){
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();
        $tahunajar = TahunAjaran::where('status', 'aktif')->first();
        $kelas = Kelas::where('id', $siswa->kelas_id)->first();

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
                ->where('tahun_ajaran_id', $tahunajar->id)
                ->where('semester', $tahunajar->semester)
                ->avg('nilai');
        }

        foreach ($mapelumum as $mapel) {
            $penilaian = PenilaianPelajaran::where('mata_pelajaran_id', $mapel->id)
                ->where('siswa_id', $siswa->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->where('tahun_ajaran_id', $tahunajar->id)
                ->where('semester', $tahunajar->semester)
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
                ->where('tahun_ajaran_id', $tahunajar->id)
                ->where('semester', $tahunajar->semester)
                ->avg('nilai');
        }

        foreach ($mapeldinniyah as $mapel) {
            $penilaian = PenilaianPelajaran::where('mata_pelajaran_id', $mapel->id)
                ->where('siswa_id', $siswa->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->where('tahun_ajaran_id', $tahunajar->id)
                ->where('semester', $tahunajar->semester)
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
                ->where('tahun_ajaran_id', $tahunajar->id)
                ->where('semester', $tahunajar->semester)
                ->avg('nilai');
        }

        foreach ($mapeltahfidz as $mapel) {
            $penilaian = PenilaianTahfidz::where('mata_pelajaran_id', $mapel->id)
                ->where('siswa_id', $siswa->id)
                ->where('kelas_id', $siswa->kelas_id)
                ->where('tahun_ajaran_id', $tahunajar->id)
                ->where('semester', $tahunajar->semester)
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

        return view('pages.menuuser.nilai', ['siswa' => $siswa, 'kelas' => $kelas, 'tahunajar' => $tahunajar, 'nilaitotal_umum' => $nilaitotal_umum, 'nilai_rata_rata_total' => $nilai_rata_rata_total, 'nilaiumum_kelas' => $nilaiumum_kelas, 'nilaitahfidz_kelas' => $nilaitahfidz_kelas, 'nilaidinniyah_kelas' => $nilaidinniyah_kelas, 'penilaiantahfidz' => $penilaiantahfidz, 'penilaiandinniyah' => $penilaiandinniyah, 'penilaianumum' => $penilaianumum]);
    }

    public function viewJadwal(){
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();
        $jadwalujian = JadwalUjian::where('kelas_id', $siswa->kelas_id)
                    ->where('tanggal_ujian', '>=', now()->toDateString())
                    ->get()
                    ->sortBy('tanggal_ujian');
        
        return view('pages.menuuser.jadwalujian', ['jadwalujian' => $jadwalujian]);
    }

    public function viewProfile(){
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        return view('pages.menuuser.profile', ['siswa' => $siswa]);
    }
}
