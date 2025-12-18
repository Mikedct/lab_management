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
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-content">
                    <h2><i class="bi bi-plus-circle-fill me-2"></i>Buat Laporan</h2>
                    <p class="mb-0 small">Laporkan masalah pada komputer agar dapat segera ditindaklanjuti.</p>
                </div>
                <a href="{{ route('user.reports.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <div class="fw-semibold mb-1">Periksa kembali input kamu:</div>
                        <ul class="mb-0">
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

                            <div class="mb-3">
                                <label class="form-label">Pilih Lab</label>
                                <select class="form-select" name="lab_id" id="labSelect" required>
                                    <option value="">-- Pilih Lab --</option>
                                    @foreach($labs ?? [] as $lab)
                                        <option value="{{ $lab->labID ?? $lab->id }}">
                                            {{ $lab->labName ?? $lab->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pilih Komputer</label>
                                <select class="form-select" name="computer_id" id="computerSelect" required>
                                    <option value="">-- Pilih Lab terlebih dahulu --</option>
                                </select>
                                <div class="text-muted small mt-1">
                                    Jika komputernya tidak ada di daftar, pilih yang paling mendekati / laporkan di deskripsi.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Judul Laporan</label>
                                <input type="text" class="form-control" name="title"
                                       placeholder="Contoh: Komputer tidak bisa login / monitor mati"
                                       value="{{ old('title') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Masalah</label>
                                <textarea class="form-control" name="description" rows="5"
                                          placeholder="Jelaskan masalah secara detail (error apa, kapan terjadi, tindakan yang sudah dicoba, dll)"
                                          required>{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Lampiran Foto (opsional)</label>
                                <input type="file" class="form-control" name="attachment" accept="image/*">
                                <div class="text-muted small mt-1">Boleh upload foto layar error / kondisi komputer.</div>
                            </div>

                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-send me-1"></i> Kirim Laporan
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Data komputer untuk filtering --}}
                <script>
                    // Struktur data: labId -> list komputer
                    const computersByLab = @json(($computersByLab ?? []));

                    const labSelect = document.getElementById('labSelect');
                    const computerSelect = document.getElementById('computerSelect');

                    function renderComputers(labId) {
                        computerSelect.innerHTML = '';
                        if (!labId || !computersByLab[labId] || computersByLab[labId].length === 0) {
                            const opt = document.createElement('option');
                            opt.value = '';
                            opt.textContent = '-- Tidak ada komputer untuk lab ini --';
                            computerSelect.appendChild(opt);
                            return;
                        }

                        const first = document.createElement('option');
                        first.value = '';
                        first.textContent = '-- Pilih Komputer --';
                        computerSelect.appendChild(first);

                        computersByLab[labId].forEach(pc => {
                            const opt = document.createElement('option');
                            opt.value = pc.id;
                            opt.textContent = pc.name;
                            computerSelect.appendChild(opt);
                        });
                    }

                    labSelect?.addEventListener('change', function () {
                        renderComputers(this.value);
                    });
                </script>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
