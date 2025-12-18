<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Lab - User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
        }
        .page-header {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 16px;
        }
        .status-badge {
            font-size: 0.8rem;
            border-radius: 999px;
            padding: 4px 10px;
        }
    </style>
</head>
<body>
    @include('layouts.partials.user-navbar')
    
    <div class="container-fluid px-4 py-4">
        <div class="page-header d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h3 class="fw-bold mb-1">Jadwal Penggunaan Lab Komputer</h3>
                <p class="text-muted mb-0 small">
                    Lihat jadwal penggunaan lab agar tidak terjadi bentrok penggunaan.
                </p>
            </div>

            <div class="d-flex gap-2 mt-3 mt-md-0">
                <select class="form-select form-select-sm">
                    <option selected>Semua Lab</option>
                    <option>Lab Komputer 1</option>
                    <option>Lab Komputer 2</option>
                    <option>Lab Jaringan</option>
                    <option>Lab Multimedia</option>
                </select>
                <select class="form-select form-select-sm">
                    <option selected>Semua Hari</option>
                    <option>Senin</option>
                    <option>Selasa</option>
                    <option>Rabu</option>
                    <option>Kamis</option>
                    <option>Jumat</option>
                </select>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Lab</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Mata Kuliah / Kegiatan</th>
                                <th>Dosen / Penanggung Jawab</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules ?? [] as $schedule)
                                <tr>
                                    <td>{{ $schedule->lab_name }}</td>
                                    <td>{{ $schedule->day }}</td>
                                    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                    <td>{{ $schedule->course }}</td>
                                    <td>{{ $schedule->lecturer }}</td>
                                    <td>
                                        @php
                                            $status = strtolower($schedule->status);
                                        @endphp
                                        @if($status === 'berjalan')
                                            <span class="status-badge bg-success text-white">Berjalan</span>
                                        @elseif($status === 'akan datang')
                                            <span class="status-badge bg-warning text-dark">Akan Datang</span>
                                        @else
                                            <span class="status-badge bg-secondary text-white">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada jadwal yang tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <p class="text-muted small mt-2 mb-0">
                    * Jadwal dapat berubah sewaktu-waktu. Pastikan mengecek kembali sebelum menggunakan lab.
                </p>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>