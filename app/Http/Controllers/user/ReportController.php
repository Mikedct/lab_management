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
            ->leftJoin('labs', 'reports.lab_id', '=', 'labs.labID')
            ->leftJoin('computers', 'reports.computer_id', '=', 'computers.computerID')
            ->where('reports.user_id', $userId)
            ->orderByDesc('reports.created_at')
            ->select([
                'reports.id',
                'reports.title',
                'reports.status',
                'reports.created_at',
                'labs.labName as lab_name',
                'computers.computerName as computer_name',
            ])
            ->get();

        return view('user.report.index', compact('reports'));
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
            'lab_id'       => 'required',
            'computer_id'  => 'required',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'attachment'   => 'nullable|image|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('reports', 'public');
        }

        DB::table('reports')->insert([
            'user_id'     => session('userID'),
            'lab_id'      => $request->lab_id,
            'computer_id' => $request->computer_id,
            'title'       => $request->title,
            'description' => $request->description,
            'attachment'  => $path,
            'status'      => 'new',
            'created_at'  => now(),
            'updated_at'  => now(),
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
            ->leftJoin('labs', 'reports.lab_id', '=', 'labs.labID')
            ->leftJoin('computers', 'reports.computer_id', '=', 'computers.computerID')
            ->where('reports.id', $id)
            ->where('reports.user_id', $userId)
            ->select([
                'reports.*',
                'labs.labName as lab_name',
                'computers.computerName as computer_name',
            ])
            ->first();

        if (!$report) {
            abort(404);
        }

        return view('user.report.show', compact('report'));
    }
}
