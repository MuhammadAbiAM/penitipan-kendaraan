<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MotoKeep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
            /* warna biru ungu */
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
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Left side -->
        <div class="left-side">
            <h2>Selamat Datang</h2>
            <p>Catat Masuk, Hitung Keluar, Semua Otomatis.</p>
            <img src="{{ asset('/storage/images/petugas.png') }}" alt="Security" class="img-fluid mt-4" style="max-height:250px;">
        </div>

        <!-- Right side -->
        <div class="right-side">
            <div class="login-card">
                <div class="brand-logo mb-3">
                    <img src="{{ asset('storage/images/motokeep-biru.png') }}" alt="Logo" style="height:40px;">
                </div>
                <h4 class="mb-2">Log in</h4>
                <p class="text-muted mb-4">Selamat Datang di Sistem Manajemen Parkir Motor, Silakan login untuk memulai.
                </p>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input id="username" type="text" name="username" class="form-control"
                            placeholder="Input username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" name="password" class="form-control"
                            placeholder="Input password" required>
                    </div>
                    <div class="mb-3 text-end">
                        <a href="#" class="text-decoration-none" style="color:#3b358b;">Reset Password Disini</a>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Log In</button>
                        {{-- <a href="{{ route('register') }}" class="btn btn-outline-primary">Buat Akun</a> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
