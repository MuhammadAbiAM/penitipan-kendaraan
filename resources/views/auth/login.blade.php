<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MotoKeep</title>
    <link rel="icon" type="image/png" href="{{ asset('images/title.png') }}">
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
            font-size: 18px;
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
            position: relative;
        }

        .left-text-wrapper {
            margin-top: 110px;
            text-align: center;
        }

        .left-side img {
            position: absolute;
            bottom: 0;
            max-height: 400px;
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
            <div class="left-text-wrapper">
                <h2>Selamat Datang</h2>
                <p>Catat Masuk, Hitung Keluar, Semua Otomatis.</p>
            </div>
            <img src="{{ asset('images/petugas.png') }}" alt="Security">
        </div>


        <!-- Right side -->
        <div class="right-side">
            <div class="login-card">
                <div class="brand-logo mb-3">
                    <img src="{{ asset('images/motokeep-biru.png') }}" alt="Logo" style="height:40px;">
                </div>
                <h4 class="mb-2">Log in</h4>
                <p class="text-muted mb-4">Selamat Datang di Sistem Manajemen Parkir Motor, Silakan login untuk memulai.
                </p>

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
                        <label for="username" class="form-label">Username/Email</label>
                        <input id="username" type="text" name="username"
                            class="form-control @error('username') is-invalid @enderror" placeholder=""
                            value="{{ old('username') }}" required autofocus>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="position-relative">
                            <input id="password" type="password" name="password"
                                class="form-control pe-5 @error('password') is-invalid @enderror" required
                                oninput="checkPasswordInput('password', 'togglePasswordLogin')">

                            <i id="togglePasswordLogin"
                                class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
                                onclick="togglePassword('password', this)" style="cursor: pointer; display: none;">
                            </i>
                        </div>
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
                            Daftar Akun
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }

        function checkPasswordInput(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.value.length > 0) {
                icon.style.display = "block";
            } else {
                icon.style.display = "none";
            }
        }
    </script>

</body>

</html>
