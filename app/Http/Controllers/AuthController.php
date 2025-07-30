<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            
            session()->flash('success', 'Login berhasil!');
            return redirect('/dashboard');
        }

        // Jika gagal login
        session()->flash('error', 'Email atau password salah!');
        return back();
    }


    public function dashboard()
    {
        return view('dashboard.home-superadmin');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Berhasil logout!');
    }
}
