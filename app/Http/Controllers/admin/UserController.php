<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tampilkan list users
    public function index()
    {
        $users = DB::table('users')->orderBy('created_at', 'desc')->get();
        
        $data = [
            'users' => $users,
            'totalUsers' => $users->count(),
            'activeUsers' => $users->where('status', 'Active')->count(),
            'inactiveUsers' => $users->where('status', '!=', 'Active')->count(),
        ];

        return view('admin.dashboard.users.index', $data);
    }

    // Tampilkan form create
    public function create()
    {
        return view('admin.dashboard.users.create');
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'userName' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:Mahasiswa,Dosen,Admin',
            'status' => 'required|in:Active,Inactive',
            'phone' => 'nullable|string|max:15',
        ], [
            'userName.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Role wajib dipilih',
        ]);

        DB::table('users')->insert([
            'userName' => $request->userName,
            'email' => $request->email,
            'password' => md5($request->password), // Gunakan MD5 sesuai sistem Anda
            'role' => $request->role,
            'status' => $request->status,
            'phone' => $request->phone,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.dashboard.users.index')
                         ->with('success', 'User berhasil ditambahkan!');
    }

    // Tampilkan detail user
    public function show($id)
    {
        $user = DB::table('users')->where('userID', $id)->first();

        if (!$user) {
            return redirect()->route('admin.dashboard.users.index')
                           ->with('error', 'User tidak ditemukan');
        }

        return view('admin.dashboard.users.show', compact('user'));
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $user = DB::table('users')->where('userID', $id)->first();

        if (!$user) {
            return redirect()->route('admin.dashboard.users.index')
                           ->with('error', 'User tidak ditemukan');
        }

        return view('admin.dashboard.users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $request->validate([
            'userName' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id . ',userID',
            'role' => 'required|in:Mahasiswa,Dosen,Admin',
            'status' => 'required|in:Active,Inactive',
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $updateData = [
            'userName' => $request->userName,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'phone' => $request->phone,
            'updated_at' => now(),
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = md5($request->password);
        }

        DB::table('users')
            ->where('userID', $id)
            ->update($updateData);

        return redirect()->route('admin.dashboard.users.index')
                         ->with('success', 'User berhasil diupdate!');
    }

    // Hapus user
    public function destroy($id)
    {
        DB::table('users')->where('userID', $id)->delete();

        return redirect()->route('admin.dashboard.users.index')
                         ->with('success', 'User berhasil dihapus!');
    }
}
