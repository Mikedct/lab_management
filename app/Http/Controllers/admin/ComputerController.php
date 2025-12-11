<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComputerController extends Controller
{
    // Tampilkan form tambah komputer baru di lab tertentu
    public function create($labID)
    {
        $lab = DB::table('labpc')->where('labID', $labID)->first();

        if (!$lab) {
            return redirect()->route('admin.lab.index')
                             ->with('error', 'Lab tidak ditemukan');
        }

        return view('admin.dashboard.lab.computer.create', compact('lab'));
    }

    // Simpan komputer baru
    public function store(Request $request, $labID)
    {
        $lab = DB::table('labpc')->where('labID', $labID)->first();
        if (!$lab) {
            return redirect()->route('admin.lab.index')
                             ->with('error', 'Lab tidak ditemukan');
        }

        $request->validate([
            'computerName' => 'required|string|max:50',
            'status'       => 'required|in:Active,Inactive',
            'storage'      => 'required|numeric|min:1',
            'OS'           => 'required|string|max:50',
            'CPU'          => 'required|string|max:50',
            'GPU'          => 'required|string|max:50',
            'RAM'          => 'required|numeric|min:1',
        ], [
            'computerName.required' => 'Nama komputer wajib diisi',
            'status.required'       => 'Status wajib dipilih',
            'storage.required'      => 'Storage wajib diisi',
            'OS.required'           => 'OS wajib diisi',
            'CPU.required'          => 'CPU wajib diisi',
            'GPU.required'          => 'GPU wajib diisi',
            'RAM.required'          => 'RAM wajib diisi',
        ]);

        DB::table('komputer')->insert([
            'computerName' => $request->computerName,
            'status'       => $request->status,
            'storage'      => $request->storage,
            'OS'           => $request->OS,
            'CPU'          => $request->CPU,
            'GPU'          => $request->GPU,
            'RAM'          => $request->RAM,
            'labID'        => $labID,
        ]);

        return redirect()->route('admin.lab.show', $labID)
                         ->with('success', 'Komputer berhasil ditambahkan!');
    }

    // Tampilkan form edit komputer
    public function edit($labID, $computerID)
    {
        $lab = DB::table('labpc')->where('labID', $labID)->first();
        $computer = DB::table('komputer')->where('computerID', $computerID)->first();

        if (!$lab || !$computer) {
            return redirect()->route('admin.lab.show', $labID)
                             ->with('error', 'Lab atau komputer tidak ditemukan');
        }

        return view('admin.dashboard.lab.computer.edit', compact('lab', 'computer'));
    }

    // Update data komputer
    public function update(Request $request, $labID, $computerID)
    {
        $computer = DB::table('komputer')->where('computerID', $computerID)->first();
        if (!$computer) {
            return redirect()->route('admin.lab.show', $labID)
                             ->with('error', 'Komputer tidak ditemukan');
        }

        $request->validate([
            'computerName' => 'required|string|max:50',
            'status'       => 'required|in:Active,Inactive',
            'storage'      => 'required|numeric|min:1',
            'OS'           => 'required|string|max:50',
            'CPU'          => 'required|string|max:50',
            'GPU'          => 'required|string|max:50',
            'RAM'          => 'required|numeric|min:1',
        ]);

        DB::table('komputer')
            ->where('computerID', $computerID)
            ->update([
                'computerName' => $request->computerName,
                'status'       => $request->status,
                'storage'      => $request->storage,
                'OS'           => $request->OS,
                'CPU'          => $request->CPU,
                'GPU'          => $request->GPU,
                'RAM'          => $request->RAM,
            ]);

        return redirect()->route('admin.lab.show', $labID)
                         ->with('success', 'Komputer berhasil diupdate!');
    }

    // Hapus komputer
    public function destroy($labID, $computerID)
    {
        $computer = DB::table('komputer')->where('computerID', $computerID)->first();
        if (!$computer) {
            return redirect()->route('admin.lab.show', $labID)
                             ->with('error', 'Komputer tidak ditemukan');
        }

        DB::table('komputer')->where('computerID', $computerID)->delete();

        return redirect()->route('admin.lab.show', $labID)
                         ->with('success', 'Komputer berhasil dihapus!');
    }
}
