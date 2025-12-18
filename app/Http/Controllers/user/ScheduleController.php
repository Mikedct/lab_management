<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar
        $query = DB::table('schedules');

        // Filter Lab
        if ($request->filled('lab_name')) {
            $query->where('lab_name', $request->lab_name);
        }

        // Filter Hari
        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        // HANYA tampilkan jadwal aktif / berjalan
        $schedules = $query
            ->orderBy('day')
            ->orderBy('start_time')
            ->get([
                'lab_name',
                'day',
                'start_time',
                'end_time',
                'subject as course',
                'instructor as lecturer',
                'status',
            ]);

        // Data dropdown Lab
        $labs = DB::table('schedules')
            ->select('lab_name')
            ->distinct()
            ->orderBy('lab_name')
            ->get();

        return view('user.Schedule.index', compact('schedules', 'labs'));
    }
}
