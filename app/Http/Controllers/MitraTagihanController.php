<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraTagihanController extends Controller
{
    // Index - List tagihan mitra dengan pagination
    public function index()
    {
        $mitra = Auth::user()->mitra;

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan lengkapi profil mitra terlebih dahulu!');
        }

        $tagihan = Tagihan::where('mitra_id', $mitra->id)
            ->with(['pembayaran'])
            ->orderBy('tanggal_tagihan', 'desc')
            ->paginate(10);

        // Stats - hanya tagihan yang belum lunas
        $tagihanAktif = Tagihan::where('mitra_id', $mitra->id)
            ->whereIn('status_pembayaran', ['belum_bayar', 'cicilan', 'terlambat'])
            ->get();

        $totalTagihan = $tagihanAktif->sum('total_tagihan');
        $totalDibayar = $tagihanAktif->sum('total_dibayar');
        $totalSisa = $tagihanAktif->sum('sisa_tagihan');
        $tagihanBelumBayar = $tagihanAktif->where('status_pembayaran', 'belum_bayar')->count();

        return view('mitra.tagihan.index', compact('tagihan', 'totalTagihan', 'totalDibayar', 'totalSisa', 'tagihanBelumBayar'));
    }
    public function show($id)
    {
        $mitra = Auth::user()->mitra;

        if (!$mitra) {
            return redirect()->route('add_profile')->with('error', 'Silakan lengkapi profil mitra terlebih dahulu!');
        }

        $tagihan = Tagihan::with(['mitra', 'pembayaran.accountBank', 'riwayatCicilan'])
            ->where('id', $id)
            ->where('mitra_id', $mitra->id)
            ->firstOrFail();

        return view('mitra.tagihan.detail', compact('tagihan'));
    }
}
