<!-- resources/views/admin/report/index.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Report Management - Lab Management</title>

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

        .header-content { color: white; }
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
        .breadcrumb-item.active { color: white; }

        /* Stats Cards */
        .stats-row { margin-bottom: 30px; }

        .stat-card-small {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }
        .stat-card-small:hover { transform: translateY(-3px); }

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

        .stat-icon-small.purple { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-icon-small.green  { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .stat-icon-small.red    { background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); }

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
        .table-card-body { padding: 0; }

        .table { margin: 0; }
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
        .table tbody tr:hover { background-color: #f8f9fa; }
        .table tbody tr:last-child td { border-bottom: none; }

        .badge {
            padding: 6px 12px;
            font-weight: 500;
            font-size: 12px;
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
        .empty-state h5 { color: #666; margin-bottom: 10px; }
        .empty-state p  { color: #999; font-size: 14px; }

        /* Search and Filter */
        .search-box { max-width: 320px; }
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

        .truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
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
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Report Management
                            </h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Reports</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('admin.report.export') }}" class="btn btn-light">
                            <i class="bi bi-download me-1"></i> Export Report
                        </a>
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
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                        <div class="stat-content-small">
                            <h4>{{ $totalReports ?? 0 }}</h4>
                            <p>Total Reports</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-small">
                        <div class="stat-icon-small red">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="stat-content-small">
                            <h4>{{ $pendingReports ?? 0 }}</h4>
                            <p>Pending / Baru</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-small">
                        <div class="stat-icon-small green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content-small">
                            <h4>{{ $resolvedReports ?? 0 }}</h4>
                            <p>Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Table -->
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
                                <i class="bi bi-list-ul me-2"></i>Daftar Report
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative search-box ms-auto">
                                <i class="bi bi-search search-icon"></i>
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari laporan...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-card-body">
                    <div class="table-responsive">
                        <table class="table" id="reportsTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Lab</th>
                                    <th>Komputer</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $index => $report)
                                <tr>
                                    <td><strong>{{ $index + 1 }}</strong></td>
                                    <td>
                                        {{ $report->user->userName ?? $report->userName ?? 'Unknown' }}
                                        <div class="text-muted small">
                                            ID: {{ $report->user->userID ?? $report->userID ?? '-' }}
                                        </div>
                                    </td>
                                    <td>{{ $report->lab->labName ?? $report->labName ?? '-' }}</td>
                                    <td>{{ $report->computer->computerName ?? $report->computerName ?? '-' }}</td>
                                    <td class="truncate-2">
                                        {{ $report->title ?? $report->reportTitle ?? '-' }}
                                    </td>
                                    <td>
                                        @php
                                            $st = strtolower($report->status ?? 'pending');
                                        @endphp

                                        @if(in_array($st, ['pending','baru','new']))
                                            <span class="badge bg-danger">Pending</span>
                                        @elseif(in_array($st, ['process','in progress','diproses','on progress']))
                                            <span class="badge bg-warning text-dark">On Progress</span>
                                        @elseif(in_array($st, ['resolved','done','selesai']))
                                            <span class="badge bg-success">Resolved</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $report->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($report->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.report.show', $report->reportID ?? $report->id) }}"
                                               class="btn btn-outline-info btn-action" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <button type="button"
                                                    class="btn btn-outline-warning btn-action"
                                                    title="Update Status"
                                                    onclick="openStatusModal(
                                                        {{ $report->reportID ?? $report->id }},
                                                        '{{ $report->title ?? $report->reportTitle ?? 'Report' }}',
                                                        '{{ $report->status ?? 'Pending' }}'
                                                    )">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>

                                            <button type="button"
                                                    class="btn btn-outline-danger btn-action"
                                                    title="Hapus"
                                                    onclick="confirmDelete(
                                                        {{ $report->reportID ?? $report->id }},
                                                        '{{ $report->title ?? $report->reportTitle ?? 'Report' }}'
                                                    )">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox"></i>
                                            <h5>Belum Ada Laporan</h5>
                                            <p>Jika ada user membuat laporan, datanya akan muncul di sini.</p>
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
    </div>


    <!-- Update Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-arrow-repeat text-warning me-2"></i>Update Status Report
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Report: <strong id="statusReportTitle"></strong></p>
                    <p class="text-muted small">Pilih status terbaru untuk laporan ini.</p>

                    <form id="statusForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="statusSelect" class="form-select">
                                <option value="Pending">Pending</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Resolved">Resolved</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Admin (opsional)</label>
                            <textarea name="admin_note" class="form-control" rows="3"
                                      placeholder="Catatan tindak lanjut..."></textarea>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-save me-1"></i>Simpan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus report <strong id="deleteReportTitle"></strong>?</p>
                    <p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#reportsTable tbody tr');

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        // Delete confirmation
        function confirmDelete(reportId, reportTitle) {
            document.getElementById('deleteReportTitle').textContent = reportTitle;
            document.getElementById('deleteForm').action = `/admin/report/${reportId}`;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Update status modal
        function openStatusModal(reportId, reportTitle, currentStatus) {
            document.getElementById('statusReportTitle').textContent = reportTitle;

            // set form action (PUT)
            document.getElementById('statusForm').action = `/admin/report/${reportId}`;

            // normalize status selection
            const st = (currentStatus || '').toLowerCase();
            const select = document.getElementById('statusSelect');

            if (['pending','baru','new'].includes(st)) select.value = 'Pending';
            else if (['process','in progress','diproses','on progress'].includes(st)) select.value = 'On Progress';
            else if (['resolved','done','selesai'].includes(st)) select.value = 'Resolved';
            else select.value = 'Pending';

            const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
            statusModal.show();
        }
    </script>
</body>
</html>