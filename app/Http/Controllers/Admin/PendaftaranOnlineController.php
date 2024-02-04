<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\JadwalTest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\exportPendaftar;

class PendaftaranOnlineController extends Controller {
    public function daftarOnlineGET(Request $request){
        // if (Auth::check()) {
        //     return redirect()->intended('/dashboarduser');
        // }
        return view('pages.daftar-online');
    }

    public function daftarOnlinePOST(Request $request){
        // if (Auth::check()) {
        //     return redirect()->intended('/dashboarduser');
        // }
        
        $globalValidatorData = [
            "no_nisn" => "required",
            "nama_calon_siswa" => "required",
            "tempat_lahir" => "required",
            "tanggal_lahir" => "required",
            "jenis_kelamin" => "required",
            "no_kartu_keluarga" => "required",
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
            "ayah_hidup" => "required",
            // "nama_ayah" => "required",
            // "pekerjaan_ayah" => "required",
            "ibu_hidup" => "required",
            // "nama_ibu" => "required",
            // "pekerjaan_ibu" => "required",
            "no_telepon_ortu" => "required",
            "penghasilan_per_bulan" => "required",
            "user_name" => "required|alpha_dash|unique:users,name",
            "password" => "required",
            "informasi_pmb" => "required",
            "captcha" => "required|captcha",
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

        unset($ayahValidatorData["captcha"]);
        unset($ibuValidatorData["captcha"]);
        unset($bothValidatorData["captcha"]);

        $globalValidator = Validator::make($request->all(), $globalValidatorData);
        $ayahValidator = Validator::make($request->all(), $ayahValidatorData);
        $ibuValidator = Validator::make($request->all(), $ibuValidatorData);
        $bothValidator = Validator::make($request->all(), $bothValidatorData);

        if ($globalValidator->fails()) {
            Alert::error('Gagal! (E001)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withErrors($globalValidator)->withInput();
        }

        $data = $request->all();
        $data['ayah_hidup'] = $request->has('ayah_hidup') ? true : false;
        $data['ibu_hidup'] = $request->has('ibu_hidup') ? true : false;
        $data['status'] = "BARU";

        if($data['ayah_hidup'] && $data['ibu_hidup']){
            if ($bothValidator->fails()) {
                Alert::error('Gagal! (E002)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
                return redirect()->back()->withErrors($bothValidator)->withInput();
            }
        } elseif ($data["ayah_hidup"]) {
            if ($ayahValidator->fails()) {
                Alert::error('Gagal! (E003)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
                return redirect()->back()->withErrors($ayahValidator)->withInput();
            }
        } elseif ($data["ibu_hidup"]) {
            if ($ibuValidator->fails()) {
                Alert::error('Gagal! (E004)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
                return redirect()->back()->withErrors($ibuValidator)->withInput();
            }
        }

        $dataUser = [
            "name" => $data['user_name'],
            "email" => $data['user_name'],
            "role" => "user",
            "password" => Hash::make($data['password']),
        ];

        unset($data['user_name']);
        unset($data['password']);

        $user = User::create($dataUser);

        $data["user_id"] = $user->id;
        $data["no_pendaftaran"] = "";
        $pendaftar = Pendaftaran::create($data);
        $pendaftar->update([
            "no_pendaftaran" => date("Y-m-d") . "-" . $pendaftar->id,
        ]);

        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        if (Auth::attempt(['email' => $request->user_name, 'password' => $request->password])) {
            $request->session()->regenerate();
            Alert::success('Berhasil!', 'Pendaftaran Berhasil Dikirim!');
            return redirect()->intended('/dashboarduser');
            //return redirect()->route('homeuser');
        }

        return view('pages.daftar-online');
    }

    public function profileGET(Request $request){
        $user = Auth::user();
        $profile = Pendaftaran::where('user_id', $user->id)->first();
        return view('pages.menuuser.profile', [
            "profile" => $profile,
            "user" => [
                "name" => $user->name,
                "email" => $user->email,
                "role" => $user->role
            ]
        ]);
    }

    public function profilePOST(Request $request){
        $user = Auth::user();
        $profile = Pendaftaran::where('user_id', $user->id)->first();

        $globalValidatorData = [
            "no_nisn" => "required",
            "nama_calon_siswa" => "required",
            "tempat_lahir" => "required",
            "tanggal_lahir" => "required",
            "jenis_kelamin" => "required",
            "no_kartu_keluarga" => "required",
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
            "ayah_hidup" => "required",
            // "nama_ayah" => "required",
            // "pekerjaan_ayah" => "required",
            "ibu_hidup" => "required",
            // "nama_ibu" => "required",
            // "pekerjaan_ibu" => "required",
            "no_telepon_ortu" => "required",
            "penghasilan_per_bulan" => "required",
            // "user_name" => "required|alpha_dash|unique:users,name",
            // "password" => "required",
            "informasi_pmb" => "required",
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
        $data['ayah_hidup'] = $request->has('ayah_hidup') ? true : false;
        $data['ibu_hidup'] = $request->has('ibu_hidup') ? true : false;

        if($data['ayah_hidup'] && $data['ibu_hidup']){
            if ($bothValidator->fails()) {
                Alert::error('Gagal! (E002)', 'Cek pada form profile apakah ada kesalahan yang terjadi');
                return redirect()->back()->withErrors($bothValidator)->withInput();
            }
        } elseif ($data["ayah_hidup"]) {
            if ($ayahValidator->fails()) {
                Alert::error('Gagal! (E003)', 'Cek pada form profile apakah ada kesalahan yang terjadi');
                return redirect()->back()->withErrors($ayahValidator)->withInput();
            }
        } elseif ($data["ibu_hidup"]) {
            if ($ibuValidator->fails()) {
                Alert::error('Gagal! (E004)', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
                return redirect()->back()->withErrors($ibuValidator)->withInput();
            }
        }

        $newData = [];
        foreach ($profile->toArray() as $key => $value) {
            if(isset($data[$key])){
                if($value != $data[$key])
                    $newData[$key] = $data[$key];
            }
        }

        $profile->update($newData);

        $profile = Pendaftaran::where('user_id', $user->id)->first();

        return view('pages.menuuser.profile', [
            "profile" => $profile,
            "user" => [
                "name" => $user->name,
                "email" => $user->email,
                "role" => $user->role
            ]
        ]);
    }

    public function index()
    {
        $pendaftaran = Pendaftaran::where('status', 'BARU')->get();
        return view('pages.admin.pendaftaran.list_pendaftaran_baru', [
            "pendaftaran" => $pendaftaran
        ]);
    }

    public function listTest()
    {
        $pendaftaran = Pendaftaran::where('status', 'TEST')->get();
        return view('pages.admin.pendaftaran.list_pendaftar_test', [
            "pendaftaran" => $pendaftaran
        ]);
    }

    public function listTerima()
    {
        $pendaftaran = Pendaftaran::where('status', 'DITERIMA')->get();
        return view('pages.admin.pendaftaran.list_pendaftar_diterima', [
            "pendaftaran" => $pendaftaran
        ]);
    }

    public function listTolak()
    {
        $pendaftaran = Pendaftaran::where('status', 'DITOLAK')->get();
        return view('pages.admin.pendaftaran.list_pendaftar_ditolak', [
            "pendaftaran" => $pendaftaran
        ]);
    }

    public function profile()
    {
        $pendaftars = Pendaftaran::all();
        $data = [
            'pendaftars' => $pendaftars
        ];

        return view('pages.admin.profile.index', $data);
    }

    public function detail($no_nisn)
    {
        $pendaftar = Pendaftaran::where('no_nisn', $no_nisn)->first();
        $data = [
            'pendaftar' => $pendaftar
        ];

        return view('pages.admin.pendaftar.detail', $data);
    }

    public function detailbynisn($no_nisn)
    {
        $pendaftar = Pendaftaran::where('no_nisn', $no_nisn)->first();
        $data = [
            'pendaftar' => $pendaftar
        ];

        return view('pages.menuuser.pendaftar.detailuser', $data);
    }

    public function update(Request $request)
    {
        $pendaftar = Pendaftaran::findOrFail($request->pendaftar_id); // Menggunakan id pendaftar dari permintaan
        $pendaftar->update([
            'status' => $request->status
        ]);

        Alert::success('Berhasil!', 'Status Berhasil Di Edit!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $pendaftar = Pendaftaran::findOrFail($id);
        $pendaftar->delete();

        return redirect()->route('pendaftar.index');
    }

    public function list(){
        // Ambil data jadwal test dari database
        $jadwalTests = JadwalTest::all();
    
        // Kirim data jadwal test ke view
        return view('jadwaltest.list', ['jadwalTests' => $jadwalTests]);
        }

    public function indexrekap(){
        $pendaftars = Pendaftaran::all();
    
        return view('pages.admin.rekap.index', compact('pendaftars'));
    }

    public function filter(Request $request){
        $min_date = $request->min_date;
        $max_date = $request->max_date;

        $pendaftars = Pendaftaran::whereDate('created_at','>=',$min_date)
                                    ->whereDate('created_at','<=',$max_date)
                                    ->get();
        
        return view('pages.admin.rekap.index', compact('pendaftars'));
    }
    
    public function cetak_laporan(Request $request){
        $min_date = $request->min_date;
        $max_date = $request->max_date;

        if ($min_date && $max_date) {
            $pendaftars = Pendaftaran::whereDate('created_at','>=',$min_date)
                                    ->whereDate('created_at','<=',$max_date)
                                    ->get();
        } else {
            $pendaftars = Pendaftaran::all();
        }

        $laporan = PDF::loadView('pages.laporan_pdf', ['pendaftars' => $pendaftars])->setPaper('A4', 'portrait');
        return $laporan->stream('laporan_data_pendaftar.pdf');
    }
        
    public function exportPendaftar(Request $request){
        if ($request->filled('min_date') && $request->filled('max_date')) {
            $min_date = $request->min_date;
            $max_date = $request->max_date;
            $pendaftars = Pendaftaran::whereDate('created_at','>=',$min_date)
                ->whereDate('created_at','<=',$max_date)
                ->get();
        } else {
            $pendaftars = Pendaftaran::all();
        }
    
        return Excel::download(new ExportPendaftar($pendaftars), 'pendaftar.xlsx');
    }
}