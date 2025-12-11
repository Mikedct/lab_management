<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LabController extends Controller
{
    // Tampilkan daftar lab
    public function index()
{
    // Ambil semua lab beserta jumlah komputer di tiap lab
    $labs = DB::table('labpc')
        ->leftJoin('komputer', 'labpc.labID', '=', 'komputer.labID')
        ->select(
            'labpc.labID',
            'labpc.labName',
            DB::raw('COUNT(komputer.computerID) as pcCount')
        )
        ->groupBy('labpc.labID', 'labpc.labName')
        ->orderBy('labpc.labID', 'asc')
        ->get();

    $totalLabs = $labs->count();
    $totalPC = $labs->sum('pcCount');

    return view('admin.dashboard.lab.index', compact('labs', 'totalLabs', 'totalPC'));
}


    // Tampilkan form create lab
    public function create()
    {
        return view('admin.dashboard.lab.create');
    }

    // Simpan lab baru
    public function store(Request $request)
    {
        $request->validate([
            'labName' => 'required|string|max:100',
        ], [
            'labName.required' => 'Nama Lab wajib diisi',
        ]);

        DB::table('labs')->insert([
            'labName' => $request->labName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.dashboar.lab.index')
                         ->with('success', 'Lab berhasil ditambahkan!');
    }

    // Tampilkan detail lab + daftar komputer
    public function show($id)
    {
        $lab = DB::table('labpc')->where('labID', $id)->first();

        if (!$lab) {
            return redirect()->route('admin.dashboard.lab.index')
                             ->with('error', 'Lab tidak ditemukan');
        }

        $computers = DB::table('komputer')
                       ->where('labID', $id)
                       ->orderBy('computerID', 'asc')
                       ->get();

        return view('admin.dashboard.lab.show', compact('lab', 'computers'));
    }

    // Tampilkan form edit lab
    public function edit($id)
    {
        $lab = DB::table('labpc')->where('labID', $id)->first();

        if (!$lab) {
            return redirect()->route('admin.dashboard.lab.index')
                             ->with('error', 'Lab tidak ditemukan');
        }

        return view('admin.dashboard.lab.edit', compact('lab'));
    }

    // Update data lab
    public function update(Request $request, $id)
    {
        $request->validate([
            'labName' => 'required|string|max:100',
        ], [
            'labName.required' => 'Nama Lab wajib diisi',
        ]);

        DB::table('labpc')
            ->where('labID', $id)
            ->update([
                'labName' => $request->labName,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.dashboard.lab.index')
                         ->with('success', 'Lab berhasil diupdate!');
    }

    // Hapus lab
    public function destroy($id)
    {
        // Hapus semua komputer di lab ini terlebih dahulu (opsional)
        DB::table('komputer')->where('labID', $id)->delete();

        DB::table('labpc')->where('labID', $id)->delete();

        return redirect()->route('admin.dashboard.lab.index')
                         ->with('success', 'Lab berhasil dihapus!');
    }
}
