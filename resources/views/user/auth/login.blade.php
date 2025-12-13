<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User - Lab Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #b72024, #7d1418);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            max-width: 420px;
            width: 100%;
            border-radius: 18px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.25);
        }
        .brand-title {
            font-weight: 700;
            color: #b72024;
        }
    </style>
</head>
<body>
<div class="card card-login p-4 bg-white">
    <div class="text-center mb-3">
        <img src="{{ asset('images/logo-UBD.png') }}" alt="Logo UBD" height="60"
             onerror="this.style.display='none'">
        <h5 class="mt-2 brand-title">Lab Management System</h5>
        <p class="text-muted small mb-0">Login sebagai pengguna lab</p>
    </div>

    {{-- Nanti ganti action ke route login user beneran --}}
    <form method="POST" action="#">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email / NIM</label>
            <input type="text" name="identifier" class="form-control" placeholder="Masukkan email atau NIM">
        </div>

        <div class="mb-3">
            <label class="form-label">Kata Sandi</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi">
        </div>

        <button type="submit" class="btn w-100 text-white" style="background-color:#b72024;">
            Masuk
        </button>

        <p class="mt-3 mb-0 text-center text-muted small">
            Jika mengalami kendala, hubungi Aslab.
        </p>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
