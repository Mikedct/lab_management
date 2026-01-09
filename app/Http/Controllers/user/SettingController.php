<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the schedules.
     */
    public function index(Request $request)
    {
        // Cek apakah user sudah login
        if (!session()->has('userID')) {
            return redirect()->route('user.auth.login');
        }

        $query = DB::table('schedules');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('lab_name', 'like', "%{$search}%")
                  ->orWhere('instructor', 'like', "%{$search}%");
            });
        }

        // Lab filter
        if ($request->filled('lab_name')) {
            $query->where('lab_name', $request->lab_name);
        }

        // Day filter
        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $schedules = $query->orderBy('day')
                          ->orderBy('start_time')
                          ->paginate(10);

        // Get statistics
        $stats = [
            'total_schedules' => DB::table('schedules')->count(),
            'active_today' => DB::table('schedules')
                                ->where('status', 'active')
                                ->where('day', $this->getCurrentDay())
                                ->count(),
            'total_labs' => DB::table('schedules')
                             ->distinct('lab_name')
                             ->count('lab_name'),
            'utilization_rate' => $this->calculateUtilizationRate(),
        ];

        // Get unique labs for filter dropdown
        $labs = DB::table('schedules')
                  ->select('lab_name')
                  ->distinct()
                  ->orderBy('lab_name')
                  ->get();

        return view('user.dashboard.schedule.schedule', compact('schedules', 'stats', 'labs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!session()->has('userID')) {
            return redirect()->route('user.auth.login');
        }

        return view('user.dashboard.schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lab_name' => 'required|string|max:100',
            'subject' => 'required|string|max:255',
            'instructor' => 'required|string|max:100',
            'day' => 'required|in:Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, dan Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,cancelled',
            'notes' => 'nullable|string',
        ], [
            'lab_name.required' => 'Lab wajib dipilih',
            'subject.required' => 'Subject wajib diisi',
            'instructor.required' => 'Instructor wajib diisi',
            'day.required' => 'Hari wajib dipilih',
            'start_time.required' => 'Waktu mulai wajib diisi',
            'end_time.required' => 'Waktu selesai wajib diisi',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai',
            'max_capacity.required' => 'Kapasitas maksimal wajib diisi',
        ]);

        // Check for schedule conflicts
        $conflict = $this->checkScheduleConflict(
            $request->lab_name,
            $request->day,
            $request->start_time,
            $request->end_time
        );

        if ($conflict) {
            return back()->withErrors([
                'time' => 'Bentrok jadwal! Lab ini sudah digunakan pada waktu tersebut.'
            ])->withInput();
        }

        DB::table('schedules')->insert([
            'lab_name' => $request->lab_name,
            'subject' => $request->subject,
            'instructor' => $request->instructor,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'max_capacity' => $request->max_capacity,
            'participants' => 0,
            'status' => $request->status,
            'notes' => $request->notes,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('user.schedules.index')
                        ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!session()->has('userID')) {
            return redirect()->route('user.auth.login');
        }

        $schedule = DB::table('schedules')->where('scheduleID', $id)->first();

        if (!$schedule) {
            return redirect()->route('user.schedules.index')
                           ->with('error', 'Jadwal tidak ditemukan');
        }

        return view('user.dashboard.schedule.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!session()->has('userID')) {
            return redirect()->route('user.auth.login');
        }

        $schedule = DB::table('schedules')->where('scheduleID', $id)->first();

        if (!$schedule) {
            return redirect()->route('user.schedules.index')
                           ->with('error', 'Jadwal tidak ditemukan');
        }

        return view('user.dashboard.schedule.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'lab_name' => 'required|string|max:100',
            'subject' => 'required|string|max:255',
            'instructor' => 'required|string|max:100',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Check for schedule conflicts (excluding current schedule)
        $conflict = $this->checkScheduleConflict(
            $request->lab_name,
            $request->day,
            $request->start_time,
            $request->end_time,
            $id
        );

        if ($conflict) {
            return back()->withErrors([
                'time' => 'Bentrok jadwal! Lab ini sudah digunakan pada waktu tersebut.'
            ])->withInput();
        }

        DB::table('schedules')
            ->where('scheduleID', $id)
            ->update([
                'lab_name' => $request->lab_name,
                'subject' => $request->subject,
                'instructor' => $request->instructor,
                'day' => $request->day,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'max_capacity' => $request->max_capacity,
                'status' => $request->status,
                'notes' => $request->notes,
                'updated_at' => now(),
            ]);

        return redirect()->route('user.schedules.index')
                        ->with('success', 'Jadwal berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('schedules')->where('scheduleID', $id)->delete();

        return redirect()->route('user.schedules.index')
                        ->with('success', 'Jadwal berhasil dihapus!');
    }

    /**
     * Check for schedule conflicts
     */
    private function checkScheduleConflict($labName, $day, $startTime, $endTime, $excludeId = null)
    {
        $query = DB::table('schedules')
                   ->where('lab_name', $labName)
                   ->where('day', $day)
                   ->where('status', '!=', 'cancelled')
                   ->where(function($q) use ($startTime, $endTime) {
                       $q->whereBetween('start_time', [$startTime, $endTime])
                         ->orWhereBetween('end_time', [$startTime, $endTime])
                         ->orWhere(function($q) use ($startTime, $endTime) {
                             $q->where('start_time', '<=', $startTime)
                               ->where('end_time', '>=', $endTime);
                         });
                   });

        if ($excludeId) {
            $query->where('scheduleID', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Calculate lab utilization rate
     */
    private function calculateUtilizationRate()
    {
        $totalCapacity = DB::table('schedules')
                          ->where('status', 'active')
                          ->sum('max_capacity');
        
        $totalParticipants = DB::table('schedules')
                              ->where('status', 'active')
                              ->sum('participants');

        if ($totalCapacity == 0) {
            return 0;
        }

        return round(($totalParticipants / $totalCapacity) * 100, 1);
    }

    /**
     * Get current day in Indonesian
     */
    private function getCurrentDay()
    {
        $days = [
            'Monday' => 'Monday',
            'Tuesday' => 'Tuesday',
            'Wednesday' => 'Wednesday',
            'Thursday' => 'Thursday',
            'Friday' => 'Friday',
            'Saturday' => 'Saturday',
            'Sunday' => 'Sunday',
        ];

        return $days[date('l')] ?? 'Monday';
    }

    /**
     * Get available time slots for a lab on a specific day
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'lab_name' => 'required|string',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
        ]);

        $bookedSlots = DB::table('schedules')
                        ->where('lab_name', $request->lab_name)
                        ->where('day', $request->day)
                        ->where('status', '!=', 'cancelled')
                        ->get(['start_time', 'end_time']);

        return response()->json([
            'booked_slots' => $bookedSlots,
            'available_slots' => $this->calculateAvailableSlots($bookedSlots)
        ]);
    }

    /**
     * Calculate available time slots
     */
    private function calculateAvailableSlots($bookedSlots)
    {
        // Define working hours (e.g., 08:00 - 17:00)
        $workStart = '08:00';
        $workEnd = '17:00';
        $slotDuration = 120; // 2 hours in minutes

        $availableSlots = [];
        $currentTime = strtotime($workStart);
        $endTime = strtotime($workEnd);

        while ($currentTime < $endTime) {
            $slotStart = date('H:i', $currentTime);
            $slotEnd = date('H:i', $currentTime + ($slotDuration * 60));

            $isAvailable = true;
            foreach ($bookedSlots as $booked) {
                if ($this->timesOverlap($slotStart, $slotEnd, $booked->start_time, $booked->end_time)) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable && strtotime($slotEnd) <= $endTime) {
                $availableSlots[] = [
                    'start' => $slotStart,
                    'end' => $slotEnd,
                ];
            }

            $currentTime += ($slotDuration * 60);
        }

        return $availableSlots;
    }
    
    private function timesOverlap($start1, $end1, $start2, $end2)
    {
        return (strtotime($start1) < strtotime($end2)) && (strtotime($end1) > strtotime($start2));
    }
}