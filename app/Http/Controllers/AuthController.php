<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('pages.login');
    }

    public function loginViewUser(){
        //if(strlen(auth()->user()->name)<=0){
            return view('pages.loginuser');                
        //}else{
            //return view('pages.menuuser.dashboarduser');
        //}
        //redirect()->intended('/dashboarduser');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->with('loginError', 'Username / Password Salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    //login untuk pendaftar siswa
    public function loginUser(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboarduser');
        }

        return redirect()->back()->with('loginError', 'Username / Password Salah!');
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
