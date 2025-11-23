@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-1">Tambah Pengguna</h3>
        <p class="text-muted">{{ now()->translatedFormat('d F Y') }}</p>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username') }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required>
                        @error('email')
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

                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <div class="position-relative">
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                class="form-control pe-5" required
                                oninput="checkPasswordInput('password_confirmation', 'toggleRegConfirm')">

                            <i id="toggleRegConfirm"
                                class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
                                onclick="togglePassword('password_confirmation', this)"
                                style="cursor: pointer; display: none;">
                            </i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-3">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary rounded-3">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

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
