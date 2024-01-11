<?php

namespace App\Http\Controllers;
use app\Models\Pendaftar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //
    public function create()
    {
        return view('page.daftar-online');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => ['required','email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'password_confirmation' => ['required', 'min:8', 'confirmed']
        ]);

       $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            return redirect()->intended('home');
        }
    }
}
