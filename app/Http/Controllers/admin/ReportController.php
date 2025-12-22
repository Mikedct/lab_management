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

        $statusNew = DB::table('reports')
            ->where('status', 'new')
            ->count();
        $statusInProgress = DB::table('reports')
            ->where('status', 'in_progress')
            ->count();
        $statusDone = DB::table('reports')
            ->where('status', 'done')
            ->count();


        return view('admin.dashboard.report.index', compact('reports','statusNew','statusInProgress', 'statusDone'));

        
    }

    public function edit($id)
    {
        $report = DB::table('reports')
            ->join('komputer', 'reports.computerID', '=', 'komputer.computerID')
            ->join('labPC', 'komputer.labID', '=', 'labPC.labID')
            ->select(
                'reports.*',
                'komputer.computerName',
                'labPC.labName',
                'labPC.labID'
            )
            ->where('reports.reportID', $id)
            ->first();

        if (!$report) {
            abort(404);
        }

        $labs = DB::table('labPC')->get();
        $computersByLab = DB::table('komputer')
            ->select('computerID', 'computerName', 'labID')
            ->get()
            ->groupBy('labID');

        return view('admin.dashboard.report.edit', compact('report', 'labs', 'computersByLab'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lab_id' => 'required',
            'computer_id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|image|max:2048',
            'status' => 'required|string', // admin bisa ubah status
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('reports', 'public');
        }

        DB::table('reports')
            ->where('reportID', $id)
            ->update([
                'computerID' => $request->computer_id,
                'title' => $request->title,
                'description' => $request->description,
                'attachment' => $path ?? DB::raw('attachment'),
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.reports.index')
            ->with('success', 'Laporan berhasil diperbarui oleh admin.');
    }

    public function destroy($id)
    {
        $report = DB::table('reports')->where('reportID', $id)->first();

        if (!$report) {
            abort(404);
        }

        DB::table('reports')->where('reportID', $id)->delete();

        return redirect()
            ->route('admin.reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function viewAttachment($id)
    {
        $report = DB::table('reports')->where('reportID', $id)->first();

        if (!$report || !$report->attachment) {
            return redirect()->back()
                ->with('error', 'Lampiran tidak ditemukan');
        }

        $path = $report->attachment;

        if (!Storage::disk('public')->exists($path)) {
            return redirect()->back()
                ->with('error', 'File lampiran tidak tersedia');
        }

        // cek ekstensi file
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        $imageExt = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($extension, $imageExt)) {
            // PREVIEW GAMBAR
            return response()->file(
                storage_path('app/public/' . $path)
            );
        }

        return redirect()->back()
            ->with('error', 'Lampiran bukan file gambar');
    }
}
