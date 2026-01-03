<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('admin.users.manage-users', [
            'users' => $user,
        ]);
    }

    public function create()
    {
        return view('admin.users.add-user');
    }

    // Simpan data user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'alamat' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status' => $request->status ?? 'aktif',
            'role' => $request->role ?? 'mitra',
        ]);

        return redirect('manage-users')->with('success', 'User berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('manage-users')->with('success', 'User berhasil dihapus!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit-user', [
            'user' => $user,
        ]);
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable',
            'role' => 'required|in:admin,mitra',
            'status' => 'required|in:aktif,tidak-aktif',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->status = $validated['status'];
        $user->no_hp = $validated['no_hp'] ?? $user->no_hp;
        $user->alamat = $validated['alamat'] ?? $user->alamat;

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();
        return redirect('manage-users')->with('success', 'User berhasil diperbarui!');
    }
}
