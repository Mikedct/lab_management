<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Show settings page
     */
    public function index()
    {
        if (!session()->has('adminID')) {
            return redirect()->route('admin.auth.login');
        }

        $admin = DB::table('admin')
                  ->where('adminID', session('adminID'))
                  ->first();

        if (!$admin) {
            session()->flush();
            return redirect()->route('admin.auth.login')
                           ->with('error', 'Admin tidak ditemukan');
        }

        return view('admin.dashboard.settings.index', compact('admin'));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        if (!session()->has('adminID')) {
            return redirect()->route('admin.auth.login');
        }

        $request->validate([
            'adminName' => 'required|string|max:100',
            'email' => 'required|email|unique:admin,email,' . session('adminID') . ',adminID',
            'phoneNumber' => 'required|string|max:15',
        ], [
            'adminName.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan',
        ]);

        $updateData = [
            'adminName' => $request->adminName,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
        ];

        // If phoneNumber is null, set empty string or handle based on your DB constraint
        if (is_null($updateData['phoneNumber'])) {
            $updateData['phoneNumber'] = ''; // or remove this key if column allows NULL
        }

        DB::table('admin')
          ->where('adminID', session('adminID'))
          ->update($updateData);

        // Update session
        session(['adminName' => $request->adminName]);
        session(['adminEmail' => $request->email]);

        return back()->with('success', 'Profil berhasil diupdate!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        if (!session()->has('adminID')) {
            return redirect()->route('admin.auth.login');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $admin = DB::table('admin')
                  ->where('adminID', session('adminID'))
                  ->first();

        // Check current password
        if (md5($request->current_password) !== $admin->password) {
            return back()->withErrors(['current_password' => 'Password lama salah']);
        }

        // Update password
        DB::table('admin')
          ->where('adminID', session('adminID'))
          ->update([
              'password' => md5($request->new_password),
          ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}