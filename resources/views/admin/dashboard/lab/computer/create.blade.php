<!-- resources/views/admin/dashboard/lab/computer/create.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add Computer - {{ $lab->labName }}</title>
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

        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .required-mark {
            color: #dc3545;
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
    </style>
</head>

<body>
    @include('layouts.partials.admin-navbar')

    <div class="page-header">
        <div class="container">
            <h2><i class="bi bi-pc-display me-2"></i>Add Computer in Lab: {{ $lab->labName }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.lab.index') }}">Labs</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.lab.show', $lab->labID) }}">{{ $lab->labName }}</a>
                    </li>
                    <li class="breadcrumb-item active">Add Computer</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    <form action="{{ route('admin.computer.store', $lab->labID) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="computerName" class="form-label">Computer Name<span
                                    class="required-mark">*</span></label>
                            <input type="text" name="computerName" id="computerName"
                                class="form-control @error('computerName') is-invalid @enderror"
                                value="{{ old('computerName') }}" required>
                            @error('computerName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="required-mark">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                                required>
                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="storage" class="form-label">Storage (GB) <span
                                    class="required-mark">*</span></label>
                            <input type="number" name="storage" id="storage"
                                class="form-control @error('storage') is-invalid @enderror" value="{{ old('storage') }}"
                                required>
                            @error('storage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="OS" class="form-label">OS <span class="required-mark">*</span></label>
                            <input type="text" name="OS" id="OS" class="form-control @error('OS') is-invalid @enderror"
                                value="{{ old('OS') }}" required>
                            @error('OS') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="CPU" class="form-label">CPU <span class="required-mark">*</span></label>
                            <input type="text" name="CPU" id="CPU"
                                class="form-control @error('CPU') is-invalid @enderror" value="{{ old('CPU') }}"
                                required>
                            @error('CPU') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="GPU" class="form-label">GPU <span class="required-mark">*</span></label>
                            <input type="text" name="GPU" id="GPU"
                                class="form-control @error('GPU') is-invalid @enderror" value="{{ old('GPU') }}"
                                required>
                            @error('GPU') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="RAM" class="form-label">RAM (GB) <span class="required-mark">*</span></label>
                            <input type="number" name="RAM" id="RAM"
                                class="form-control @error('RAM') is-invalid @enderror" value="{{ old('RAM') }}"
                                required>
                            @error('RAM') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.lab.show', $lab->labID) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-submit">
                                <i class="bi bi-save me-1"></i> Save Computer
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>