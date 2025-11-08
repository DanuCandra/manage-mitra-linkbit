<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraController extends Controller
{


    public function add_profile()
    {
        return view('mitra.profile-mitra.add-profile');
    }

    public function store_profile(Request $request)
    {

        $user = Auth::user();

        // Cek apakah user sudah punya profil mitra
        if ($user->mitra) {
            return back()->with('error', 'Anda sudah memiliki profil mitra. Tidak dapat membuat profil baru.');
        }
        $validated = $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'nik' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'npwp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'alamat_usaha' => 'nullable|string',
            'nama_brand' => 'nullable|string|max:255',
            'no_nib' => 'nullable|string|max:100',
            'no_sertif_standar' => 'nullable|string|max:100',
            'tikor' => 'nullable|string|max:255',
            'bandwith' => 'nullable|string|max:100',
            'jml_karyawan' => 'nullable|integer',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();


        Mitra::create([
            'user_id' => $user->id,
            'nama_mitra' => $validated['nama_mitra'],
            'nik' => $validated['nik'] ?? null,
            'tgl_lahir' => $validated['tgl_lahir'] ?? null,
            'npwp' => $validated['npwp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'alamat_usaha' => $validated['alamat_usaha'] ?? null,
            'nama_brand' => $validated['nama_brand'] ?? null,
            'no_nib' => $validated['no_nib'] ?? null,
            'no_sertif_standar' => $validated['no_sertif_standar'] ?? null,
            'tikor' => $validated['tikor'] ?? null,
            'bandwith' => $validated['bandwith'] ?? null,
            'jml_karyawan' => $validated['jml_karyawan'] ?? null,
        ]);

        return redirect()->route('add_profile')->with('success', 'Profil mitra berhasil disimpan!');
    }

    public function edit_profile($id)
    {
        $mitra = Mitra::findOrFail($id);
        return view('mitra.profile-mitra.edit-profile', [
            'mitra' => $mitra,
        ]);
    }

    public function update_profile($id, Request $request)
    {

        $mitra = Mitra::findOrFail($id);

        $validated = $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'nik' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'npwp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'alamat_usaha' => 'nullable|string',
            'nama_brand' => 'nullable|string|max:255',
            'no_nib' => 'nullable|string|max:100',
            'no_sertif_standar' => 'nullable|string|max:100',
            'tikor' => 'nullable|string|max:255',
            'bandwith' => 'nullable|string|max:100',
            'jml_karyawan' => 'nullable|integer',
        ]);

        $mitra->update($validated);

        return redirect()->route('edit_profile', ['id' => $id])->with('success', 'Profil mitra berhasil diperbarui!');
    }

    public function view_profile($id)
    {
        $mitra = Mitra::findOrFail($id);
        return view('mitra.profile-mitra.view-profile', [
            'mitra' => $mitra,
        ]);
    }
}
