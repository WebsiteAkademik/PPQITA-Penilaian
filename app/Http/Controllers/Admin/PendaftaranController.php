<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pendaftar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PendaftaranController extends Controller
{
    public function index()
    {
        $pendaftars = Pendaftar::latest()->get();
        $data = [
            'pendaftars' => $pendaftars
        ];

        return view('pages.admin.pendaftar.index', $data);
    }

    public function detail($slug)
    {
        $pendaftar = Pendaftar::where('slug', $slug)->first();
        $data = [
            'pendaftar' => $pendaftar
        ];

        return view('pages.admin.pendaftar.detail', $data);
    }
    public function detailbynisn($no_nisn)
    {
        $pendaftar = Pendaftar::where('slug', $no_nisn)->first();
        $data = [
            'pendaftar' => $pendaftar
        ];

        return view('pages.menuuser.pendaftar.detailuser', $data);
    }

    public function update(Request $request, $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->update([
            'status' => $request->status
        ]);

        Alert::success('Berhasil!', 'Status Berhasil Di Edit!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->delete();

        return redirect()->route('pendaftar.index');
    }
}
