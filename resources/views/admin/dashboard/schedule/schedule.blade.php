<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lab Schedule Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { background-color: #f8f9fa; }
        .page-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 30px 0;
            margin-bottom: 30px;
            color: white;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }
    </style>
</head>

<body>
@include('layouts.partials.admin-navbar')

<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h3><i class="bi bi-calendar-event me-2"></i>Lab Schedule</h3>
            <small>Manajemen jadwal penggunaan lab</small>
        </div>

        <!-- ✅ BUTTON KE CREATE -->
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-light">
            <i class="bi bi-plus-circle me-1"></i> Add New Schedule
        </a>
    </div>
</div>

<div class="container-fluid px-4">

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- STAT --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <h4>{{ $stats['total_schedules'] }}</h4>
                <small>Total Schedules</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h4>{{ $stats['active_today'] }}</h4>
                <small>Active Today</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h4>{{ $stats['total_labs'] }}</h4>
                <small>Total Labs</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h4>{{ $stats['utilization_rate'] }}%</h4>
                <small>Utilization</small>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">
            Schedule List
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Lab</th>
                        <th>Subject</th>
                        <th>Instructor</th>
                        <th>Participants</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->day }}</td>
                        <td>{{ substr($schedule->start_time,0,5) }} - {{ substr($schedule->end_time,0,5) }}</td>
                        <td>{{ $schedule->lab_name }}</td>
                        <td>{{ $schedule->subject }}</td>
                        <td>{{ $schedule->instructor }}</td>
                        <td>{{ $schedule->participants }}/{{ $schedule->max_capacity }}</td>
                        <td>
                            <span class="badge bg-{{ $schedule->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($schedule->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.schedules.edit', $schedule->scheduleID) }}"
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('admin.schedules.destroy', $schedule->scheduleID) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus jadwal ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-calendar-x fs-1 text-muted"></i>
                            <p class="mt-2">Belum ada jadwal</p>

                            <!-- ✅ BUTTON KE CREATE -->
                            <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Jadwal
                            </a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($schedules->hasPages())
            <div class="card-footer bg-white">
                {{ $schedules->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
