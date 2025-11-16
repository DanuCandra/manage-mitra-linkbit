<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function manage_produk()
    {
        // 1. Ambil user login
        $user = Auth::user();

        // 2. Cari mitra berdasarkan user_id
        $mitra = Mitra::where('user_id', $user->id)->first();

        // Jika mitra belum diisi → redirect ke form tambah profil
        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan isi data mitra terlebih dahulu.');
        }

        // 3. Ambil produk milik mitra login
        $produk = Produk::where('mitra_id', $mitra->id)->get();

        // 4. Kirim ke view
        return view('mitra.produk-mitra.manage-produk', compact('produk'));
    }

    public function create()
    {
        $user = Auth::user();
        $mitra = Mitra::where('user_id', $user->id)->first();

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan isi data mitra terlebih dahulu.');
        }

        return view('mitra.produk-mitra.add-produk');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $mitra = Mitra::where('user_id', $user->id)->first();

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan isi data mitra terlebih dahulu.');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'bandwidth' => 'required|string|max:255',
            'harga' => 'required', // jangan numeric, karena ada format 150.000
        ]);

        // Bersihkan semua karakter selain angka
        $harga = preg_replace('/[^0-9]/', '', $request->harga);

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'bandwidth'   => $request->bandwidth,
            'harga'       => (int) $harga,
            'mitra_id'    => $mitra->id,
        ]);

        return redirect()->route('produk.manage')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.manage')->with('success', 'Produk berhasil dihapus.');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('mitra.produk-mitra.edit-produk', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'bandwidth' => 'required|string|max:255',
            'harga' => 'required', 
        ]);

        // Bersihkan semua karakter selain angka
        $harga = preg_replace('/[^0-9]/', '', $request->harga);

        $produk = Produk::findOrFail($id);
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'bandwidth'   => $request->bandwidth,
            'harga'       => (int) $harga,
        ]);

        return redirect()->route('produk.manage')->with('success', 'Produk berhasil diperbarui.');
    }
}
