<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Schedule - Lab Management</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }

        .page-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 30px 0;
            margin-bottom: 30px;
            color: white;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #f5576c;
            box-shadow: 0 0 0 0.2rem rgba(245, 87, 108, 0.15);
        }

        .btn-submit {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 87, 108, 0.3);
        }

        .required-mark {
            color: #dc3545;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #f5576c;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-box i {
            color: #f5576c;
            font-size: 18px;
        }

        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    @include('layouts.partials.admin-navbar')

    <div class="page-header">
        <div class="container">
            <h2><i class="bi bi-pencil-square me-2"></i>Edit Schedule</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: rgba(255,255,255,0.8);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.schedules.index') }}" style="color: rgba(255,255,255,0.8);">Schedules</a></li>
                    <li class="breadcrumb-item active" style="color: white;">Edit Schedule</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="info-box">
                    <i class="bi bi-info-circle me-2"></i>
                    <p class="d-inline">Edit schedule: <strong>{{ $schedule->subject }}</strong> - {{ $schedule->lab_name }}</p>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>There is an error:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="form-card">
                    <form action="{{ route('admin.schedules.update', $schedule->scheduleID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lab_name" class="form-label">
                                    Lab Name <span class="required-mark">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('lab_name') is-invalid @enderror" 
                                       id="lab_name" 
                                       name="lab_name" 
                                       value="{{ old('lab_name', $schedule->lab_name) }}"
                                       placeholder="e.g., Lab Komputer 1"
                                       required>
                                @error('lab_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="subject" class="form-label">
                                    Subject <span class="required-mark">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('subject') is-invalid @enderror" 
                                       id="subject" 
                                       name="subject" 
                                       value="{{ old('subject', $schedule->subject) }}"
                                       placeholder="Enter subject name"
                                       required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="instructor" class="form-label">
                                    Instructor <span class="required-mark">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('instructor') is-invalid @enderror" 
                                       id="instructor" 
                                       name="instructor" 
                                       value="{{ old('instructor', $schedule->instructor) }}"
                                       placeholder="Enter instructor name"
                                       required>
                                @error('instructor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="day" class="form-label">
                                    Day <span class="required-mark">*</span>
                                </label>
                                <select class="form-select @error('day') is-invalid @enderror" 
                                        id="day" 
                                        name="day" 
                                        required>
                                    <option value="">Select Day</option>
                                    <option value="Senin" {{ old('day', $schedule->day) == 'Senin' ? 'selected' : '' }}>Senin</option>
                                    <option value="Selasa" {{ old('day', $schedule->day) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                    <option value="Rabu" {{ old('day', $schedule->day) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                    <option value="Kamis" {{ old('day', $schedule->day) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                    <option value="Jumat" {{ old('day', $schedule->day) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                    <option value="Sabtu" {{ old('day', $schedule->day) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                </select>
                                @error('day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">
                                    Start Time <span class="required-mark">*</span>
                                </label>
                                <input type="time" 
                                       class="form-control @error('start_time') is-invalid @enderror" 
                                       id="start_time" 
                                       name="start_time" 
                                       value="{{ old('start_time', substr($schedule->start_time, 0, 5)) }}"
                                       required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">
                                    End Time <span class="required-mark">*</span>
                                </label>
                                <input type="time" 
                                       class="form-control @error('end_time') is-invalid @enderror" 
                                       id="end_time" 
                                       name="end_time" 
                                       value="{{ old('end_time', substr($schedule->end_time, 0, 5)) }}"
                                       required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="max_capacity" class="form-label">
                                    Max Capacity <span class="required-mark">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('max_capacity') is-invalid @enderror" 
                                       id="max_capacity" 
                                       name="max_capacity" 
                                       value="{{ old('max_capacity', $schedule->max_capacity) }}"
                                       placeholder="e.g., 40"
                                       min="1"
                                       required>
                                @error('max_capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">
                                    Status <span class="required-mark">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="active" {{ old('status', $schedule->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $schedule->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="cancelled" {{ old('status', $schedule->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="3" 
                                      placeholder="Additional notes...">{{ old('notes', $schedule->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-submit">
                                <i class="bi bi-save me-1"></i> Update Schedule
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Schedule Info -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="bi bi-info-circle me-2"></i>Schedule Information
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Schedule ID:</strong> {{ $schedule->scheduleID }}
                                </p>
                                <p class="mb-2">
                                    <strong>Current Participants:</strong> {{ $schedule->participants }} / {{ $schedule->max_capacity }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Created:</strong> {{ \Carbon\Carbon::parse($schedule->created_at)->format('d M Y, H:i') }}
                                </p>
                                <p class="mb-2">
                                    <strong>Last Updated:</strong> {{ \Carbon\Carbon::parse($schedule->updated_at)->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Validate time
        document.getElementById('end_time').addEventListener('change', function() {
            const startTime = document.getElementById('start_time').value;
            const endTime = this.value;
            
            if (startTime && endTime && endTime <= startTime) {
                alert('End time must be after start time!');
                this.value = '';
            }
        });
    </script>
</body>
</html>