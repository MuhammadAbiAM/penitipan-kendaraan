<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MotoKeep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
        }

        .left-side {
            background-color: #3b358b;
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .left-side h2 {
            font-weight: bold;
        }

        .right-side {
            background: white;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3rem;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
        }

        .btn-primary {
            background-color: #3b358b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2e2870;
        }

        .btn-outline-primary {
            border-color: #3b358b;
            color: #3b358b;
        }

        .btn-outline-primary:hover {
            background-color: #3b358b;
            color: white;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            font-size: 20px;
            color: #3b358b;
        }

        .role-info {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 1rem;
            text-align: center;
        }

        .badge-admin { background-color: #dc3545; }
        .badge-petugas { background-color: #0dcaf0; }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Left side -->
        <div class="left-side">
            <h2>Selamat Datang</h2>
            <p>Catat Masuk, Hitung Keluar, Semua Otomatis.</p>
            <img src="{{ asset('/storage/images/petugas-removebg-preview.png') }}" alt="Security" class="img-fluid mt-4" style="max-height:250px;">
        </div>

        <!-- Right side -->
        <div class="right-side">
            <div class="login-card">
                <div class="brand-logo mb-3">
                    <img src="{{ asset('storage/images/motokeep-biru-removebg-preview.png') }}" alt="Logo" style="height:40px;">
                    <span>MotoKeep</span>
                </div>
                <h4 class="mb-2">Log in</h4>
                <p class="text-muted mb-4">Silakan login sesuai peran Anda.</p>

                <!-- PESAN ERROR -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- FORM LOGIN -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input id="username" type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                            placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 text-end">
                        <a href="#" class="text-decoration-none" style="color:#3b358b;">Lupa Password?</a>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">
                            Log In
                        </button>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary">
                            Daftar Akun Baru
                        </a>
                    </div>
                </form>

                <!-- INFO ROLE -->
                <div class="role-info mt-4">
                    <p class="mb-2"><strong>Pilih role saat registrasi:</strong></p>
                    <span class="badge badge-admin me-2">Admin</span>
                    <span class="badge badge-petugas">Petugas</span>
                    <p class="mt-2 mb-0"><small>Admin: Kelola pengguna<br>Petugas: Input motor & hitung tarif</small></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>