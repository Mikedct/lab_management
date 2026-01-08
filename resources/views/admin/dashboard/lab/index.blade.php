<!-- resources/views/admin/lab/index.blade.php -->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lab Monitoring - Lab Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-wrapper {
            min-height: calc(100vh - 56px);
        }

        /* Header Section */
        .page-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            padding: 30px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            color: white;
        }

        .header-content h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: white;
        }

        /* Stats Cards */
        .stats-row {
            margin-bottom: 30px;
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

        .stat-icon-small.purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-icon-small.green {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .stat-icon-small.pink {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-icon-small.blue {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-content-small h4 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: #333;
        }

        .stat-content-small p {
            margin: 0;
            color: #666;
            font-size: 13px;
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .table-card-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e0e0e0;
        }

        .table-card-body {
            padding: 0;
        }

        .table {
            margin: 0;
        }

        .table thead {
            background-color: #667eea;
            color: white;
        }

        .table thead th {
            border: none;
            padding: 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }


        .btn-action {
            padding: 6px 10px;
            font-size: 13px;
        }

        .btn-primary {
            background-color: #667eea;
            border-color: #667eea;
        }

        .btn-primary:hover {
            background-color: #5568d3;
            border-color: #5568d3;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 64px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-state h5 {
            color: #666;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #999;
            font-size: 14px;
        }

        /* Search and Filter */
        .search-box {
            max-width: 300px;
        }

        .search-box .form-control {
            border-radius: 8px;
            padding-left: 40px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
    </style>
</head>

<body>
    <!-- Include Navbar -->
    @include('layouts.partials.admin-navbar')

    <div class="page-wrapper">
        <!-- Header Section -->
        <div class="page-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="header-content">
                            <h2>
                                <i class="bi bi-people-fill me-2"></i>Lab Monitoring
                            </h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Labs</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="container stats-row">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="stat-card-small">
                        <div class="stat-icon-small purple">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="stat-content-small">
                            <h4>{{ $totalLabs }}</h4>
                            <p>Total Labs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-small">
                        <div class="stat-icon-small pink">
                            <i class="bi bi-pc-display"></i>
                        </div>
                        <div class="stat-content-small">
                            <h4>{{ $totalPC }}</h4>
                            <p>Total PCs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-small">
                        <div class="stat-icon-small blue">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content-small">
                            <h4>{{ $activePC }}</h4>
                            <p>Total Active PC</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-5">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-card">
                <div class="table-card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="bi bi-list-ul me-2"></i>List of Labs
                            </h5>
                        </div>
                    </div>
                </div>

                <!-- Tabel Lab -->

                <div class="table-card-body">
                    <div class="table-responsive">
                        <table class="table" id="labstable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lab Name</th>
                                    <th>PC Count</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($labs as $index => $lab)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $lab->labName }}</td>
                                        <td>{{ $lab->pcCount }}</td>
                                        <td>
                                            <a href="{{ route('admin.lab.show', $lab->labID) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-pc-display"></i> Computer
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No lab data yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

</body>

</html>