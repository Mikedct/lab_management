<?php

namespace App\Http\Controllers\user\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserAuthController extends Controller
{
    // Tampilkan form login user
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard user
        if (session()->has('userID')) {
            return redirect()->route('user.dashboard');
        }
        
        return view('user.auth.login');
    }

    // Proses login user
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

        // Ambil user berdasarkan email
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['login' => 'Email tidak terdaftar'])
                ->withInput($request->only('email'));
        }

        // Cek apakah user aktif
        if ($user->status !== 'Active') {
            return back()
                ->withErrors(['login' => 'Akun Anda tidak aktif. Silakan hubungi admin.'])
                ->withInput($request->only('email'));
        }

        // Cek password dengan MD5
        if (md5($request->password) !== $user->password) {
            return back()
                ->withErrors(['login' => 'Password salah'])
                ->withInput($request->only('email'));
        }

        // Simpan session user
        session([
            'userID' => $user->userID,
            'userName' => $user->userName,
            'userEmail' => $user->email,
            'userRole' => $user->role,
            'isUserLoggedIn' => true,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Login berhasil!');
    }

    // Logout user
    public function logout(Request $request)
    {
        // Hapus semua session user
        session()->forget(['userID', 'userName', 'userEmail', 'userRole', 'isUserLoggedIn']);
        
        return redirect()->route('user.login')->with('success', 'Logout berhasil!');
    }
}
