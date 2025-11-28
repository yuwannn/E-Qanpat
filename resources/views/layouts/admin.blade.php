<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - E-Qanpat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            z-index: 1000;
        }
        .sidebar a {
            padding: 15px 25px;
            text-decoration: none;
            font-size: 16px;
            color: #d1d1d1;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            color: #fff;
            background-color: #0d6efd;
        }
        .main-content {
            margin-left: 250px; /* Sesuai lebar sidebar */
            padding: 20px;
        }
        .sidebar-header {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            font-size: 24px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-utensils me-2"></i>E-Qanpat
        </div>
        
        @if(Auth::user()->role == 'cashier')
            <a href="{{ route('cashier.dashboard') }}" class="{{ request()->routeIs('cashier.*') ? 'active' : '' }}">
                <i class="fas fa-cash-register me-2"></i> Dashboard Kasir
            </a>
            <a href="{{ route('riwayat.index') }}" class="{{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                <i class="fas fa-history me-2"></i> Riwayat Transaksi
            </a>
        @endif

        @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>

            {{-- <div class="text-uppercase text-muted px-4 mt-3 mb-1" style="font-size: 12px;">Master Data</div> --}}

            <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                <i class="fas fa-tags me-2"></i> Kategori
            </a>
            <a href="{{ route('menu.index') }}" class="{{ request()->routeIs('menu.*') ? 'active' : '' }}">
                <i class="fas fa-burger me-2"></i> Menu
            </a>
            <a href="{{ route('meja.index') }}" class="{{ request()->routeIs('meja.*') ? 'active' : '' }}">
                <i class="fas fa-chair me-2"></i> Meja
            </a>
            <a href="{{ route('riwayat.index') }}" class="{{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar me-2"></i> Riwayat Transaksi
            </a>
        @endif

        <form action="{{ route('logout') }}" method="POST" class="mt-5">
            @csrf
            <button type="submit" class="btn btn-link w-100 text-start text-danger px-4" style="text-decoration: none;">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>

    <div class="main-content">
        <nav class="navbar navbar-light bg-white shadow-sm mb-4 rounded">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 ms-2">@yield('title', 'Dashboard')</span>
                <div class="d-flex align-items-center">
                    <span class="me-3">Halo, <strong>{{ Auth::user()->name }}</strong></span>
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=0D8ABC&color=fff" class="rounded-circle" width="35" height="35">
                </div>
            </div>
        </nav>

        @yield('content')
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>