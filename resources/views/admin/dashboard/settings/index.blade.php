<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan Akun - Lab Management</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }

        .page-header {
            background: linear-gradient(135deg, #b72024 0%, #d32f2f 100%);
            padding: 30px 0;
            margin-bottom: 30px;
            color: white;
        }

        .settings-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 30px;
        }

        .settings-card h5 {
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
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
            border-color: #b72024;
            box-shadow: 0 0 0 0.2rem rgba(183, 32, 36, 0.15);
        }

        .btn-save {
            background: linear-gradient(135deg, #b72024 0%, #d32f2f 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(183, 32, 36, 0.3);
            color: white;
        }

        .required-mark {
            color: #dc3545;
        }

        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-box i {
            color: #2196f3;
            font-size: 18px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #b72024 0%, #d32f2f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 42px;
            font-weight: bold;
            margin: 0 auto 20px;
            box-shadow: 0 4px 15px rgba(183, 32, 36, 0.3);
        }

        .admin-info {
            text-align: center;
            margin-bottom: 30px;
        }

        .admin-info h4 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .admin-info p {
            color: #666;
            margin: 0;
        }
    </style>
</head>
<body>
    @include('layouts.partials.admin-navbar')

    <div class="page-header">
        <div class="container">
            <h2><i class="bi bi-gear me-2"></i>Pengaturan Akun</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: rgba(255,255,255,0.8);">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: white;">Pengaturan</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terdapat kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Profile Info -->
                <div class="settings-card">
                    <div class="admin-info">
                        <div class="profile-avatar">
                            {{ strtoupper(substr($admin->adminName, 0, 1)) }}
                        </div>
                        <h4>{{ $admin->adminName }}</h4>
                        <p>{{ $admin->email }}</p>
                        <span class="badge bg-danger mt-2">Administrator</span>
                    </div>
                </div>

                <!-- Edit Profile -->
                <div class="settings-card">
                    <h5><i class="bi bi-person-circle me-2"></i>Edit Profil</h5>
                    
                    <form action="{{ route('admin.settings.update-profile') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="adminName" class="form-label">
                                    Nama Lengkap <span class="required-mark">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('adminName') is-invalid @enderror" 
                                       id="adminName" 
                                       name="adminName" 
                                       value="{{ old('adminName', $admin->adminName) }}"
                                       required>
                                @error('adminName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label">
                                    Email <span class="required-mark">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $admin->email) }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="phoneNumber" class="form-label">Nomor Telepon</label>
                                <input type="text" 
                                       class="form-control @error('phoneNumber') is-invalid @enderror" 
                                       id="phoneNumber" 
                                       name="phoneNumber" 
                                       value="{{ old('phoneNumber', $admin->phoneNumber ?? '') }}"
                                       placeholder="08xxxxxxxxxx">
                                @error('phoneNumber')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-save">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="settings-card">
                    <h5><i class="bi bi-key me-2"></i>Ubah Password</h5>
                    
                    <div class="info-box">
                        <i class="bi bi-info-circle me-2"></i>
                        <span>Password harus minimal 6 karakter untuk keamanan akun Anda</span>
                    </div>

                    <form action="{{ route('admin.settings.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="current_password" class="form-label">
                                    Password Lama <span class="required-mark">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password" 
                                       placeholder="Masukkan password lama"
                                       required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="new_password" class="form-label">
                                    Password Baru <span class="required-mark">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control @error('new_password') is-invalid @enderror" 
                                       id="new_password" 
                                       name="new_password" 
                                       placeholder="Minimal 6 karakter"
                                       required>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="new_password_confirmation" class="form-label">
                                    Konfirmasi Password Baru <span class="required-mark">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="new_password_confirmation" 
                                       name="new_password_confirmation" 
                                       placeholder="Ulangi password baru"
                                       required>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-save">
                                <i class="bi bi-key me-1"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Info -->
                <div class="settings-card">
                    <h5><i class="bi bi-info-circle me-2"></i>Informasi Akun</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong>Admin ID:</strong></p>
                            <p class="text-muted">{{ $admin->adminID }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong>Status:</strong></p>
                            <span class="badge bg-success">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>