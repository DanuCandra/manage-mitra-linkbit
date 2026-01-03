<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\AccountBank;
use App\Models\RiwayatCicilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MitraPembayaranController extends Controller
{
    // Index - List tagihan yang belum lunas untuk dibayar
    public function index()
    {
        $mitra = Auth::user()->mitra;

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan lengkapi profil mitra terlebih dahulu!');
        }

        // Tagihan yang belum lunas
        $tagihanBelumLunas = Tagihan::where('mitra_id', $mitra->id)
            ->whereIn('status_pembayaran', ['belum_bayar', 'cicilan', 'terlambat'])
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->get();

        return view('mitra.pembayaran.index', compact('tagihanBelumLunas'));
    }

    // Create - Form pembayaran
    public function create($tagihan_id)
    {
        $mitra = Auth::user()->mitra;

        $tagihan = Tagihan::where('id', $tagihan_id)
            ->where('mitra_id', $mitra->id)
            ->firstOrFail();

        // Cek apakah sudah lunas
        if ($tagihan->status_pembayaran === 'lunas') {
            return redirect()->route('mitra.pembayaran.index')
                ->with('error', 'Tagihan ini sudah lunas!');
        }

        // Ambil bank aktif
        $banks = AccountBank::aktif()->get();

        if ($banks->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada rekening bank yang tersedia. Hubungi admin!');
        }

        return view('mitra.pembayaran.create', compact('tagihan', 'banks'));
    }

    // Store - Simpan pembayaran
    public function store(Request $request)
    {
        $request->validate([
            'tagihan_id' => 'required|exists:tagihan,id',
            'account_bank_id' => 'required|exists:account_bank,id',
            'jenis_pembayaran' => 'required|in:full,cicilan',
            'jumlah_bayar' => 'required|numeric|min:1',
            'tanggal_bayar' => 'required|date',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama_pengirim' => 'required|string|max:255',
            'bank_pengirim' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:500',
        ]);

        $mitra = Auth::user()->mitra;
        $tagihan = Tagihan::where('id', $request->tagihan_id)
            ->where('mitra_id', $mitra->id)
            ->firstOrFail();

        // Validasi jumlah bayar
        if ($request->jenis_pembayaran === 'full') {
            if ($request->jumlah_bayar < $tagihan->sisa_tagihan) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Jumlah bayar untuk FULL harus sama dengan sisa tagihan: ' . $tagihan->sisa_format);
            }
        } else {
            // Cicilan
            if ($request->jumlah_bayar > $tagihan->sisa_tagihan) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Jumlah cicilan tidak boleh melebihi sisa tagihan: ' . $tagihan->sisa_format);
            }
        }

        // Upload bukti bayar
        $buktiPath = $request->file('bukti_bayar')->store('bukti_bayar', 'public');

        // Simpan pembayaran
        $pembayaran = Pembayaran::create([
            'tagihan_id' => $tagihan->id,
            'account_bank_id' => $request->account_bank_id,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'bukti_bayar' => $buktiPath,
            'nama_pengirim' => $request->nama_pengirim,
            'bank_pengirim' => $request->bank_pengirim,
            'catatan' => $request->catatan,
            'status_verifikasi' => 'pending',
        ]);

        return redirect()->route('mitra.riwayat-pembayaran')
            ->with('success', 'Pembayaran berhasil dikirim! Menunggu verifikasi admin.');
    }

    // Riwayat - List semua pembayaran mitra
    public function riwayat()
    {
        $mitra = Auth::user()->mitra;

        $pembayaran = Pembayaran::whereHas('tagihan', function ($query) use ($mitra) {
            $query->where('mitra_id', $mitra->id);
        })
            ->with(['tagihan', 'accountBank', 'verifiedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Stats
        $totalPending = $pembayaran->where('status_verifikasi', 'pending')->count();
        $totalDiterima = $pembayaran->where('status_verifikasi', 'diterima')->count();
        $totalDitolak = $pembayaran->where('status_verifikasi', 'ditolak')->count();

        return view('mitra.pembayaran.riwayat', compact('pembayaran', 'totalPending', 'totalDiterima', 'totalDitolak'));
    }

    // Detail pembayaran
    public function detailPembayaran($id)
    {
        $mitra = Auth::user()->mitra;

        $pembayaran = Pembayaran::whereHas('tagihan', function ($query) use ($mitra) {
            $query->where('mitra_id', $mitra->id);
        })
            ->with(['tagihan', 'accountBank', 'verifiedBy', 'riwayatCicilan'])
            ->findOrFail($id);

        return view('mitra.pembayaran.detail', compact('pembayaran'));
    }
}
