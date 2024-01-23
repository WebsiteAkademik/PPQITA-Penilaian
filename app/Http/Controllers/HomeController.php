<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }

    public function daftarOnline()
    {
        return view('pages.daftar-online');
    }

    public function galeri()
    {
        return view('pages.galeri');
    }

    public function kontak()
    {
        return view('pages.kontak');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img("flat")]);
    }
    public function cetak_pdf($no_nisn)
    {
        $pendaftar = Pendaftar::where('no_nisn', $no_nisn)->first();
        $data = [
            'pendaftar' => $pendaftar
        ];
        $pegawai = Pendaftar::all();

        $pdf = PDF::loadView('pages.pendaftar_pdf', ['pendaftar' => $data])->setPaper('A4', 'potrait');
        return $pdf->stream('formulir_daftarulang.pdf');
    }

    public function cetak_laporan(){
        $rekap = Pendaftar::all();
        $laporan = PDF::loadView('pages.laporan_pdf', ['rekap' => $rekap])->setPaper('A4', 'portrait');
        return $laporan->stream('laporan_data_pendaftar.pdf');
    }
    
    public function daftar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_nisn' => 'required',
            'nama_calon_siswa' => 'required',
            'program_keahlian' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'no_induk_keluarga' => 'required',
            'no_kartu_keluarga' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'tinggi_badan' => 'required',
            'berat_badan' => 'required',
            'bertato' => 'required',
            'penyakit_kronis' => 'required',
            'asal_sekolah' => 'required',
            'alamat_rumah' => 'required',
            'nama_ayah' => 'required',
            'pekerjaan_ayah' => 'required',
            'nama_ibu' => 'required',
            'pekerjaan_ibu' => 'required',
            'penghasilan_per_bulan' => 'required',
            'no_telepon' => 'required',
            'informasi_pmb' => 'required',
            'user_name' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Cek pada form daftar apakah ada kesalahan yang terjadi');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['ayah_hidup'] = $request->has('ayah_hidup') ? 1 : 0;
        $data['ibu_hidup'] = $request->has('ibu_hidup') ? 1 : 0;
        $data['status'] = "open";
        switch ($request->program_keahlian) {
            case "TP":
                $data['program_keahlian_singkatan']= "Teknik Pemesinan ";
                break;
            case "TLAS":
                $data['program_keahlian_singkatan']= "Teknik Pengelasan";
                break;
            case "TKRO":
                $data['program_keahlian_singkatan']= "Teknik Kendaraan Ringan 0tomotif";
                break;
            case "TBSM":
                $data['program_keahlian_singkatan']= "Teknik dan Bisnis Sepeda Motor";
                break;
            default:
            $data['status']= "Teknik Pemesinan";
            }
        $data['password'] = Hash::make($request->has('password'));
        $data['no_pendaftaran'] = strval(date("Y")). strval(date("m"))
                                  .strval(date("d")).'-'.strval($request->no_nisn);
        $data['slug'] = Str::slug($data['nama_calon_siswa']);

        Pendaftar::create($data);
        $user = User::create([
            'name' => $request->no_nisn,
            'email' => $request->user_name,
            'password' => Hash::make($request->password),
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

    }
}
