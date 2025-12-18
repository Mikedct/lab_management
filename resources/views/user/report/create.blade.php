<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Laporan - Lab Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .page-header {
            background: linear-gradient(135deg, #b72024 0%, #7d1418 100%);
            padding: 24px 0;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,.12);
        }
        .header-content { color: #fff; }
        .header-content h2 { font-size: 26px; font-weight: 800; margin-bottom: 6px; }
        .card-form {
            background: #fff;
            border-radius: 14px;
            border: none;
            box-shadow: 0 2px 12px rgba(0,0,0,.08);
        }
        .btn-danger {
            background-color: #b72024;
            border-color: #b72024;
        }
        .btn-danger:hover {
            background-color: #9f1b1f;
            border-color: #9f1b1f;
        }
    </style>
</head>
<body>

@include('layouts.partials.user-navbar')

<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="header-content">
            <h2><i class="bi bi-plus-circle-fill me-2"></i>Buat Laporan</h2>
            <p class="mb-0 small">Laporkan masalah pada komputer agar dapat segera ditindaklanjuti.</p>
        </div>
        <a href="{{ route('user.reports.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            {{-- Error --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Periksa kembali input kamu:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-form">
                <div class="card-body p-4">

                    <form action="{{ route('user.reports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- LAB --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Lab</label>
                            <select class="form-select" name="lab_id" id="labSelect" required>
                                <option value="">-- Pilih Lab --</option>
                                @foreach($labs as $lab)
                                    <option value="{{ $lab->labID }}" {{ old('lab_id') == $lab->labID ? 'selected' : '' }}>
                                        {{ $lab->labName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- KOMPUTER --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Komputer</label>
                            <select class="form-select" name="computer_id" id="computerSelect" required>
                                <option value="">-- Pilih Lab terlebih dahulu --</option>
                            </select>
                            <small class="text-muted">
                                Jika tidak ada, pilih yang paling mendekati dan jelaskan di deskripsi.
                            </small>
                        </div>

                        {{-- JUDUL --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Laporan</label>
                            <input type="text" class="form-control" name="title"
                                   value="{{ old('title') }}"
                                   placeholder="Contoh: Komputer tidak bisa login"
                                   required>
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi Masalah</label>
                            <textarea class="form-control" name="description" rows="5"
                                      placeholder="Jelaskan masalah secara detail"
                                      required>{{ old('description') }}</textarea>
                        </div>

                        {{-- FOTO --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Lampiran Foto (opsional)</label>
                            <input type="file" class="form-control" name="attachment" accept="image/*">
                            <small class="text-muted">Upload foto layar error / kondisi komputer.</small>
                        </div>

                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-send me-1"></i> Kirim Laporan
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- DATA KOMPUTER --}}
<script>
    const computersByLab = @json($computersByLab);

    const labSelect = document.getElementById('labSelect');
    const computerSelect = document.getElementById('computerSelect');

    function renderComputers(labId) {
        computerSelect.innerHTML = '';

        if (!labId || !computersByLab[labId]) {
            computerSelect.innerHTML = `<option value="">-- Tidak ada komputer --</option>`;
            return;
        }

        computerSelect.innerHTML = `<option value="">-- Pilih Komputer --</option>`;

        computersByLab[labId].forEach(pc => {
            const option = document.createElement('option');
            option.value = pc.computerID;
            option.textContent = pc.computerName;
            computerSelect.appendChild(option);
        });
    }

    labSelect.addEventListener('change', function () {
        renderComputers(this.value);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
