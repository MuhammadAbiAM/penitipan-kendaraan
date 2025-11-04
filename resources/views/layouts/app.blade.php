<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MotoKeep')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: #f8f9fa; }
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 250px;
            background: #3f51b5; color: #fff; padding: 20px 15px;
            border-top-right-radius: 25px; border-bottom-right-radius: 25px;
            display: flex; flex-direction: column;
        }
        .sidebar .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 40px; }
        .sidebar .brand img { width: 40px; height: 40px; }
        .sidebar .brand h5 { font-weight: bold; margin: 0; }
        .sidebar a {
            color: #fff; text-decoration: none; padding: 12px 15px;
            border-radius: 8px; display: flex; align-items: center; gap: 10px;
            margin: 5px 0; transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active { background: #fff; color: #3f51b5; font-weight: 500; }
        .content { margin-left: 250px; padding: 20px; }
        .badge-admin { background: #dc3545; color: white; }
        .badge-petugas { background: #0dcaf0; color: black; }
        .rounded-3 { border-radius: 0.75rem !important; }
        .rounded-4 { border-radius: 1rem !important; }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4">
            <img src="{{ asset('storage/images/motokeep-putih-removebg-preview.png') }}" alt="Logo" style="height:60px;">
        </div>

        @auth
            @if(Auth::user()->isAdmin())
                <!-- MENU ADMIN -->
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
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

        <!-- USER INFO & LOGOUT -->
        @auth
            <div class="text-center mb-3 text-white">
                <p class="mb-1 fw-bold">{{ Auth::user()->username }}</p>
                <span class="badge {{ Auth::user()->isAdmin() ? 'badge-admin' : 'badge-petugas' }} px-3 py-1">
                    {{ Auth::user()->isAdmin() ? 'Admin' : 'Petugas' }}
                </span>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn w-100 text-white" style="background:#f28c13; border-radius:8px; font-weight:500;">
                    Log Out
                </button>
            </form>
        @endauth
    </div>

    <!-- Content -->
    <div class="content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3">
                {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3">
                {{ session('error') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('scripts')
</body>
</html>