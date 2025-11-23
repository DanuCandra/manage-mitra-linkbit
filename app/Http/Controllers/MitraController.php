<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MitraController extends Controller
{


    public function add_profile()
    {
        $user = Auth::user();

        if ($user && $user->mitra) {
            return redirect()->route('view_profile', ['id' => $user->mitra->id]);
        }

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
            'bandwidth' => 'nullable|string|max:100',
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
            'bandwidth' => $validated['bandwidth'] ?? null,
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
            'bandwidth' => 'nullable|string|max:100',
            'jml_karyawan' => 'nullable|integer',
        ]);

        $mitra->update($validated);

        return redirect()->route('view_profile', ['id' => $id])->with('success', 'Profil mitra berhasil diperbarui!');
    }

    public function view_profile($id)
    {
        $mitra = Mitra::findOrFail($id);
        return view('mitra.profile-mitra.view-profile', [
            'mitra' => $mitra,
        ]);
    }

    public function manage_setting()
    {
        $user = Auth::user();
        return view('mitra.setting.profile-setting', compact('user'));
    }

     public function update_setting(Request $request, $id)
    {
        // Validasi bahwa user hanya bisa edit profil sendiri
        if (Auth::id() != $id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengubah data ini');
        }

        $user = User::findOrFail($id);

        // Deteksi jenis form yang disubmit berdasarkan field yang ada

        // 1. FORM UPLOAD/DELETE FOTO PROFIL
        if ($request->hasFile('profile_photo') || ($request->has('delete_photo') && $request->delete_photo == '1')) {

            // Validasi khusus foto
            $request->validate([
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5124',
            ], [
                'profile_photo.max' => 'Ukuran foto maksimal 5MB',
                'profile_photo.image' => 'File harus berupa gambar',
                'profile_photo.mimes' => 'Format foto harus JPG, JPEG, PNG, atau GIF',
            ]);

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                // Hapus foto lama jika ada
                if ($user->profile_photo && Storage::disk('public')->exists('profile-foto/' . $user->profile_photo)) {
                    Storage::disk('public')->delete('profile-foto/' . $user->profile_photo);
                }

                // Upload foto baru
                $file = $request->file('profile_photo');
                $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                $file->storeAs('profile-foto', $filename, 'public');
                $user->profile_photo = $filename;
            }

            // Handle delete photo
            if ($request->has('delete_photo') && $request->delete_photo == '1') {
                if ($user->profile_photo && Storage::disk('public')->exists('profile-foto/' . $user->profile_photo)) {
                    Storage::disk('public')->delete('profile-foto/' . $user->profile_photo);
                }
                $user->profile_photo = null;
            }

            $user->save();
            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui');
        }

        // 2. FORM CHANGE PASSWORD
        elseif ($request->filled('current_password') || $request->filled('new_password')) {

            // Validasi khusus password
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:1|confirmed',
            ], [
                'new_password.confirmed' => 'Konfirmasi password tidak cocok',
                'new_password.min' => 'Password minimal 1 karakter',
                'current_password.required' => 'Password lama harus diisi',
            ]);

            // Verifikasi password lama
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'Password lama tidak sesuai'])
                    ->withInput();
            }

            $user->password = bcrypt($request->new_password);
            $user->save();

            return redirect()->back()->with('success', 'Password berhasil diubah');
        }

        // 3. FORM PERSONAL DETAILS
        else {

            // Validasi data personal
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'no_hp' => 'nullable|string|max:20',
            ]);

            // Update data basic
            $user->name = $request->name;
            $user->email = $request->email;
            $user->no_hp = $request->no_hp;

            $user->save();

            return redirect()->back()->with('success', 'Data personal berhasil diperbarui');
        }
    }


}
