<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagihanController extends Controller
{
    // Tampilkan semua tagihan
    public function index()
    {
        $tagihan = Tagihan::with('mitra.user')->orderBy('created_at', 'desc')->get();
        return view('admin.tagihan.index', compact('tagihan'));
    }

    // Form tambah tagihan
    public function create()
    {
        // Ambil semua mitra yang aktif
        $mitra = Mitra::whereHas('user', function ($query) {
            $query->where('status', 'aktif');
        })->with('user')->get();

        return view('admin.tagihan.create', compact('mitra'));
    }

    // Simpan tagihan baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mitra_id' => 'required|exists:mitra,id',
            'keterangan' => 'nullable|string',
            'harga_bandwidth' => 'required|numeric|min:0',
            'tanggal_tagihan' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
        ], [
            'mitra_id.required' => 'Mitra wajib dipilih',
            'mitra_id.exists' => 'Mitra tidak ditemukan',
            'harga_bandwidth.required' => 'Harga bandwidth wajib diisi',
            'harga_bandwidth.numeric' => 'Harga bandwidth harus berupa angka',
            'tanggal_tagihan.required' => 'Tanggal tagihan wajib diisi',
            'tanggal_jatuh_tempo.required' => 'Tanggal jatuh tempo wajib diisi',
            'tanggal_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus setelah atau sama dengan tanggal tagihan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Hitung total tagihan
        $totalTagihan = $request->harga_bandwidth;

        Tagihan::create([
            'mitra_id' => $request->mitra_id,
            'keterangan' => $request->keterangan,
            'harga_bandwidth' => $request->harga_bandwidth,
            'total_tagihan' => $totalTagihan,
            'sisa_tagihan' => $totalTagihan,
            'total_dibayar' => 0,
            'tanggal_tagihan' => $request->tanggal_tagihan,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'status_pembayaran' => 'belum_bayar',
        ]);

        return redirect('/admin/tagihan')
            ->with('success', 'Tagihan berhasil dibuat!');
    }

    // Detail tagihan
    public function show($id)
    {
        $tagihan = Tagihan::with(['mitra.user', 'pembayaran.accountBank', 'riwayatCicilan'])
            ->findOrFail($id);

        return view('admin.tagihan.detail', compact('tagihan'));
    }

    // Form edit tagihan
    public function edit($id)
    {
        $tagihan = Tagihan::with('mitra')->findOrFail($id);

        // Hanya bisa edit jika belum ada pembayaran
        if ($tagihan->pembayaran()->count() > 0) {
            return redirect('/admin/tagihan')
                ->with('error', 'Tagihan tidak dapat diedit karena sudah ada pembayaran!');
        }

        $mitra = Mitra::whereHas('user', function ($query) {
            $query->where('status', 'aktif');
        })->with('user')->get();

        return view('admin.tagihan.edit', compact('tagihan', 'mitra'));
    }

    // Update tagihan
    public function update(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);

        // Cek apakah sudah ada pembayaran
        if ($tagihan->pembayaran()->count() > 0) {
            return redirect('/admin/tagihan')
                ->with('error', 'Tagihan tidak dapat diupdate karena sudah ada pembayaran!');
        }

        $validator = Validator::make($request->all(), [
            'mitra_id' => 'required|exists:mitra,id',
            'keterangan' => 'nullable|string',
            'harga_bandwidth' => 'required|numeric|min:0',
            'tanggal_tagihan' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
        ], [
            'mitra_id.required' => 'Mitra wajib dipilih',
            'harga_bandwidth.required' => 'Harga bandwidth wajib diisi',
            'tanggal_tagihan.required' => 'Tanggal tagihan wajib diisi',
            'tanggal_jatuh_tempo.required' => 'Tanggal jatuh tempo wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $totalTagihan = $request->harga_bandwidth;

        $tagihan->update([
            'mitra_id' => $request->mitra_id,
            'keterangan' => $request->keterangan,
            'harga_bandwidth' => $request->harga_bandwidth,
            'total_tagihan' => $totalTagihan,
            'sisa_tagihan' => $totalTagihan,
            'tanggal_tagihan' => $request->tanggal_tagihan,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
        ]);

        return redirect('/admin/tagihan')
            ->with('success', 'Tagihan berhasil diupdate!');
    }
}
