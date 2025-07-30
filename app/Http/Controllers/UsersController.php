<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $user = User::with('role')->get();
        return view('users.manage-users', [
            'users' => $user,
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        // dd($roles);
        return view('users.add-user', compact('roles'));
    }

    // Simpan data user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'no_hp' => 'required',
            'role_id' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'role_id' => $request->role_id,
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
}
