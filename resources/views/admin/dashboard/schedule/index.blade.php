{{-- resources/views/admin/dashboard/schedule/schedule.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lab Schedule Management</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 30px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .table> :not(caption)>*>* {
            padding: 0.75rem 0.5rem;
        }
        
        .btn-light {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
        }
        
        .btn-light:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        
        .progress {
            background-color: #e9ecef;
        }
        
        .badge {
            padding: 0.375rem 0.75rem;
            font-weight: 500;
        }
        
        .card {
            border-radius: 0.5rem;
        }
        
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .stat-card-small {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .stat-card-small:hover {
            transform: translateY(-3px);
        }

        .stat-icon-small {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            margin-right: 15px;
        }

        .stat-icon-small.pink { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-icon-small.green { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .stat-icon-small.orange { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
        .stat-icon-small.blue { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 64px;
            color: #ddd;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    @include('layouts.partials.admin-navbar')

    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2><i class="bi bi-calendar-event me-2"></i>Lab Schedule Management</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}" style="color: rgba(255,255,255,0.8);">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" style="color: white;">Schedules</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                        <i class="bi bi-plus-circle me-1"></i>Add New Schedule
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4 py-3">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.schedules.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Search</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search schedule..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Lab</label>
                            <select name="lab_name" class="form-select">
                                <option value="">All Labs</option>
                                @foreach($labs as $lab)
                                    <option value="{{ $lab->lab_name }}" 
                                            {{ request('lab_name') == $lab->lab_name ? 'selected' : '' }}>
                                        {{ $lab->lab_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Day</label>
                            <select name="day" class="form-select">
                                <option value="">All Days</option>
                                <option value="Senin" {{ request('day') == 'Senin' ? 'selected' : '' }}>Senin</option>
                                <option value="Selasa" {{ request('day') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="Rabu" {{ request('day') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="Kamis" {{ request('day') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="Jumat" {{ request('day') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                <option value="Sabtu" {{ request('day') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card-small">
                    <div class="stat-icon-small pink">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['total_schedules'] }}</h3>
                        <p class="text-muted mb-0 small">Total Schedules</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-small">
                    <div class="stat-icon-small green">
                        <i class="bi bi-activity"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['active_today'] }}</h3>
                        <p class="text-muted mb-0 small">Active Today</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-small">
                    <div class="stat-icon-small orange">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['total_labs'] }}</h3>
                        <p class="text-muted mb-0 small">Total Labs</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-small">
                    <div class="stat-icon-small blue">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['utilization_rate'] }}%</h3>
                        <p class="text-muted mb-0 small">Utilization Rate</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">Schedule List</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Day</th>
                                <th class="py-3">Time</th>
                                <th class="py-3">Lab</th>
                                <th class="py-3">Subject</th>
                                <th class="py-3">Instructor</th>
                                <th class="py-3">Participants</th>
                                <th class="py-3">Status</th>
                                <th class="py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $schedule)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">{{ $schedule->day }}</span>
                                </td>
                                <td class="py-3">
                                    <i class="bi bi-clock text-muted me-1"></i>
                                    <span>{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</span>
                                </td>
                                <td class="py-3">
                                    <i class="bi bi-door-open text-muted me-1"></i>
                                    <span class="fw-semibold">{{ $schedule->lab_name }}</span>
                                </td>
                                <td class="py-3">{{ $schedule->subject }}</td>
                                <td class="py-3">{{ $schedule->instructor }}</td>
                                <td class="py-3">
                                    <span class="text-muted">{{ $schedule->participants }}/{{ $schedule->max_capacity }}</span>
                                    <div class="progress mt-1" style="height: 4px;">
                                        @php
                                            $percentage = $schedule->max_capacity > 0 ? ($schedule->participants / $schedule->max_capacity) * 100 : 0;
                                            $colorClass = $percentage >= 90 ? 'bg-danger' : ($percentage >= 70 ? 'bg-warning' : 'bg-success');
                                        @endphp
                                        <div class="progress-bar {{ $colorClass }}" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    @if($schedule->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @elseif($schedule->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-3 text-end pe-4">
                                    <button class="btn btn-sm btn-light me-1" 
                                            onclick="editSchedule({{ $schedule->scheduleID }})"
                                            title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-light text-danger"
                                            onclick="deleteSchedule({{ $schedule->scheduleID }}, '{{ $schedule->subject }}')"
                                            title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="bi bi-calendar-x"></i>
                                        <h5>No Schedules Yet</h5>
                                        <p>Click the “Add New Schedule” button to add a new schedule.</p>
                                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                                            <i class="bi bi-plus-circle me-1"></i>Add New Schedule
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($schedules->hasPages())
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                        Showing {{ $schedules->firstItem() }} to {{ $schedules->lastItem() }} of {{ $schedules->total() }} entries
                    </span>
                    {{ $schedules->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Add Schedule Modal -->
    <div class="modal fade" id="addScheduleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.schedules.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Lab <span class="text-danger">*</span></label>
                                <input type="text" name="lab_name" class="form-control @error('lab_name') is-invalid @enderror" 
                                       placeholder="e.g., Lab Komputer 1" value="{{ old('lab_name') }}" required>
                                @error('lab_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" 
                                       placeholder="Enter subject name" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Instructor <span class="text-danger">*</span></label>
                                <input type="text" name="instructor" class="form-control @error('instructor') is-invalid @enderror" 
                                       placeholder="Enter instructor name" value="{{ old('instructor') }}" required>
                                @error('instructor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Day <span class="text-danger">*</span></label>
                                <select name="day" class="form-select @error('day') is-invalid @enderror" required>
                                    <option value="">Select Day</option>
                                    <option value="Monday" {{ old('day') == 'Monday' ? 'selected' : '' }}>Monday</option>
                                    <option value="Tuesday" {{ old('day') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                    <option value="Wednesday" {{ old('day') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                    <option value="Thursday" {{ old('day') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                    <option value="Friday" {{ old('day') == 'Friday' ? 'selected' : '' }}>Friday</option>
                                    <option value="Saturday" {{ old('day') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                </select>
                                @error('day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" 
                                       value="{{ old('start_time') }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Time <span class="text-danger">*</span></label>
                                <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" 
                                       value="{{ old('end_time') }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Max Capacity <span class="text-danger">*</span></label>
                                <input type="number" name="max_capacity" class="form-control @error('max_capacity') is-invalid @enderror" 
                                       placeholder="e.g., 40" value="{{ old('max_capacity') }}" min="1" required>
                                @error('max_capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Additional notes...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the schedule? <strong id="deleteScheduleName"></strong>?</p>
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto show modal if there are validation errors
        @if($errors->any())
            var addModal = new bootstrap.Modal(document.getElementById('addScheduleModal'));
            addModal.show();
        @endif

        // Delete schedule
        function deleteSchedule(scheduleId, scheduleName) {
            document.getElementById('deleteScheduleName').textContent = scheduleName;
            document.getElementById('deleteForm').action = `/admin/schedules/${scheduleId}`;
            
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Edit schedule (redirect to edit page)
        function editSchedule(scheduleId) {
            window.location.href = `/admin/schedules/${scheduleId}/edit`;
        }
    </script>
</body>
</html>