<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - MotoKeep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .register-container {
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

        .register-card {
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

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            font-size: 20px;
            color: #3b358b;
        }

        .badge-petugas {
            background: #0dcaf0;
        }
    </style>
</head>

<body>
    <div class="register-container">
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
            <div class="register-card">
                <div class="brand-logo mb-3">
                    <img src="{{ asset('images/motokeep-biru.png') }}" alt="Logo" style="height:40px;">
                </div>
                <h4 class="mb-2">Registrasi</h4>
                <p class="text-muted mb-4">Isi data dengan benar.</p>

                <!-- PESAN ERROR -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- FORM REGISTRASI -->
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username"
                            class="form-control @error('username') is-invalid @enderror" placeholder="example123"
                            value="{{ old('username') }}" required autofocus>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="example@example.com" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <div class="position-relative">
                            <input id="reg_password" type="password" name="password" placeholder="minimal 6 karakter"
                                class="form-control pe-5 @error('password') is-invalid @enderror" required
                                oninput="checkPasswordInput('reg_password', 'toggleRegPass')">

                            <i id="toggleRegPass"
                                class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
                                onclick="togglePassword('reg_password', this)" style="cursor: pointer; display: none;">
                            </i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <div class="position-relative">
                            <input id="reg_password_confirmation" type="password" name="password_confirmation"
                                placeholder="masukkan ulang password" class="form-control pe-5" required
                                oninput="checkPasswordInput('reg_password_confirmation', 'toggleRegConfirm')">

                            <i id="toggleRegConfirm"
                                class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
                                onclick="togglePassword('reg_password_confirmation', this)"
                                style="cursor: pointer; display: none;">
                            </i>
                        </div>
                    </div>

                    <!-- ROLE HANYA PETUGAS -->
                    <input type="hidden" name="role" value="petugas">

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Daftar</button>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">Kembali</a>
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
