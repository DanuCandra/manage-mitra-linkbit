<?php

namespace App\Http\Controllers;

use App\Models\AccountBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountBankController extends Controller
{
    // Tampilkan semua account bank
    public function index()
    {
        $banks = AccountBank::orderBy('created_at', 'desc')->get();
        return view('admin.account-bank.index', compact('banks'));
    }

    // Form tambah account bank
    public function create()
    {
        return view('admin.account-bank.create');
    }

    // Simpan account bank baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:255',
            'atas_nama' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak-aktif',
        ], [
            'nama_bank.required' => 'Nama bank wajib diisi',
            'nomor_rekening.required' => 'Nomor rekening wajib diisi',
            'atas_nama.required' => 'Atas nama wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        AccountBank::create([
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'atas_nama' => $request->atas_nama,
            'status' => $request->status,
        ]);

        return redirect('/admin/account-bank')
            ->with('success', 'Account bank berhasil ditambahkan!');
    }

    // Form edit account bank
    public function edit($id)
    {
        $bank = AccountBank::findOrFail($id);
        return view('admin.account-bank.edit', compact('bank'));
    }

    // Update account bank
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:255',
            'atas_nama' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak-aktif',
        ], [
            'nama_bank.required' => 'Nama bank wajib diisi',
            'nomor_rekening.required' => 'Nomor rekening wajib diisi',
            'atas_nama.required' => 'Atas nama wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $bank = AccountBank::findOrFail($id);
        $bank->update([
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'atas_nama' => $request->atas_nama,
            'status' => $request->status,
        ]);

        return redirect('/admin/account-bank')
            ->with('success', 'Account bank berhasil diupdate!');
    }

    // Hapus account bank
    public function destroy($id)
    {
        $bank = AccountBank::findOrFail($id);

        // Cek apakah bank ini sudah digunakan di pembayaran
        if ($bank->pembayaran()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Account bank tidak dapat dihapus karena sudah digunakan dalam pembayaran!');
        }

        $bank->delete();

        return redirect('/admin/account-bank')
            ->with('success', 'Account bank berhasil dihapus!');
    }
}
