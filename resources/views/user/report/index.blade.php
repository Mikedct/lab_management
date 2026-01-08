<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Report - Lab Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .page-wrapper { min-height: calc(100vh - 56px); }
        .page-header {
            background: linear-gradient(135deg, #b72024 0%, #7d1418 100%);
            padding: 26px 0;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.12);
        }
        .header-content { color: #fff; }
        .header-content h2 { font-size: 26px; font-weight: 800; margin-bottom: 6px; }
        .breadcrumb { background: transparent; padding: 0; margin: 0; }
        .breadcrumb-item a { color: rgba(255,255,255,.85); text-decoration: none; }
        .breadcrumb-item.active { color: #fff; }

        .table-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
            overflow: hidden;
        }
        .table-card-header { padding: 18px 22px; border-bottom: 1px solid #eee; }
        .table thead { background: #b72024; color: #fff; }
        .table thead th {
            border: none; padding: 14px; font-weight: 700; text-transform: uppercase;
            font-size: 12px; letter-spacing: .5px;
        }
        .table tbody td { padding: 14px; vertical-align: middle; border-bottom: 1px solid #f2f2f2; }
        .badge { padding: 6px 10px; font-weight: 600; font-size: 12px; }

        .search-box { max-width: 300px; }
        .search-box .form-control { border-radius: 8px; padding-left: 38px; }
        .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999; }

        .empty-state { text-align: center; padding: 56px 18px; }
        .empty-state i { font-size: 60px; color: #ddd; margin-bottom: 14px; }
        .empty-state h5 { color: #666; margin-bottom: 8px; }
        .empty-state p { color: #999; font-size: 14px; margin-bottom: 16px; }
    </style>
</head>
<body>
    @include('layouts.partials.user-navbar')

    <div class="page-wrapper">
        <div class="page-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="header-content">
                            <h2><i class="bi bi-flag-fill me-2"></i>My Report</h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Beranda</a></li>
                                    <li class="breadcrumb-item active">Report</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('user.reports.create') }}" class="btn btn-light">
                            <i class="bi bi-plus-circle me-1"></i> Create a Report
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-5">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-card">
                <div class="table-card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Report History</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative search-box ms-auto">
                                <i class="bi bi-search search-icon"></i>
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari laporan...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0" id="reportsTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Lab / Computer</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th class="text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $index => $report)
                                <tr>
                                    <td><strong>{{ $index + 1 }}</strong></td>
                                    <td>{{\Carbon\Carbon::parse($report->created_at)->format('d F Y, H:i') }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $report->labName ?? ($report->lab->labName ?? $report->lab->name ?? '-') }}</div>
                                        <div class="text-muted small">
                                            Komputer: {{ $report->computerName ?? ($report->computer->computerName ?? $report->computer->name ?? '-') }}
                                        </div>
                                    </td>
                                    <td>{{ $report->title ?? '-' }}</td>
                                    <td>
                                        @php $status = strtolower($report->status ?? 'new'); @endphp
                                        @if($status === 'new')
                                            <span class="badge bg-danger">New</span>
                                        @elseif($status === 'in_progress')
                                            <span class="badge bg-warning text-dark">In Process</span>
                                        @elseif($status === 'done')
                                            <span class="badge bg-success">Done</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('user.reports.show', $report->id ?? $report->reportID ?? 0) }}"
                                           class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox"></i>
                                            <h5>No Report Yet</h5>
                                            <p>You can file a report if there is a problem with the lab computers.</p>
                                            <a href="{{ route('user.reports.create') }}" class="btn btn-danger">
                                                <i class="bi bi-plus-circle me-1"></i> Create Report
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('searchInput')?.addEventListener('keyup', function () {
            const searchValue = this.value.toLowerCase();
            document.querySelectorAll('#reportsTable tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
