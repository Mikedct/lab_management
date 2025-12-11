{{-- resources/views/admin/dashboard/schedule.blade.php --}}

@extends('layouts.admin')

@section('title', 'Lab Schedule Management')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Lab Schedule Management</h2>
            <p class="text-muted mb-0">Manage and monitor laboratory schedules</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
            <i class="bi bi-plus-circle me-2"></i>Add New Schedule
        </button>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" class="form-control" placeholder="Search schedule...">
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Lab</label>
                    <select class="form-select">
                        <option selected>All Labs</option>
                        <option>Lab Komputer 1</option>
                        <option>Lab Komputer 2</option>
                        <option>Lab Jaringan</option>
                        <option>Lab Multimedia</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Day</label>
                    <select class="form-select">
                        <option selected>All Days</option>
                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Status</label>
                    <select class="form-select">
                        <option selected>All Status</option>
                        <option>Active</option>
                        <option>Cancelled</option>
                        <option>Completed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">View</label>
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="view" id="viewList" checked>
                        <label class="btn btn-outline-primary" for="viewList">List</label>
                        
                        <input type="radio" class="btn-check" name="view" id="viewWeek">
                        <label class="btn btn-outline-primary" for="viewWeek">Week</label>
                        
                        <input type="radio" class="btn-check" name="view" id="viewCalendar">
                        <label class="btn btn-outline-primary" for="viewCalendar">Calendar</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Schedules</p>
                            <h3 class="fw-bold mb-0">48</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-calendar-check text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Active Today</p>
                            <h3 class="fw-bold mb-0">12</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-activity text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Labs</p>
                            <h3 class="fw-bold mb-0">8</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-building text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Utilization Rate</p>
                            <h3 class="fw-bold mb-0">78%</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-graph-up text-info fs-4"></i>
                        </div>
                    </div>
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
                        {{-- Sample Data Row 1 --}}
                        <tr>
                            <td class="px-4 py-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary">Senin</span>
                            </td>
                            <td class="py-3">
                                <i class="bi bi-clock text-muted me-1"></i>
                                <span>08:00 - 10:00</span>
                            </td>
                            <td class="py-3">
                                <i class="bi bi-door-open text-muted me-1"></i>
                                <span class="fw-semibold">Lab Komputer 1</span>
                            </td>
                            <td class="py-3">Pemrograman Web</td>
                            <td class="py-3">Dr. Ahmad Hidayat</td>
                            <td class="py-3">
                                <span class="text-muted">35/40</span>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-success" style="width: 87.5%"></div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td class="py-3 text-end pe-4">
                                <button class="btn btn-sm btn-light me-1" data-bs-toggle="modal" data-bs-target="#editScheduleModal">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-light text-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Sample Data Row 2 --}}
                        <tr>
                            <td class="px-4 py-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary">Senin</span>
                            </td>
                            <td class="py-3">
                                <i class="bi bi-clock text-muted me-1"></i>
                                <span>10:00 - 12:00</span>
                            </td>
                            <td class="py-3">
                                <i class="bi bi-door-open text-muted me-1"></i>
                                <span class="fw-semibold">Lab Komputer 2</span>
                            </td>
                            <td class="py-3">Database Systems</td>
                            <td class="py-3">Prof. Sarah Johnson</td>
                            <td class="py-3">
                                <span class="text-muted">30/35</span>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-success" style="width: 85.7%"></div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td class="py-3 text-end pe-4">
                                <button class="btn btn-sm btn-light me-1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-light text-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Sample Data Row 3 --}}
                        <tr>
                            <td class="px-4 py-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary">Selasa</span>
                            </td>
                            <td class="py-3">
                                <i class="bi bi-clock text-muted me-1"></i>
                                <span>13:00 - 15:00</span>
                            </td>
                            <td class="py-3">
                                <i class="bi bi-door-open text-muted me-1"></i>
                                <span class="fw-semibold">Lab Jaringan</span>
                            </td>
                            <td class="py-3">Jaringan Komputer</td>
                            <td class="py-3">Dr. Budi Santoso</td>
                            <td class="py-3">
                                <span class="text-muted">25/30</span>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-warning" style="width: 83.3%"></div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td class="py-3 text-end pe-4">
                                <button class="btn btn-sm btn-light me-1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-light text-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Sample Data Row 4 --}}
                        <tr>
                            <td class="px-4 py-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary">Rabu</span>
                            </td>
                            <td class="py-3">
                                <i class="bi bi-clock text-muted me-1"></i>
                                <span>08:00 - 10:00</span>
                            </td>
                            <td class="py-3">
                                <i class="bi bi-door-open text-muted me-1"></i>
                                <span class="fw-semibold">Lab Multimedia</span>
                            </td>
                            <td class="py-3">Desain Grafis</td>
                            <td class="py-3">Ir. Siti Nurhaliza</td>
                            <td class="py-3">
                                <span class="text-muted">20/25</span>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-info" style="width: 80%"></div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-danger">Cancelled</span>
                            </td>
                            <td class="py-3 text-end pe-4">
                                <button class="btn btn-sm btn-light me-1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-light text-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Sample Data Row 5 --}}
                        <tr>
                            <td class="px-4 py-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary">Kamis</span>
                            </td>
                            <td class="py-3">
                                <i class="bi bi-clock text-muted me-1"></i>
                                <span>10:00 - 12:00</span>
                            </td>
                            <td class="py-3">
                                <i class="bi bi-door-open text-muted me-1"></i>
                                <span class="fw-semibold">Lab Komputer 1</span>
                            </td>
                            <td class="py-3">Algoritma & Struktur Data</td>
                            <td class="py-3">Dr. Michael Chen</td>
                            <td class="py-3">
                                <span class="text-muted">40/40</span>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-danger" style="width: 100%"></div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td class="py-3 text-end pe-4">
                                <button class="btn btn-sm btn-light me-1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-light text-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Showing 1 to 5 of 48 entries</span>
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Add Schedule Modal -->
<div class="modal fade" id="addScheduleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Lab <span class="text-danger">*</span></label>
                            <select class="form-select" required>
                                <option value="">Select Lab</option>
                                <option>Lab Komputer 1</option>
                                <option>Lab Komputer 2</option>
                                <option>Lab Jaringan</option>
                                <option>Lab Multimedia</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter subject name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Instructor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter instructor name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Day <span class="text-danger">*</span></label>
                            <select class="form-select" required>
                                <option value="">Select Day</option>
                                <option>Senin</option>
                                <option>Selasa</option>
                                <option>Rabu</option>
                                <option>Kamis</option>
                                <option>Jumat</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Max Capacity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" placeholder="e.g., 40" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select">
                                <option selected>Active</option>
                                <option>Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" rows="3" placeholder="Additional notes..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save Schedule</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
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
</style>
@endpush

@push('scripts')
<script>
    // Add your JavaScript here
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Lab Schedule Dashboard loaded');
        
        // Example: Handle delete button
        document.querySelectorAll('.text-danger').forEach(btn => {
            btn.addEventListener('click', function() {
                if(confirm('Are you sure you want to delete this schedule?')) {
                    // Add delete logic here
                    console.log('Delete confirmed');
                }
            });
        });
    });
</script>
@endpush