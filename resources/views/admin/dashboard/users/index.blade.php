<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Management - Lab Management</title>
    
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

        .stat-icon-small.purple { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-icon-small.green { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .stat-icon-small.red { background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); }

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

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 12px;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-details h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .user-details p {
            margin: 0;
            font-size: 12px;
            color: #999;
        }

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
                                <i class="bi bi-people-fill me-2"></i>User Management
                            </h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Users</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-light">
                            <i class="bi bi-plus-circle me-1"></i> Add new user
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
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="stat-content-small">
                            <h4>{{ $totalUsers }}</h4>
                            <p>Total Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-small">
                        <div class="stat-icon-small green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content-small">
                            <h4>{{ $activeUsers }}</h4>
                            <p>Active Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-small">
                        <div class="stat-icon-small red">
                            <i class="bi bi-x-circle"></i>
                        </div>
                        <div class="stat-content-small">
                            <h4>{{ $inactiveUsers }}</h4>
                            <p>Inactive Users</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
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
                                <i class="bi bi-list-ul me-2"></i>Users List
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative search-box ms-auto">
                                <i class="bi bi-search search-icon"></i>
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari user...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-card-body">
                    <div class="table-responsive">
                        <table class="table" id="usersTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $user)
                                <tr>
                                    <td><strong>{{ $index + 1 }}</strong></td>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                {{ strtoupper(substr($user->userName, 0, 1)) }}
                                            </div>
                                            <div class="user-details">
                                                <h6>{{ $user->userName }}</h6>
                                                <p>ID: {{ $user->userID }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'Admin')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-shield-check me-1"></i>{{ $user->role }}
                                            </span>
                                        @elseif($user->role == 'Dosen')
                                            <span class="badge bg-primary">
                                                <i class="bi bi-mortarboard me-1"></i>{{ $user->role }}
                                            </span>
                                        @else
                                            <span class="badge bg-info">
                                                <i class="bi bi-person me-1"></i>{{ $user->role }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->status == 'Active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.users.show', $user->userID) }}" 
                                               class="btn btn-outline-info btn-action" 
                                               title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->userID) }}" 
                                               class="btn btn-outline-warning btn-action" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-danger btn-action" 
                                                    title="Hapus"
                                                    onclick="confirmDelete({{ $user->userID }}, '{{ $user->userName }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox"></i>
                                            <h5>No User Data Yet</h5>
                                            <p>Click the “Add New User” button to add the first user.</p>
                                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-3">
                                                <i class="bi bi-plus-circle me-1"></i> Add New User
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
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the user? <strong id="deleteUserName"></strong>?</p>
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#usersTable tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        // Delete confirmation
        function confirmDelete(userId, userName) {
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteForm').action = `/admin/users/${userId}`;
            
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
</body>
</html>