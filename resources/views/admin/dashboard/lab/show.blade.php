<!-- resources/views/admin/lab/show.blade.php -->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lab Detail - {{ $lab->labName }}</title>

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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        .badge {
            padding: 6px 12px;
            font-weight: 500;
            font-size: 12px;
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
                                <i class="bi bi-pc-display me-2"></i>Lab: {{ $lab->labName }}
                            </h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.lab.index') }}">Labs</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ $lab->labName }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('admin.computer.create', $lab->labID) }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Komputer
                        </a>

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
                    <h5 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>Daftar Komputer
                    </h5>
                </div>
                <div class="table-card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Computer Name</th>
                                    <th>Status</th>
                                    <th>Storage (GB)</th>
                                    <th>OS</th>
                                    <th>CPU</th>
                                    <th>GPU</th>
                                    <th>RAM (GB)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($computers as $index => $comp)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $comp->computerName }}</td>
                                        <td>
                                            @if($comp->status == 'Active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $comp->storage }}</td>
                                        <td>
                                            @if(str_contains(strtolower($comp->OS), 'windows'))
                                                <span class="badge bg-primary">
                                                    <i class="bi bi-windows me-1"></i>{{ $comp->OS }}</span>
                                            @elseif(str_contains(strtolower($comp->OS), 'linux'))
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bi bi-ubuntu me-1"></i>{{ $comp->OS }}</span>
                                            @elseif(str_contains(strtolower($comp->OS), 'mac'))
                                                <span class="badge bg-light text-dark">
                                                    <i class="bi bi-apple me-1"></i>{{ $comp->OS }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $comp->OS }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(str_contains(strtolower($comp->CPU), 'intel'))
                                                <span class="badge bg-primary">
                                                    <i class="bi bi-cpu me-1"></i>{{ $comp->CPU }}</span>
                                            @elseif(str_contains(strtolower($comp->CPU), 'amd'))
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bi bi-amd me-1"></i>{{ $comp->CPU }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">{{ $comp->CPU }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(str_contains(strtolower($comp->GPU), 'intel'))
                                                <span class="badge bg-primary">
                                                    <i class="bi bi-cpu me-1"></i>{{ $comp->GPU }}</span>
                                            @elseif(str_contains(strtolower($comp->GPU), 'amd'))
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-amd me-1"></i>{{ $comp->GPU }}</span>
                                            @elseif(str_contains(strtolower($comp->GPU), 'nvidia'))
                                                <span class="badge bg-success">
                                                    <i class="bi bi-nvidia me-1"></i>{{ $comp->GPU }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $comp->GPU }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $comp->RAM }}</td>
                                        <td class="d-flex gap-2">

                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('admin.computer.edit', [$lab->labID, $comp->computerID]) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            {{-- Tombol Delete --}}
                                            <form
                                                action="{{ route('admin.computer.destroy', [$lab->labID, $comp->computerID]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus komputer ini?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Belum ada komputer di lab ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
</body>

</html>