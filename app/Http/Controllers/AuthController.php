<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        if (Auth::check() && !session()->has('error')) {
        return $this->redirectToDashboard();
    }

    return view('login');
    }

    /**
     * Proses login user
     */
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // mencegah session fixation
            session()->flash('success', 'Login berhasil!');

            return $this->redirectToDashboard();
        }


        return back()->with('error','Email atau Password Salah!');
    }

       protected function redirectToDashboard()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin-dashboard')->with('success', 'Selamat datang Admin!');
        }

        if ($user->role === 'mitra') {
            return redirect()->route('mitra-dashboard')->with('success', 'Selamat datang Mitra!');
        }

        // fallback

        return redirect('/login')->with('error', 'Role tidak dikenali.');
    }


    public function admin_dashboard()
    {
        return view('admin.dashboard');
    }
    public function mitra_dashboard()
    {
        return view('mitra.dashboard');
    }




    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout!');
    }
}
