<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $users = User::all();
        return view('user.index', ['users' => $users, 'totalUser' => $totalUser]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        // Validate the request...
        $request->validate([
            'nama' => 'required|max:255',
            'username' => 'required|unique:users',
            'role' => 'required',
            'password' => 'required',
            'confirm-password' => 'required|same:password',
        ]);
        $user = User::create(
            [
                'username' => $request->username,
                'nama' => $request->nama,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]
        );

        if (!$user->wasRecentlyCreated) {
            return redirect()->route('user.create')->with('error', 'Gagal.');
        }

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request...
        $request->validate([
            'nama' => 'required|max:255',
            'username' => 'required|unique:users',
            'role' => 'required',
        ]);
        $user = User::find($id);
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->save();
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diubah.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
