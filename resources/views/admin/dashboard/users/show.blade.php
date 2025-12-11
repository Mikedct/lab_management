<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail User - Lab Management</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 0;
            margin-bottom: 30px;
            color: white;
        }

        .detail-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px 30px;
        }

        .card-header-custom h4 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .card-body-custom {
            padding: 30px;
        }

        .user-avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: bold;
            margin: 0 auto 20px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .user-name {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .user-email {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            flex: 0 0 200px;
            font-weight: 600;
            color: #666;
        }

        .info-value {
            flex: 1;
            color: #333;
        }

        .badge-custom {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-role-admin {
            background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
            color: white;
        }

        .badge-role-dosen {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .badge-role-mahasiswa {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .badge-status-active {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .badge-status-inactive {
            background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%);
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #f0f0f0;
        }

        .btn-custom {
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border: none;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 87, 108, 0.3);
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
            color: white;
            border: none;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(238, 9, 121, 0.3);
            color: white;
        }

        .stats-mini {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .stats-mini i {
            font-size: 32px;
            color: #667eea;
            margin-bottom: 10px;
        }

        .stats-mini h3 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .stats-mini p {
            color: #666;
            margin: 0;
            font-size: 14px;
        }

        .timeline-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-content h6 {
            margin: 0 0 5px 0;
            font-weight: 600;
            color: #333;
        }

        .timeline-content p {
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
            <h2><i class="bi bi-person-badge me-2"></i>Detail User</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: rgba(255,255,255,0.8);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" style="color: rgba(255,255,255,0.8);">Users</a></li>
                    <li class="breadcrumb-item active" style="color: white;">Detail User</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Main Profile Card -->
            <div class="col-lg-8">
                <div class="detail-card">
                    <div class="card-header-custom">
                        <h4><i class="bi bi-person-circle me-2"></i>Informasi User</h4>
                    </div>
                    <div class="card-body-custom">
                        <!-- Avatar & Name -->
                        <div class="user-avatar-large">
                            {{ strtoupper(substr($user->userName, 0, 1)) }}
                        </div>
                        <h3 class="user-name">{{ $user->userName }}</h3>
                        <p class="user-email"><i class="bi bi-envelope me-2"></i>{{ $user->email }}</p>

                        <!-- User Details -->
                        <div class="mt-4">
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="bi bi-hash me-2"></i>User ID
                                </div>
                                <div class="info-value">
                                    <strong>{{ $user->userID }}</strong>
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">
                                    <i class="bi bi-person me-2"></i>Nama Lengkap
                                </div>
                                <div class="info-value">
                                    {{ $user->userName }}
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">
                                    <i class="bi bi-envelope me-2"></i>Email
                                </div>
                                <div class="info-value">
                                    {{ $user->email }}
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">
                                    <i class="bi bi-telephone me-2"></i>Nomor Telepon
                                </div>
                                <div class="info-value">
                                    {{ $user->phone ?? '-' }}
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">
                                    <i class="bi bi-shield-check me-2"></i>Role
                                </div>
                                <div class="info-value">
                                    @if($user->role == 'Admin')
                                        <span class="badge-custom badge-role-admin">
                                            <i class="bi bi-shield-fill-check me-1"></i>{{ $user->role }}
                                        </span>
                                    @elseif($user->role == 'Dosen')
                                        <span class="badge-custom badge-role-dosen">
                                            <i class="bi bi-mortarboard-fill me-1"></i>{{ $user->role }}
                                        </span>
                                    @else
                                        <span class="badge-custom badge-role-mahasiswa">
                                            <i class="bi bi-person-fill me-1"></i>{{ $user->role }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">
                                    <i class="bi bi-toggle-on me-2"></i>Status
                                </div>
                                <div class="info-value">
                                    @if($user->status == 'Active')
                                        <span class="badge-custom badge-status-active">
                                            <i class="bi bi-check-circle-fill me-1"></i>Active
                                        </span>
                                    @else
                                        <span class="badge-custom badge-status-inactive">
                                            <i class="bi bi-x-circle-fill me-1"></i>Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">
                                    <i class="bi bi-calendar-plus me-2"></i>Terdaftar Sejak
                                </div>
                                <div class="info-value">
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d F Y, H:i') }} WIB
                                    <small class="text-muted">({{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }})</small>
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">
                                    <i class="bi bi-clock-history me-2"></i>Terakhir Diupdate
                                </div>
                                <div class="info-value">
                                    {{ \Carbon\Carbon::parse($user->updated_at)->format('d F Y, H:i') }} WIB
                                    <small class="text-muted">({{ \Carbon\Carbon::parse($user->updated_at)->diffForHumans() }})</small>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-custom">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <a href="{{ route('admin.users.edit', $user->userID) }}" class="btn btn-edit btn-custom">
                                <i class="bi bi-pencil me-1"></i> Edit User
                            </a>
                            <button type="button" class="btn btn-delete btn-custom" onclick="confirmDelete()">
                                <i class="bi bi-trash me-1"></i> Hapus User
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Stats -->
                <div class="detail-card">
                    <div class="card-header-custom">
                        <h4><i class="bi bi-graph-up me-2"></i>Quick Stats</h4>
                    </div>
                    <div class="card-body-custom">
                        <div class="stats-mini">
                            <i class="bi bi-calendar-check"></i>
                            <h3>{{ \Carbon\Carbon::parse($user->created_at)->diffInDays(now()) }}</h3>
                            <p>Hari Bergabung</p>
                        </div>

                        <div class="stats-mini">
                            <i class="bi bi-activity"></i>
                            <h3>{{ $user->status == 'Active' ? 'Aktif' : 'Tidak Aktif' }}</h3>
                            <p>Status Akun</p>
                        </div>
                    </div>
                </div>

                <!-- Activity Timeline -->
                <div class="detail-card">
                    <div class="card-header-custom">
                        <h4><i class="bi bi-clock-history me-2"></i>Aktivitas Terakhir</h4>
                    </div>
                    <div class="card-body-custom">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>User Terdaftar</h6>
                                <p>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-pencil"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Data Terakhir Diupdate</h6>
                                <p>{{ \Carbon\Carbon::parse($user->updated_at)->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        @if($user->status == 'Active')
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Status Aktif</h6>
                                <p>User dapat mengakses sistem</p>
                            </div>
                        </div>
                        @endif
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
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus user <strong>{{ $user->userName }}</strong>?</p>
                    <p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan dan semua data terkait akan dihapus.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.users.destroy', $user->userID) }}" method="POST" style="display: inline;">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function confirmDelete() {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
</body>
</html>