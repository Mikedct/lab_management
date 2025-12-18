<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Dashboard - Lab Management</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);
            padding: 40px 0;
            margin-bottom: 30px;
            color: white;
        }

        .menu-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: 0.3s;
            text-decoration: none;
            color: inherit;
            height: 100%;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(33,150,243,0.2);
        }

        .menu-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: #fff;
        }

        .schedule .menu-icon {
            background: linear-gradient(135deg, #42a5f5, #1e88e5);
        }

        .report .menu-icon {
            background: linear-gradient(135deg, #66bb6a, #43a047);
        }

        .menu-title {
            font-size: 22px;
            font-weight: bold;
        }

        .menu-description {
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>

    <!-- Navbar User -->
    @include('layouts.partials.user-navbar')

    <!-- Header -->
    <div class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2>
                        <i class="bi bi-person-circle me-2"></i>
                        Dashboard User
                    </h2>
                    <p>
                        Selamat datang, <strong>{{ session('userName', 'User') }}</strong>
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
                    <div class="mt-2">
                        <i class="bi bi-clock me-1"></i>
                        <span id="current-time"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu -->
    <div class="container">
        <h4 class="mb-4 fw-bold">
            <i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>
            Menu Utama
        </h4>

        <div class="row g-4">
            <!-- Schedule -->
            <div class="col-md-6">
                <div class="menu-card schedule" onclick="comingSoon()">
                    <div class="menu-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <h5 class="menu-title">Jadwal Lab</h5>
                    <p class="menu-description">
                        Lihat jadwal penggunaan lab dan reservasi Anda
                    </p>
                    <span class="badge bg-warning text-dark mt-2">
                        <i class="bi bi-clock-history me-1"></i> Dalam Pengembangan
                    </span>
                </div>
            </div>

            <!-- Report -->
            <div class="col-md-6">
                <div class="menu-card report" onclick="comingSoon()">
                    <div class="menu-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <h5 class="menu-title">Laporan</h5>
                    <p class="menu-description">
                        Riwayat penggunaan lab dan laporan aktivitas
                    </p>
                    <span class="badge bg-warning text-dark mt-2">
                        <i class="bi bi-clock-history me-1"></i> Dalam Pengembangan
                    </span>
                </div>
            </div>
        </div>

    <!-- Footer -->
    <div class="mt-5 text-center text-muted py-4 bg-white border-top">
        <small>© {{ date('Y') }} Univ UBD - Lab Management System</small>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            document.getElementById('current-time').textContent =
                now.toLocaleTimeString('id-ID');
        }
        updateTime();
        setInterval(updateTime, 1000);
    </script>

    <script>
        function comingSoon() {
            alert('Fitur ini masih dalam tahap pengembangan 🚧');
        }
    </script>

</body>
</html>
