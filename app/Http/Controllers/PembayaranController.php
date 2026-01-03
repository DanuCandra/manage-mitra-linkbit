<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\RiwayatCicilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    // Index - List semua pembayaran (dengan filter status)
    public function index(Request $request)
    {
        $query = Pembayaran::with(['tagihan.mitra', 'accountBank']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_verifikasi', $request->status);
        }

        // Filter by jenis pembayaran
        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis_pembayaran', $request->jenis);
        }

        // Search by nomor pembayaran atau nama mitra
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_pembayaran', 'like', "%{$search}%")
                    ->orWhereHas('tagihan.mitra', function ($q2) use ($search) {
                        $q2->where('nama_mitra', 'like', "%{$search}%");
                    });
            });
        }

        $pembayaran = $query->orderBy('created_at', 'desc')->get();

        // Count by status untuk badge
        $pendingCount = Pembayaran::pending()->count();
        $diterimaCount = Pembayaran::diterima()->count();
        $ditolakCount = Pembayaran::ditolak()->count();

        return view('admin.pembayaran.index', compact('pembayaran', 'pendingCount', 'diterimaCount', 'ditolakCount'));
    }

    // Detail pembayaran
    public function show($id)
    {
        $pembayaran = Pembayaran::with([
            'tagihan.mitra',
            'accountBank',
            'verifiedBy',
            'riwayatCicilan'
        ])->findOrFail($id);

        return view('admin.pembayaran.detail', compact('pembayaran'));
    }

    // Verifikasi (Terima) pembayaran
    public function verifikasi(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $tagihan = $pembayaran->tagihan;

        // Update pembayaran
        $pembayaran->status_verifikasi = 'diterima';
        $pembayaran->tanggal_verifikasi = now();
        $pembayaran->verified_by = Auth::id();
        $pembayaran->save();

        // Update tagihan
        $tagihan->total_dibayar += $pembayaran->jumlah_bayar;
        $tagihan->sisa_tagihan -= $pembayaran->jumlah_bayar;

        // Update status tagihan
        if ($tagihan->sisa_tagihan <= 0) {
            $tagihan->status_pembayaran = 'lunas';
            $tagihan->sisa_tagihan = 0;
        } else {
            $tagihan->status_pembayaran = 'cicilan';
        }
        $tagihan->save();

        // Catat riwayat cicilan (jika cicilan)
        if ($pembayaran->jenis_pembayaran === 'cicilan') {
            $cicilanKe = RiwayatCicilan::where('tagihan_id', $tagihan->id)->count() + 1;

            RiwayatCicilan::create([
                'tagihan_id' => $tagihan->id,
                'pembayaran_id' => $pembayaran->id,
                'cicilan_ke' => $cicilanKe,
                'jumlah_cicilan' => $pembayaran->jumlah_bayar,
                'tanggal_cicilan' => $pembayaran->tanggal_bayar,
                'status' => 'diterima',
            ]);
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi dan diterima!');
    }

    // Tolak pembayaran
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string|max:500',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        $pembayaran->status_verifikasi = 'ditolak';
        $pembayaran->alasan_ditolak = $request->alasan_ditolak;
        $pembayaran->tanggal_verifikasi = now();
        $pembayaran->verified_by = Auth::id();
        $pembayaran->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil ditolak!');
    }
}
