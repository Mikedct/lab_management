<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Komputer;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->has('adminID')) {
            return redirect()->route('admin.auth.login');
        }

        // Ambil data dari database menggunakan Query Builder
        $data = [
            'totalUsers' => DB::table('users')->count(),
            //'totalSchedules' => DB::table('schedules')->count(), // Sesuaikan nama tabel
            //'totalComputers' => DB::table('komputer')->count(),
            //'activeComputers' => DB::table('komputer')->where('status', 'Active')->count(),
        ];

        return view('admin.dashboard.dashboard', $data);
    }
}