<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LabController extends Controller
{
    // Tampilkan list lab
    public function index()
    {
        // Ambil semua data lab
        $labs = DB::table('labpc')->orderBy('labID', 'asc')->get();

        // Jika ingin ada statistik seperti UserController
        $data = [
            'labs' => $labs,
            'totalLabs' => $labs->count(),
            'totalPC' => $labs->sum('pcCount'),
        ];

        // View sementara hanya tampil tabel
        return view('admin.dashboard.lab.index', $data);
    }
}
