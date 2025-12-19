<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Tampilkan daftar laporan user
     */
    public function index()
    {
        $userId = session('userID');

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

        return view('user.report.index', compact('reports', 'userId'));
    }

    /**
     * Form buat laporan
     */
    public function create()
    {
        // Ambil semua lab
        $labs = DB::table('labs')
            ->orderBy('labName')
            ->get(['labID', 'labName']);

        // Ambil komputer dikelompokkan per lab
        $computers = DB::table('computers')
            ->orderBy('computerName')
            ->get(['computerID', 'computerName', 'lab_id']);

        $computersByLab = $computers->groupBy('lab_id');

        return view('user.report.create', compact('labs', 'computersByLab'));
    }

    /**
     * Simpan laporan
     */
    public function store(Request $request)
    {
        $request->validate([
            'lab_id' => 'required',
            'computer_id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|image|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('reports', 'public');
        }

        DB::table('reports')->insert([
            'user_id' => session('userID'),
            'lab_id' => $request->lab_id,
            'computer_id' => $request->computer_id,
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $path,
            'status' => 'new',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('user.reports.index')
            ->with('success', 'Laporan berhasil dikirim.');
    }

    /**
     * Detail laporan
     */
    public function show($id)
    {
        $userId = session('userID');

        $report = DB::table('reports')
            ->Join('komputer', 'reports.computerID', '=', 'komputer.computerID')
            ->Join('labPC', 'komputer.labID', '=', 'labPC.labID')
            ->where('reports.reportID', $id)
            ->where('reports.userID', $userId)
            ->select([
                'reports.*',
                'labPC.labName as lab_name',
                'komputer.computerName as computer_name',
            ])
            ->first();

        // if (!$report) {
        //     dd($report);
        //     abort(404);
        // }

        return view('user.report.show', compact('report'));
    }
}
