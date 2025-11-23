<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MotoKeep')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/title.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: #3f51b5;
            color: #fff;
            padding: 20px 15px;
            border-top-right-radius: 25px;
            border-bottom-right-radius: 25px;
            display: flex;
            flex-direction: column;
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        .sidebar .brand img {
            width: 40px;
            height: 40px;
        }

        .sidebar .brand h5 {
            font-weight: bold;
            margin: 0;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 5px 0;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #fff;
            color: #3f51b5;
            font-weight: 500;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .badge-admin {
            background: #dc3545;
            color: white;
        }

        .badge-petugas {
            background: #0dcaf0;
            color: black;
        }

        .rounded-3 {
            border-radius: 0.75rem !important;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }

        .user-info {
            padding: 15px;
            border-radius: 18px;
            backdrop-filter: blur(14px);
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.15);
            display: flex;
            width: 100%;
        }

        .avatar-glass {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            backdrop-filter: blur(20px);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.35), rgba(255, 255, 255, 0.1));
            border: 1px solid rgba(255, 255, 255, 0.35);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
        }

        .username-text {
            font-size: 15px;
            color: #ffffff;
            margin: 0;
        }

        .role-chip {
            display: inline-block;
            padding: 2px 12px;
            font-size: 12.5px;
            border-radius: 50px;
            font-weight: 600;
        }

        .admin-chip {
            background: rgba(220, 53, 69, 0.85);
            color: white;
        }

        .petugas-chip {
            background: rgba(13, 202, 240, 0.85);
            color: #00333f;
        }

        .logout-btn {
            background: linear-gradient(135deg, #f2971a, #f26a1a);
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.25s;
            font-weight: 600;
        }

        .logout-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4">
            <img src="{{ asset('images/motokeep-putih.png') }}" alt="Logo" style="height:60px;">
        </div>

        @auth
            @if (Auth::user()->isAdmin())
                <!-- MENU ADMIN -->
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Kelola Pengguna
                </a>
            @else
                <!-- MENU PETUGAS -->
                <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
                <a href="{{ route('penitipan.index') }}" class="{{ request()->is('penitipan*') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-in-right"></i> Penitipan
                </a>
                <a href="{{ route('laporan.index') }}" class="{{ request()->is('laporan*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> Laporan
                </a>
            @endif
        @endauth

        <div class="flex-grow-1"></div>
        <!-- USER INFO -->
        @auth
            <div class="user-info d-flex align-items-center mt-3">

                <div class="avatar-glass me-3">
                    <span>{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</span>
                </div>

                <div class="text-start">
                    <p class="fw-semibold username-text mb-1">
                        {{ Auth::user()->username }}
                    </p>
                    <span class="role-chip {{ Auth::user()->isAdmin() ? 'admin-chip' : 'petugas-chip' }}">
                        {{ Auth::user()->isAdmin() ? 'Admin' : 'Petugas' }}
                    </span>
                </div>

            </div>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="mb-3 mt-3 px-3">
                @csrf
                <button type="submit" class="logout-btn w-100">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Log Out
                </button>
            </form>
        @endauth

    </div>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const logoutForm = document.querySelector('form[action="{{ route('logout') }}"]');

            if (logoutForm) {
                logoutForm.addEventListener("submit", function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: "Log Out?",
                        text: "Anda yakin ingin keluar dari sistem?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Ya, Log Out",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutForm.submit();
                        }
                    });
                });
            }
        });
    </script>

    @yield('scripts')

</body>

</html>
