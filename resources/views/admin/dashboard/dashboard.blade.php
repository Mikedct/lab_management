<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Lab Management</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-wrapper {
            min-height: calc(100vh - 56px);
        }

        /* Header Section */
        .dashboard-header {
            background: linear-gradient(135deg, #b72024 0%, #d32f2f 100%);
            padding: 40px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            opacity: 0.9;
            font-size: 16px;
        }

        /* Menu Cards */
        .menu-section {
            margin-bottom: 40px;
        }

        .menu-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
            cursor: pointer;
            text-decoration: none;
            display: block;
        }

        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(183, 32, 36, 0.2);
        }

        .menu-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: white;
            transition: all 0.3s ease;
        }

        .menu-card:hover .menu-icon {
            transform: scale(1.1);
        }

        .menu-card.users .menu-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .menu-card.schedule .menu-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .menu-card.lab .menu-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .menu-card.report .menu-icon { 
            background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); 
        }

        .menu-title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .menu-description {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .menu-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .menu-card.users .menu-badge {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .menu-card.schedule .menu-badge {
            background: rgba(245, 87, 108, 0.1);
            color: #f5576c;
        }

        .menu-card.lab .menu-badge {
            background: rgba(79, 172, 254, 0.1);
            color: #4facfe;
        }

        .menu-card.report .menu-badge {
            background: rgba(79, 172, 254, 0.1);
            color: #ff6a00;
        }

        /* Statistics Section */
        .stats-section {
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-right: 20px;
        }

        .stat-icon.primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-icon.success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .stat-icon.warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-icon.info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

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

        /* Footer */
        .dashboard-footer {
            background: white;
            border-top: 1px solid #e0e0e0;
            padding: 20px 0;
            margin-top: 50px;
        }

        @media (max-width: 768px) {
            .menu-card {
                margin-bottom: 20px;
            }

            .stat-card {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    @include('layouts.partials.admin-navbar')

    <div class="dashboard-wrapper">
        <!-- Header Section -->
        <div class="dashboard-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="welcome-text">
                            <h2>
                                <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
                            </h2>
                            <p>
                                <i class="bi bi-person-circle me-1"></i>
                                Welcome, <strong>{{ session('adminName', 'Administrator') }}</strong>
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

        <!-- Statistics Cards -->
        <div class="container stats-section">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon primary">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $totalUsers ?? 0 }}</h3>
                            <p>Total Users</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon success">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $totalSchedules ?? 0 }}</h3>
                            <p>Total Schedules</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon warning">
                            <i class="bi bi-pc-display"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $totalComputers ?? 0 }}</h3>
                            <p>Total PC Lab</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon info">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $activeComputers ?? 0 }}</h3>
                            <p>Active PC</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Menu Section -->
        <div class="container menu-section">
            <h4 class="mb-4 fw-bold text-dark">
                <i class="bi bi-grid-3x3-gap-fill me-2" style="color: #b72024;"></i>
                Main Menu
            </h4>

            <div class="row g-4">
                <!-- User Management -->
                <div class="col-md-4">
                    <a href="{{ route('admin.users.index') }}" class="menu-card users">
                        <div class="menu-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h5 class="menu-title">User Management</h5>
                        <p class="menu-description">
                            Manage user data, add, edit, and delete system users.
                        </p>
                        <span class="menu-badge">
                            <i class="bi bi-person-plus me-1"></i>CRUD Users
                        </span>
                    </a>
                </div>

                <!-- Schedule Management -->
                <div class="col-md-4">
                    <a href="{{ route('admin.schedules.index') }}" class="menu-card schedule">
                        <div class="menu-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <h5 class="menu-title">Schedule Lab</h5>
                        <p class="menu-description">
                            Set lab usage schedules, reservations, and availability
                        </p>
                        <span class="menu-badge">
                            <i class="bi bi-calendar-plus me-1"></i>CRUD Schedules
                        </span>
                    </a>
                </div>

                <!-- Lab Computer Status -->
                <div class="col-md-4">
                    <a href="{{ route('admin.lab.index') }}" class="menu-card lab">
                        <div class="menu-icon">
                            <i class="bi bi-pc-display-horizontal"></i>
                        </div>
                        <h5 class="menu-title">Lab Monitoring</h5>
                        <p class="menu-description">
                            Monitor the condition of lab PCs, their status, specifications, and maintenance
                        </p>
                        <span class="menu-badge">
                            <i class="bi bi-eye me-1"></i>View PC Status
                        </span>
                    </a>
                </div>

                <!-- Report Management -->
                <div class="col-md-4">
                    <a href="{{ route('admin.reports.index') }}" class="menu-card report">
                        <div class="menu-icon">
                            <i class="bi bi-flag-fill"></i>
                        </div>
                        <h5 class="menu-title">Report Management</h5>
                        <p class="menu-description">
                            Managing PC lab malfunctions reported by users
                        </p>
                        <span class="menu-badge">
                            <i class="bi bi-flag me-1"></i>Manage Reports
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="container mb-5">
            <h4 class="mb-4 fw-bold text-dark">
                <i class="bi bi-lightning-fill me-2" style="color: #b72024;"></i>
                Quick Actions
            </h4>
            
            <div class="row g-3">
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary w-100 py-3 text-decoration-none">
                        <i class="bi bi-person-plus-fill d-block mb-2" style="font-size: 24px;"></i>
                        Add New User
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('admin.schedules.create') }}" class="btn btn-outline-primary w-100 py-3 text-decoration-none">
                        <i class="bi bi-person-plus-fill d-block mb-2" style="font-size: 24px;"></i>
                        Create New Schedule
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-info w-100 py-3 text-decoration-none">
                        <i class="bi bi-file-earmark-text-fill d-block mb-2" style="font-size: 24px;"></i>
                        See Reports
                    </a>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-warning w-100 py-3 text-decoration-none">
                    <i class="bi bi-gear-fill d-block mb-2" style="font-size: 24px;"></i>
                    Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="dashboard-footer">
        <div class="container text-center text-muted">
            <small>© {{ date('Y') }} Univ UBD - Lab Management System. All rights reserved.</small>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Update current time
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