<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - MotoKeep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .register-container { min-height: 100vh; display: flex; }
        .left-side { background-color: #3b358b; color: white; flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2rem; }
        .left-side h2 { font-weight: bold; }
        .right-side { background: white; flex: 1; display: flex; justify-content: center; align-items: center; padding: 3rem; }
        .register-card { width: 100%; max-width: 420px; }
        .btn-primary { background-color: #3b358b; border: none; }
        .btn-primary:hover { background-color: #2e2870; }
        .brand-logo { display: flex; align-items: center; gap: 10px; font-weight: bold; font-size: 20px; color: #3b358b; }
        .badge-petugas { background: #0dcaf0; }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Left side -->
        <div class="left-side">
            <h2>Daftar Akun Petugas</h2>
            <p>Untuk admin, hubungi pengelola.</p>
            <img src="{{ asset('/storage/images/petugas-removebg-preview.png') }}" alt="Security" class="img-fluid mt-4" style="max-height:250px;">
        </div>

        <!-- Right side -->
        <div class="right-side">
            <div class="register-card">
                <div class="brand-logo mb-3">
                    <img src="{{ asset('storage/images/motokeep-biru-removebg-preview.png') }}" alt="Logo" style="height:40px;">
                    <span>MotoKeep</span>
                </div>
                <h4 class="mb-2">Registrasi Petugas</h4>
                <p class="text-muted mb-4">Isi data dengan benar.</p>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                               value="{{ old('username') }}" required>
                        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <!-- ROLE HANYA PETUGAS -->
                    <input type="hidden" name="role" value="petugas">

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Daftar Petugas</button>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">Kembali ke Login</a>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <small class="text-muted">
                        <span class="badge badge-petugas">Petugas</span> Input motor & tarif
                    </small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>