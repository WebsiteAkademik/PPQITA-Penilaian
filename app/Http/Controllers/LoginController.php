<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function postlogin (Request $request){
        //dd($request->all());

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $remember = $request->has('rememberme'); 

        if (Auth::attempt($request->only('email', 'password'))){
            if(Auth::user()->role == "admin"){
                return redirect('dashboard');
            } elseif(Auth::user()->role == "pengajar") {
                return redirect('dashboardpengajar');
            } elseif(Auth::user()->role == "user"){
                return redirect('dashboardsiswa');
            }
        }
        return redirect()->back()->with('loginError', 'Email/Username/NISN atau Password tidak tepat');
    }
}