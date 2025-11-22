<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PelangganController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        // Ambil data mitra berdasarkan user yg login
        $mitra = Mitra::where('user_id', $user->id)->first();

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan isi data mitra terlebih dahulu.');
        }

        // AMBIL PRODUK PUNYA MITRA TERSEBUT
        $produk = Produk::where('mitra_id', $mitra->id)->get();

        return view('mitra.pelanggan-mitra.add-pelanggan', compact('produk'));
    }

    // SIMPAN DATA PELANGGAN
    public function store(Request $request)
    {
        $user = Auth::user();
        $mitra = Mitra::where('user_id', $user->id)->first();

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan isi data mitra terlebih dahulu.');
        }

        $request->validate([
            'id_pelanggan'        => 'nullable|string|max:255',
            'produk_id'           => 'required|exists:produk,id',
            'nama'                => 'required|string|max:255',
            'nik'                 => 'nullable|string|max:30',
            'alamat'              => 'nullable|string',
            'mulai_berlangganan'  => 'nullable|date',
            'status'              => 'required|in:aktif,non-aktif',
        ]);

        Pelanggan::create([
            'id_pelanggan'       => $request->id_pelanggan,
            'mitra_id'           => $mitra->id,
            'produk_id'          => $request->produk_id,
            'nama'               => $request->nama,
            'nik'                => $request->nik,
            'alamat'             => $request->alamat,
            'mulai_berlangganan' => $request->mulai_berlangganan,
            'status'             => $request->status,
        ]);

        return redirect()->route('pelanggan.manage')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function manage(Request $request)
    {
        $user = Auth::user();
        $mitra = Mitra::where('user_id', $user->id)->first();

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan isi data mitra terlebih dahulu.');
        }

        // Ambil nilai filter dari query (aktif / non-aktif / semua)
        $status = $request->get('status');

        $query = Pelanggan::where('mitra_id', $mitra->id)->with('produk');

        if ($status === 'aktif') {
            $query->where('status', 'aktif');
        } elseif ($status === 'non-aktif') {
            $query->where('status', 'non-aktif');
        }

        $pelanggan = $query->get();

        return view('mitra.pelanggan-mitra.manage-pelanggan', compact('pelanggan', 'status'));
    }


    public function edit($id)
    {
        $user = Auth::user();
        $mitra = Mitra::where('user_id', $user->id)->first();

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan isi data mitra terlebih dahulu.');
        }

        $pelanggan = Pelanggan::where('id', $id)->where('mitra_id', $mitra->id)->firstOrFail();

        // AMBIL PRODUK PUNYA MITRA TERSEBUT
        $produk = Produk::where('mitra_id', $mitra->id)->get();

        return view('mitra.pelanggan-mitra.edit-pelanggan', compact('pelanggan', 'produk'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $mitra = Mitra::where('user_id', $user->id)->first();

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan isi data mitra terlebih dahulu.');
        }

        $pelanggan = Pelanggan::where('id', $id)->where('mitra_id', $mitra->id)->firstOrFail();

        $request->validate([
            'id_pelanggan'        => 'nullable|string|max:255',
            'produk_id'           => 'required|exists:produk,id',
            'nama'                => 'required|string|max:255',
            'nik'                 => 'nullable|string|max:30',
            'alamat'              => 'nullable|string',
            'mulai_berlangganan'  => 'nullable|date',
            'status'              => 'required|in:aktif,non-aktif',
        ]);

        $pelanggan->update([
            'id_pelanggan'       => $request->id_pelanggan,
            'produk_id'          => $request->produk_id,
            'nama'               => $request->nama,
            'nik'                => $request->nik,
            'alamat'             => $request->alamat,
            'mulai_berlangganan' => $request->mulai_berlangganan,
            'status'             => $request->status,
        ]);

        return redirect()->route('pelanggan.manage')->with('success', 'Pelanggan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $mitra = Mitra::where('user_id', $user->id)->first();

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan isi data mitra terlebih dahulu.');
        }

        $pelanggan = Pelanggan::where('id', $id)->where('mitra_id', $mitra->id)->firstOrFail();
        $pelanggan->delete();

        return redirect()->route('pelanggan.manage')->with('success', 'Pelanggan berhasil dihapus');
    }

    public function view($id)
    {
        $user = Auth::user();
        $mitra = Mitra::where('user_id', $user->id)->first();

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan isi data mitra terlebih dahulu.');
        }

        $pelanggan = Pelanggan::where('id', $id)->where('mitra_id', $mitra->id)->with('produk')->firstOrFail();

        return view('mitra.pelanggan-mitra.view-pelanggan', compact('pelanggan'));
    }
}
