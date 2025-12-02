<!DOCTYPE html>
<html lang="id" data-theme="light"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Qanpat')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- DEFINISI WARNA (THEMING) --- */
        :root {
            /* Palette Utama Kanpat */
            --primary-red: #D32F2F;      /* Merah Utama */
            --primary-dark-red: #B71C1C; /* Merah Gelap (Hover) */
            --primary-yellow: #FFC107;   /* Kuning Standar */
            --elegant-gold: #D4AF37;     /* Kuning Emas Elegan (Untuk Title/Icon) */
            
            /* --- LIGHT MODE (DEFAULT) --- */
            --bg-body: #F4F6F9;       
            --bg-card: #FFFFFF;       
            --bg-sidebar: #FFFFFF;    
            --text-main: #212529;     
            --text-muted: #6c757d;    
            --border-color: #e3e6f0;  
            --shadow: 0 5px 20px rgba(0,0,0,0.05);
            --sidebar-active-bg: rgba(211, 47, 47, 0.08); /* Merah sangat muda */
            --table-head-bg: #f8f9fa;
            --table-striped-bg: rgba(0, 0, 0, 0.05);
        }

        /* --- DARK MODE CONFIG --- */
        [data-theme="dark"] {
            --bg-body: #121212;       
            --bg-card: #1E1E1E;       
            --bg-sidebar: #000000;    
            --text-main: #E0E0E0;     
            --text-muted: #A0A0A0;    
            --border-color: #333333;  
            --shadow: 0 5px 20px rgba(0,0,0,0.5);
            --sidebar-active-bg: rgba(211, 47, 47, 0.2);
            --table-head-bg: #121212; 
            --table-striped-bg: rgba(255, 255, 255, 0.05);
        }

        /* --- GLOBAL STYLES --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            transition: background-color 0.3s, color 0.3s;
            overflow-x: hidden;
        }

        /* Card & Components */
        .card, .top-navbar, .sidebar, .modal-content {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            transition: background-color 0.3s, border-color 0.3s;
        }

        /* --- OVERRIDE BOOTSTRAP DEFAULT (HILANGKAN BIRU) --- */
        
        /* 1. Tombol Primary (Biru -> Merah) */
        .btn-primary {
            background-color: var(--primary-red) !important;
            border-color: var(--primary-red) !important;
            color: white !important;
        }
        .btn-primary:hover, .btn-primary:active, .btn-primary:focus {
            background-color: var(--primary-dark-red) !important;
            border-color: var(--primary-dark-red) !important;
        }

        /* 2. Teks Primary (Biru -> Merah) */
        .text-primary {
            color: var(--primary-red) !important;
        }

        /* 3. Title Halaman (Kuning Elegan di Dark, Merah di Light) */
        h4.fw-bold, h6.m-0.font-weight-bold {
            color: var(--primary-red) !important; 
        }
        /* Khusus Dark Mode, judul bisa jadi Emas biar mewah */
        [data-theme="dark"] h4.fw-bold, 
        [data-theme="dark"] h6.m-0.font-weight-bold {
            color: var(--primary-yellow) !important;
        }

        /* 4. Link & Pagination */
        a { text-decoration: none; color: var(--primary-red); }
        a:hover { color: var(--primary-dark-red); }
        .page-item.active .page-link {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
        }
        .page-link { color: var(--primary-red); }

        /* --- TEXT & TABLE FIXES --- */
        h1, h2, h3, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            color: var(--text-main);
        }
        .text-muted { color: var(--text-muted) !important; }
        
        /* Tabel */
        .table { color: var(--text-main); border-color: var(--border-color); }
        .table thead th {
            background-color: var(--table-head-bg);
            color: var(--text-main);
            border-bottom: 2px solid var(--border-color);
        }
        .table td, .table th {
            border-color: var(--border-color);
            background-color: transparent;
            color: var(--text-main);
        }

        /* --- SIDEBAR --- */
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            top: 0; left: 0; z-index: 1000;
            border-right: 1px solid var(--border-color);
        }

        .sidebar-brand {
            padding: 25px 20px;
            display: flex; align-items: center;
            font-weight: 800; font-size: 24px;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
        }
        .sidebar-brand span { color: var(--primary-red); }

        .sidebar-label {
            color: var(--text-muted);
            font-size: 11px; text-transform: uppercase;
            letter-spacing: 1.5px; padding: 20px 25px 5px;
            font-weight: 700;
        }

        .nav-link {
            display: flex; align-items: center;
            padding: 12px 25px; color: var(--text-muted);
            text-decoration: none; transition: 0.3s;
            font-size: 14px; font-weight: 500;
            border-left: 4px solid transparent;
        }
        .nav-link:hover {
            color: var(--primary-red);
            background-color: var(--bg-body);
        }
        .nav-link.active {
            background-color: var(--sidebar-active-bg);
            color: var(--primary-red);
            border-left: 4px solid var(--primary-red);
            font-weight: 700;
        }
        .nav-link i { width: 25px; font-size: 18px; margin-right: 10px; }

        /* --- LAYOUT UTILS --- */
        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
        .top-navbar {
            padding: 15px 30px; border-radius: 15px;
            box-shadow: var(--shadow);
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 30px;
        }
        
        /* Toggle & Form */
        .theme-toggle {
            cursor: pointer; width: 40px; height: 40px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            background-color: var(--bg-body); color: var(--text-main);
            border: 1px solid var(--border-color); transition: 0.3s;
        }
        .theme-toggle:hover {
            background-color: var(--primary-red); color: white; border-color: var(--primary-red);
        }
        .form-control, .form-select {
            background-color: var(--bg-body); border-color: var(--border-color); color: var(--text-main);
        }
        .form-control:focus {
            background-color: var(--bg-body); color: var(--text-main);
            border-color: var(--primary-red);
            box-shadow: 0 0 0 0.25rem rgba(211, 47, 47, 0.25);
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-utensils me-3 text-yellow"></i>
            E-<span>QANPAT</span>
        </div>
        
        <div class="sidebar-menu">
            {{-- MENU KASIR --}}
            @if(Auth::user()->role == 'cashier')
                <div class="sidebar-label">KASIR AREA</div>
                <a href="{{ route('cashier.dashboard') }}" class="nav-link {{ request()->routeIs('cashier.*') ? 'active' : '' }}">
                    <i class="fas fa-cash-register"></i> Dashboard
                </a>
                <a href="{{ route('riwayat.index') }}" class="nav-link {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> Riwayat
                </a>
            @endif

            {{-- MENU ADMIN --}}
            @if(Auth::user()->role == 'admin')
                <div class="sidebar-label">UTAMA</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>

                <div class="sidebar-label">MASTER DATA</div>
                <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Kategori
                </a>
                <a href="{{ route('menu.index') }}" class="nav-link {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                    <i class="fas fa-hamburger"></i> Menu
                </a>
                <a href="{{ route('meja.index') }}" class="nav-link {{ request()->routeIs('meja.*') ? 'active' : '' }}">
                    <i class="fas fa-chair"></i> Meja
                </a>

                <div class="sidebar-label">LAPORAN</div>
                <a href="{{ route('riwayat.index') }}" class="nav-link {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar"></i> Riwayat
                </a>
            @endif
        </div>
    </nav>

    <div class="main-content">
        <div class="top-navbar">
            <div>
                <h4 class="mb-0 fw-bold">@yield('title')</h4>
                <p class="text-muted mb-0 small">{{ date('l, d F Y') }}</p>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                
                <div class="theme-toggle" id="themeToggle" title="Ganti Mode">
                    <i class="fas fa-moon"></i>
                </div>

                <div style="width: 1px; height: 30px; background: var(--border-color);"></div>

                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-md-block">
                        <span class="d-block fw-bold small">{{ Auth::user()->name }}</span>
                        <small class="text-muted" style="font-size: 10px;">{{ ucfirst(Auth::user()->role) }}</small>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=D32F2F&color=fff&bold=true" class="rounded-circle" width="40">
                </div>

                <button type="button" class="btn btn-logout p-0" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const toggleButton = document.getElementById('themeToggle');
        const icon = toggleButton.querySelector('i');
        const html = document.documentElement;

        // Cek LocalStorage saat load
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme) {
            html.setAttribute('data-theme', currentTheme);
            updateIcon(currentTheme);
        }

        // Fungsi Ganti Icon
        function updateIcon(theme) {
            if(theme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }

        // Event Klik
        toggleButton.addEventListener('click', () => {
            let theme = html.getAttribute('data-theme');
            let newTheme = theme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });
    </script>
</body>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background-color: var(--bg-card); color: var(--text-main);">
            <div class="modal-body text-center p-5">
                <div class="mb-4">
                    <i class="fas fa-sign-out-alt fa-3x text-danger opacity-50"></i>
                </div>
                <h4 class="fw-bold mb-2">Ingin Keluar?</h4>
                <p class="text-muted">Apakah Anda yakin ingin mengakhiri sesi ini?</p>
                
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4">Ya, Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background-color: var(--bg-card); color: var(--text-main);">
            <div class="modal-body text-center p-5">
                <div class="mb-4">
                    <i class="fas fa-trash-alt fa-3x text-warning opacity-50"></i>
                </div>
                <h4 class="fw-bold mb-2">Hapus Data?</h4>
                <p class="text-muted">Data yang dihapus tidak dapat dikembalikan. Lanjutkan?</p>
                
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">Hapus Permanen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', event => {
            // Tombol yang diklik
            const button = event.relatedTarget;
            // Ambil data-action dari tombol tersebut
            const actionUrl = button.getAttribute('data-action');
            
            // Isi action form di dalam modal dengan URL tersebut
            const modalForm = deleteModal.querySelector('#deleteForm');
            modalForm.action = actionUrl;
        });
    }
</script>

</html>