<!doctype html>
<html lang="en">

@php
    use App\Models\Setting;
    $set = Setting::first();
@endphp

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $set->nama_optik ?? 'SIM Optik' }} | Login Page</title>

    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="SIM Optik | Login Page" />
    <meta name="description" content="Sistem Informasi Optik by wokaproject.id" />

    <!-- Fonts -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" />

    <!-- Overlay Scrollbar -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.css') }}" />

    <style>
        .login-logo img {
            width: 150px;
            height: auto;
            filter: drop-shadow(0 0 10px rgba(0, 255, 255, 0.7));
        }

        .bg-dynamic {
            background-size: cover !important;
            background-position: center !important;
            min-height: 100vh !important;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(4px);
            padding: 30px;
            border-radius: 12px;
        }
    </style>
</head>

<body class="login-page bg-body-secondary bg-dynamic"
      @if($set && $set->background)
        style="background-image: url('{{ asset('storage/'.$set->background) }}');"
      @endif
>

<div class="login-box">

    {{-- Logo & Nama Optik --}}
    <div class="login-logo text-center">
        @if($set && $set->logo)
            <img src="{{ asset('storage/' . $set->logo) }}" alt="Logo Optik">
        @else
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Optik">
        @endif

        <br>
        <a href="/" class="fw-bold" style="font-size: 28px;">
            <b>{{ $set->nama_optik ?? 'SIM Optik' }}</b>
        </a>
        <p style="margin-top: -5px; font-size: 14px; color: #555;">
            {{ $set->alamat_optik ?? '' }}
        </p>
    </div>

    {{-- Form Login --}}
    <div class="card shadow">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Silahkan login untuk masuk ke sistem</p>

            <form action="{{ route('login.proses') }}" method="post">
                @csrf

                {{-- Username --}}
                <div class="input-group mb-3">
                    <input type="text"
                        name="username"
                        class="form-control @error('username') is-invalid @enderror"
                        placeholder="Username"
                        value="{{ old('username') }}"
                        required>
                    <div class="input-group-text">
                        <span class="bi bi-person"></span>
                    </div>
                </div>
                @error('username') <div class="text-danger mb-2">{{ $message }}</div> @enderror


                {{-- Password --}}
                <div class="input-group mb-3">
                    <input type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password"
                        required>
                    <div class="input-group-text">
                        <span class="bi bi-lock-fill"></span>
                    </div>
                </div>
                @error('password') <div class="text-danger mb-2">{{ $message }}</div> @enderror


                {{-- Remember Me + Button --}}
                <div class="row">
                    <div class="col-8">
                        <div class="form-check">
                            <input class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember" />
                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/adminlte.js') }}"></script>

</body>
</html>
