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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'no_hp' => 'required',
            'role' => 'required',
            'status' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'role' => $request->role,
            'status' => $request->status,
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
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->status = $validated['status'];
        $user->no_hp = $validated['no_hp'] ?? $user->no_hp;

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();
        return redirect('manage-users')->with('success', 'User berhasil diperbarui!');
    }
}
