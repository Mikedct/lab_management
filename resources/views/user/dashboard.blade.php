<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Dashboard - Lab Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header */
        .dashboard-header {
            background: linear-gradient(135deg, #1976d2 0%, #667eea 100%);
            padding: 40px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .welcome-text {
            color: white;
        }

        .welcome-text h2 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .welcome-text p {
            opacity: 0.95;
            font-size: 16px;
        }

        /* Statistics Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            margin-right: 20px;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #42a5f5, #1e88e5);
        }

        .stat-icon.green {
            background: linear-gradient(135deg, #66bb6a, #43a047);
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, #ffa726, #fb8c00);
        }

        .stat-content h3 {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
            color: #333;
        }

        .stat-content p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        /* Menu Cards */
        .menu-card {
            background: white;
            border-radius: 15px;
            padding: 35px 30px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            height: 100%;
            border: 2px solid transparent;
        }

        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-color: #1976d2;
        }

        .menu-icon {
            width: 90px;
            height: 90px;
            border-radius: 20px;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            color: white;
            transition: transform 0.3s ease;
        }

        .menu-card:hover .menu-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .menu-card.schedule .menu-icon {
            background: linear-gradient(135deg, #42a5f5, #1e88e5);
            box-shadow: 0 4px 15px rgba(30, 136, 229, 0.3);
        }

        .menu-card.report .menu-icon {
            background: linear-gradient(135deg, #66bb6a, #43a047);
            box-shadow: 0 4px 15px rgba(67, 160, 71, 0.3);
        }

        .menu-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 12px;
        }

        .menu-description {
            font-size: 15px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .menu-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 600;
        }

        .menu-card.schedule .menu-badge {
            background: rgba(30, 136, 229, 0.1);
            color: #1e88e5;
        }

        .menu-card.report .menu-badge {
            background: rgba(67, 160, 71, 0.1);
            color: #43a047;
        }

        /* Info Section */
        .info-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .info-section h5 {
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item i {
            font-size: 20px;
            color: #1976d2;
            margin-right: 12px;
            width: 24px;
        }

        /* Footer */
        .dashboard-footer {
            background: white;
            border-top: 1px solid #e0e0e0;
            padding: 25px 0;
            margin-top: 50px;
        }

        /* Quick Actions */
        .quick-actions {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .quick-actions h5 {
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .quick-action-btn {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .quick-action-btn:hover {
            border-color: #1976d2;
            background: #f8f9fa;
            transform: translateX(5px);
        }

        .quick-action-btn i {
            font-size: 24px;
            margin-right: 15px;
            color: #1976d2;
        }

        @media (max-width: 768px) {
            .menu-card {
                margin-bottom: 20px;
            }
            
            .dashboard-header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

@include('layouts.partials.user-navbar')

{{-- Header --}}
<div class="dashboard-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="welcome-text">
                    <h2>
                        <i class="bi bi-person-circle me-2"></i>
                        Dashboard User
                    </h2>
                    <p>
                        <i class="bi bi-hand-thumbs-up me-1"></i>
                        Welcome, <strong>{{ session('userName', 'User') }}</strong>
                    </p>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="text-white">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
                </div>
                <div class="text-white mt-2">
                    <i class="bi bi-clock me-1"></i>
                    <span id="current-time"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
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

    <!-- Main Menu - CENTERED -->
    <div class="row">
        <div class="col-12">
            <h4 class="mb-4 fw-bold text-center">
                <i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>
                Main Menu
            </h4>

            <div class="row g-4 mb-4 justify-content-center">
                {{-- Jadwal Lab --}}
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.schedule.index') }}" class="menu-card schedule">
                        <div class="menu-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <h5 class="menu-title">Lab Schedule</h5>
                        <p class="menu-description">
                            See the schedule for available computer lab usage
                        </p>
                        <span class="menu-badge">
                            <i class="bi bi-calendar-plus me-1"></i>See Schedule
                        </span>
                    </a>
                </div>

                {{-- Laporan --}}
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.reports.index') }}" class="menu-card report">
                        <div class="menu-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <h5 class="menu-title">Reports</h5>
                        <p class="menu-description">
                            View your lab usage report
                        </p>
                        <span class="menu-badge">
                            <i class="bi bi-file-text me-1"></i>See Reports
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- My Schedules Section -->
    @if(isset($mySchedules) && $mySchedules->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-week me-2"></i>
                        My Schedules
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>Lab</th>
                                    <th>Subject</th>
                                    <th>Instructor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mySchedules as $schedule)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $schedule->day }}</span></td>
                                    <td>{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</td>
                                    <td>{{ $schedule->lab_name }}</td>
                                    <td>{{ $schedule->subject }}</td>
                                    <td>{{ $schedule->instructor }}</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Footer --}}
<div class="dashboard-footer">
    <div class="container text-center text-muted">
        <small>© {{ date('Y') }} Univ UBD - Lab Management System. All rights reserved.</small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
    }
    updateTime();
    setInterval(updateTime, 1000);
</script>

</body>
</html>