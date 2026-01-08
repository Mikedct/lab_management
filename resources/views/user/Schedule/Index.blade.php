<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Schedule - User</title>

    <!-- Bootstrap -->
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
            display: inline-block;
            min-width: 90px;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- Navbar User --}}
    @include('layouts.partials.user-navbar')

    <div class="container-fluid px-4 py-4">

        {{-- Header --}}
        <div class="page-header d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h3 class="fw-bold mb-1">Computer Lab Usage Schedule</h3>
                <p class="text-muted mb-0 small">
                    Check the lab schedule to avoid conflicts.
                </p>
            </div>

            {{-- Filter --}}
            <form method="GET" class="d-flex gap-2 mt-3 mt-md-0">
                <select name="lab_name" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Lab</option>
                    @foreach($labs as $lab)
                        <option value="{{ $lab->lab_name }}"
                            {{ request('lab_name') == $lab->lab_name ? 'selected' : '' }}>
                            {{ $lab->lab_name }}
                        </option>
                    @endforeach
                </select>

                <select name="day" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Hari</option>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)
                        <option value="{{ $day }}"
                            {{ request('day') == $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Table --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Lab</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Course / Activity</th>
                                <th>Lecturer / Person in Charge</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->lab_name }}</td>
                                    <td>{{ $schedule->day }}</td>
                                    <td>
                                        {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                    </td>
                                    <td>{{ $schedule->course }}</td>
                                    <td>{{ $schedule->lecturer }}</td>
                                    <td>
                                        @php
                                            $statusMap = [
                                                'active' => ['label' => 'In Progress', 'class' => 'bg-success text-white'],
                                                'inactive' => ['label' => 'Coming Soon', 'class' => 'bg-warning text-dark'],
                                                'cancelled' => ['label' => 'Cancelled', 'class' => 'bg-secondary text-white'],
                                            ];

                                            $status = $statusMap[$schedule->status] ?? [
                                                'label' => 'Done',
                                                'class' => 'bg-secondary text-white'
                                            ];
                                        @endphp

                                        <span class="status-badge {{ $status['class'] }}">
                                            {{ $status['label'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No schedule is available yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <p class="text-muted small mt-3 mb-0">
                    * The schedule is subject to change at any time. Be sure to check again before using the lab.
                </p>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
