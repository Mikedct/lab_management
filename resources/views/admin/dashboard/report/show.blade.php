<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
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
        background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
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

<body>
    @include('layouts.partials.admin-navbar')


    <div class="page-wrapper">
        <!-- Header Section -->
        <div class="page-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="header-content">
                            <h2>
                                <i class="bi bi-flag-fill me-2"></i>Report Management
                            </h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.reports.index') }}">Report</a>
                                    </li>
                                    <li class="breadcrumb-item active">Detail</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4 mb-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Laporan Gangguan</h5>
                </div>

                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Judul:</strong>
                            <p>{{ $report->title }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong><br>
                            @if($report->status === 'new')
                                <span class="badge bg-danger">Baru</span>
                            @elseif($report->status === 'in_progress')
                                <span class="badge bg-warning text-dark">Diproses</span>
                            @elseif($report->status === 'done')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-dark">{{ $report->status }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Lab:</strong>
                            <p>{{ $report->labName }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Komputer:</strong>
                            <p>{{ $report->computerName }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Deskripsi Gangguan:</strong>
                        <div class="border rounded p-3 bg-light">
                            {{ $report->description }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Lampiran:</strong><br>

                        @if($report->attachment)
                            <img src="{{ route('admin.reports.attachment', $report->reportID) }}"
                                class="img-fluid rounded border" style="max-height: 400px" alt="Lampiran laporan">

                        @else
                            <p class="text-muted">Tidak ada lampiran</p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <strong>Ubah Status:</strong>
                        <form action="{{ route('admin.reports.updateStatus', $report->reportID) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('PUT')

                            <select name="status" class="form-select d-inline w-auto">
                                <option value="new" {{ $report->status == 'new' ? 'selected' : '' }}>
                                    Baru
                                </option>
                                <option value="in_progress" {{ $report->status == 'in_progress' ? 'selected' : '' }}>
                                    Diproses
                                </option>
                                <option value="done" {{ $report->status == 'done' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                            </select>

                            <button class="btn btn-primary btn-sm ms-2">
                                <i class="bi bi-arrow-repeat"></i> Update
                            </button>
                        </form>

                    </div>

                    <div class="text-muted">
                        Dibuat: {{ \Carbon\Carbon::parse($report->created_at)->format('d M Y H:i') }} <br>
                        Update terakhir: {{ \Carbon\Carbon::parse($report->updated_at)->format('d M Y H:i') }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</body>

</html>