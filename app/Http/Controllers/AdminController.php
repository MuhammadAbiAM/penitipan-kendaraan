<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function usersIndex()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function usersCreate()
    {
        return view('admin.users.create');
    }

    public function usersStore(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|regex:/^[A-Za-z0-9]+$/',
            'email'    => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (User::where('username', $request->username)->exists()) {
            return back()->withErrors([
                'username' => 'Username ini sudah digunakan. Silakan pilih username lain.'
            ])->withInput();
        }

        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors([
                'email' => 'Email ini sudah terdaftar. Gunakan email lain.'
            ])->withInput();
        }

        User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function usersShow($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function usersEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|regex:/^[A-Za-z0-9]+$/',
            'email'    => 'required|email',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (User::where('username', $request->username)
            ->where('id', '!=', $id)
            ->exists()
        ) {
            return back()->withErrors([
                'username' => 'Username ini sudah digunakan. Silakan pilih username lain.'
            ])->withInput();
        }

        if (User::where('email', $request->email)
            ->where('id', '!=', $id)
            ->exists()
        ) {
            return back()->withErrors([
                'email' => 'Email ini sudah terdaftar. Gunakan email lain.'
            ])->withInput();
        }

        $data = $request->only(['username', 'email', 'role']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function usersDestroy($id)
    {
        if ($id == Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus!');
    }
}
