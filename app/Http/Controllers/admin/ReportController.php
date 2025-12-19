<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {

        $reports = DB::table('reports')
            ->join('komputer', 'reports.computerID', '=', 'komputer.computerID')
            ->join('labPC', 'komputer.labID', '=', 'labPC.labID')
            ->select(
                'reports.*',
                'komputer.computerName',   // contoh field di komputer
                'labPC.labName'             // field yang ingin ditambahkan
            )
            ->orderBy('reports.updated_at')
            ->get();
        return view('admin.dashboard.report.index', compact('reports'));
    }
}
