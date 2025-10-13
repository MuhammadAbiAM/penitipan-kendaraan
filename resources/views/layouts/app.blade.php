<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penitipan Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #3f51b5;
            /* warna ungu kebiruan */
            color: #fff;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;

            border-top-right-radius: 25px;
            /* pojok kanan atas melengkung */
            border-bottom-right-radius: 25px;
            /* pojok kanan bawah melengkung */
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

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            /* rata tengah */
            gap: 10px;
            /* jarak ikon dan teks */
            margin: 20px 0;
        }

        .logo-container i {
            font-size: 28px;
            /* atur ukuran ikon */
            color: #fff;
            /* pastikan warnanya putih */
        }

        .logo-text {
            font-weight: 600;
            font-size: 20px;
            color: #fff;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-container">
            <div class="brand-logo mb-3">
                <img src="{{ asset('storage/images/motokeep-putih.png') }}" alt="Logo" style="height:60px;">
            </div>
        </div>

        <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="{{ route('penitipan.index') }}" class="{{ request()->is('penitipan*') ? 'active' : '' }}">
            <i class="bi bi-box-arrow-in-right"></i> Penitipan
        </a>
        <a href="{{ route('laporan.index') }}" class="{{ request()->is('laporan') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Laporan
        </a>

        <!-- Spacer biar tombol logout turun ke bawah -->
        <div class="flex-grow-1"></div>

        <!-- Tombol Logout -->
        <form action="{{ route('logout') }}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="btn w-100"
                style="background-color:#f28c13; color:#fff; font-weight:500; border-radius:8px;">
                Log Out
            </button>
        </form>
    </div>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
