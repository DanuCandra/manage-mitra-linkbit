<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        {
        $user = Auth::user();
        $mitra = $user->mitra; // Relasi user -> mitra

        if (!$mitra) {
            return redirect()->route('add_profile')->with('warning', 'Isi data mitra terlebih dahulu.');
        }

        // Total Pelanggan
        $totalPelanggan = $mitra->pelanggan()->count();

        // Total Pelanggan Aktif
        $pelangganAktif = $mitra->pelanggan()->where('status', 'aktif')->count();

        // Total Pelanggan Non-Aktif
        $pelangganNonAktif = $mitra->pelanggan()->where('status', 'non-aktif')->count();

        // Total Produk
        $totalProduk = $mitra->produk()->count();

        // Total Pendapatan Bulanan (dari pelanggan aktif)
        $pendapatanBulanan = $mitra->pelanggan()
            ->where('status', 'aktif')
            ->join('produk', 'pelanggan.produk_id', '=', 'produk.id')
            ->sum('produk.harga');

        // Pendapatan Bulan Ini (pelanggan yang mulai berlangganan bulan ini)
        $pendapatanBulanIni = $mitra->pelanggan()
            ->where('status', 'aktif')
            ->whereMonth('mulai_berlangganan', Carbon::now()->month)
            ->whereYear('mulai_berlangganan', Carbon::now()->year)
            ->join('produk', 'pelanggan.produk_id', '=', 'produk.id')
            ->sum('produk.harga');

        // Pelanggan Baru Bulan Ini
        $pelangganBaru = $mitra->pelanggan()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Produk Terlaris (produk dengan pelanggan terbanyak)
        $produkTerlaris = $mitra->produk()
            ->withCount('pelanggan')
            ->orderBy('pelanggan_count', 'desc')
            ->first();

        // Rata-rata harga produk
        $rataRataHargaProduk = $mitra->produk()->avg('harga');

        return view('mitra.dashboard', compact(
            'mitra',
            'totalPelanggan',
            'pelangganAktif',
            'pelangganNonAktif',
            'totalProduk',
            'pendapatanBulanan',
            'pendapatanBulanIni',
            'pelangganBaru',
            'produkTerlaris',
            'rataRataHargaProduk'
        ));
    }
    }




    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout!');
    }


}
