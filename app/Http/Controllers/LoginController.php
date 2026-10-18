<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginaksi(Request $request)
    {
        $cred = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($cred, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Kembali ke halaman asal, modal dibuka lagi dengan pesan error
        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email')
            ->with('buka_login', true);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/beranda');
    }
}
