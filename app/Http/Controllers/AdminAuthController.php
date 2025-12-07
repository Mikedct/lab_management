<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Ambil admin berdasarkan email
        $admin = DB::table('admin')->where('email', $request->email)->first();

        if (!$admin) {
            return back()->withErrors(['login' => 'Email tidak ditemukan']);
        }

        // Cek password dengan MD5
        if (md5($request->password) !== $admin->password) {
            return back()->withErrors(['login' => 'Password salah']);
        }

        // Simpan session admin
        session([
            'adminID' => $admin->adminID,
            'adminName' => $admin->adminName
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        $komputers = DB::table('komputer')->get();
        return view('admin.dashboard', compact('dashboard'));
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('admin.auth.login');
    }
}
