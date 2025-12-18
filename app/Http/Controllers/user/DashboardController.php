<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->has('userID')) {
            return redirect()->route('user.login');
        }

        $userID = session('userID');
        
        // Ambil data user
        $user = DB::table('users')->where('userID', $userID)->first();
        
        // Ambil statistik (sesuaikan dengan kebutuhan)
        $data = [
            'user' => $user,
            // 'totalBookings' => 0, // Nanti bisa diisi dari tabel booking
            // 'activeBookings' => 0,
            // 'totalComputers' => DB::table('komputer')->where('status', 'Active')->count(),
        ];

        return view('user.dashboard', $data);
    }
}
