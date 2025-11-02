<!doctype html>
<html lang="en">

@php
    use App\Models\Setting;
    $set = Setting::first();
@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $set->nama_optik ?? 'SIM Optik' }} | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Login Style -->
    <style>
        body {
            font-family: "Source Sans 3", sans-serif;
        }

        .bg-dynamic {
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.30);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            padding: 35px;
            width: 420px;
        }

        .logo-login {
            width: 120px;
            border-radius: 12px;
        }

        .subtitle {
            margin-top: -3px;
            color: #555;
            font-size: 14px;
        }

        .login-wrapper {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body class="bg-dynamic"
    @if($set && $set->background)
        style="background-image: url('{{ asset('storage/'.$set->background) }}');"
    @endif>

<div class="login-wrapper">

    <div class="glass-card shadow-lg">

        {{-- Logo --}}
        <div class="text-center mb-3">
            @if($set && $set->logo)
                <img src="{{ asset('storage/' . $set->logo) }}" class="logo-login">
            @else
                <img src="{{ asset('assets/img/logo.png') }}" class="logo-login">
            @endif

            <h3 class="fw-bold mt-3">{{ $set->nama_optik ?? 'SIM Optik' }}</h3>
            <p class="subtitle">{{ $set->alamat_optik ?? '' }}</p>
        </div>

  {{-- HANDLE ERROR SERVER (AUTH / VALIDASI) --}}
@if ($errors->any())
    <div class="alert alert-danger d-flex align-items-center mb-3" role="alert"
         style="border-radius: 10px;">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <span>{{ $errors->first() }}</span>
    </div>
@endif


        {{-- Form Login --}}
        <form action="{{ route('login.proses') }}" method="POST">
            @csrf

            <label class="fw-semibold mb-1">Username</label>
            <div class="input-group mb-3">
                <input type="text" name="username" class="form-control" placeholder="Masukkan username"
                    value="{{ old('username') }}" required>
                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
            </div>

            <label class="fw-semibold mb-1">Password</label>
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Masukkan password"
                    required>
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input">
                    <label class="form-check-label">Ingat Saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2"
                style="border-radius: 10px; font-size: 16px;">
                Login
            </button>

        </form>

    </div>
</div>


<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
