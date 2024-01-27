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

        if (Auth::attempt($request->only('email', 'password'))){
            if(Auth::user()->role == "admin")
                return redirect('dashboard');
            if(Auth::user()->role == "user")
                return redirect('dashboarduser');
        }
        return redirect('login');
    }
}