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

class PengajarController extends Controller
{
    // Penilaian Tahfidz
    public function listpenilaiantahfidz(){
        $user = Auth::user();
        $pengajar = Pengajar::where('user_id', $user->id)->first();
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        $mapelTahfidz = MataPelajaran::where('nama_mata_pelajaran', 'Tahfidz')->first();
        
        $penilaiantahfidz = PenilaianTahfidz::where('pengajar_id', $pengajar->id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('mata_pelajaran_id', $mapelTahfidz->id)
            ->get();
        
        return view('pages.admin.pengajaradmin.penilaiantahfidz.index', [
            'penilaiantahfidz' => $penilaiantahfidz,
        ]);
    }

    public function showFormpenilaiantahfidz(){
        $user = Auth::user();
        $pengajar = Pengajar::where('user_id', $user->id)->first();
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        $mapelTahfidz = MataPelajaran::where('nama_mata_pelajaran', 'Tahfidz')->first();
    
        $setupTahfidz = SetupMataPelajaran::withWhereHas('detailSetupMataPelajaran', function ($query) use ($mapelTahfidz){
            $query->where('mata_pelajaran_id', $mapelTahfidz->id);
        })->where('pengajar_id', $pengajar->id)
        ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
        ->get();

        $kelasTahfidz = collect();
        
        foreach ($setupTahfidz as $setup) {
            $kelasTahfidz->push(Kelas::where('id', $setup->kelas_id)->first());
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

    public function penilaiantahfidzPost(Request $request){
        $user = Auth::user();
        $pengajar = Pengajar::where('user_id', $user->id)->first();
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        $mapelTahfidz = MataPelajaran::where('nama_mata_pelajaran', 'Tahfidz')->first();

        $globalValidatorData = [
            'tanggal_penilaian' => 'required',
            'kelas_id' => 'required',
            'siswa_id' => 'required',
            'jenis_penilaian' => 'required',
            'nilai' => 'required',
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
            $data['mata_pelajaran_id'] = $mapelTahfidz->id;
            $kelas = $request->kelas_id;
            $siswa = $request->siswa_id;
    
            // Mengecek apakah terdapat nama mata pelajaran yang sama pada tahun ajaran aktif yang sama
            $detail = DetailSetupMataPelajaran::whereHas('SetupMataPelajaran', function($query) use ($tahunAjaranAktif, $pengajar, $kelas) {
                $query->where('tahun_ajaran_id', $tahunAjaranAktif->id)->where('pengajar_id', $pengajar->id)->where('kelas_id', $kelas);})
                ->where('mata_pelajaran_id', $mapelTahfidz->id)->exists();
            
            if (!$detail) {
                Alert::error('Gagal! (E003)', 'Anda tidak mengampu mata pelajaran ini pada kelas ini!');
                return redirect()->back()->withInput();
            }

            $nilai = $request->nilai;
            $kkm = $mapelTahfidz->kkm;

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
    
        $mapelTahfidz = MataPelajaran::where('nama_mata_pelajaran', 'Tahfidz')->first();
        $nilai = $request->nilai;
        $kkm = $mapelTahfidz->kkm;

        $keterangan = ($nilai < $kkm) ? "Belum Tercapai" : "Tercapai";

        $penilaian = PenilaianTahfidz::findOrFail($id);
    
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

        $keterangan = ($nilai < $kkm) ? "Belum Tercapai" : "Tercapai";

        $penilaian = PenilaianPelajaran::findOrFail($id);
    
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

    public function getEvents(Request $request){
        $start = $request->input("start", (new DateTime())->modify("-1 month")->format(DateTime::ATOM));
        $end = $request->input("end", (new DateTime())->modify("+1 month")->format(DateTime::ATOM));

        $d_start = strtotime($start);
        $d_end = strtotime($end);

        $jadwal_ujian = JadwalUjian::whereDate('tanggal_ujian', '>=', date('Y-m-d', $d_start))->whereDate('tanggal_ujian', '<=', date('Y-m-d', $d_end))->get();
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
 }
