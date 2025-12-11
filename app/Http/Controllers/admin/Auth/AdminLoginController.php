<?php
// app/Http/Controllers/AdminAuthController.php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->has('adminID')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Ambil admin berdasarkan email
        $admin = DB::table('admin')->where('email', $request->email)->first();

        if (!$admin) {
            return back()
                ->withErrors(['login' => 'Email tidak ditemukan'])
                ->withInput($request->only('email'));
        }

        // Cek password dengan MD5
        if (md5($request->password) !== $admin->password) {
            return back()
                ->withErrors(['login' => 'Password salah'])
                ->withInput($request->only('email'));
        }

        // Simpan session admin
        session([
            'adminID' => $admin->adminID,
            'adminName' => $admin->adminName,
            'adminEmail' => $admin->email,
            'isLoggedIn' => true,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
    }

    // Logout
    public function logout(Request $request)
    {
        session()->flush();
        return redirect()->route('admin.auth.login')->with('success', 'Logout berhasil!');
    }
}