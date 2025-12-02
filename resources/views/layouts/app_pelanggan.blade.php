<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>E-Qanpat Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Warna Brand */
            --primary-red: #D32F2F;
            --primary-yellow: #FFC107;
            
            /* Light Mode (Default) */
            --bg-body: #F4F6F9;
            --bg-card: #FFFFFF;
            --text-main: #212529;
            --text-muted: #8898aa;
            --border-color: #f0f0f0;
            --shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        [data-theme="dark"] {
            --bg-body: #121212;
            --bg-card: #1E1E1E;
            --text-main: #ffffff;
            --text-muted: #a0a0a0;
            --border-color: #2d2d2d;
            --shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            padding-bottom: 100px; /* Space untuk floating cart */
            transition: 0.3s;
        }

        /* Navbar Mobile */
        .mobile-header {
            background: var(--bg-card);
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-logo {
            font-weight: 800;
            font-size: 20px;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }
        .brand-logo span { color: var(--primary-red); }

        /* Theme Toggle */
        .btn-theme {
            width: 35px; height: 35px;
            border-radius: 50%;
            background: var(--bg-body);
            color: var(--text-main);
            border: none;
            display: flex; align-items: center; justify-content: center;
        }

        /* Floating Cart */
        .cart-float {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: #1e1e1e; /* Selalu hitam agar kontras dengan tombol merah */
            color: white;
            padding: 15px 20px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* Global Components */
        .card {
            background-color: var(--bg-card);
            border: none;
            border-radius: 20px;
            box-shadow: var(--shadow);
        }
        
        .btn-primary {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
            border-radius: 12px;
            font-weight: 600;
        }
        .btn-primary:hover, .btn-primary:active {
            background-color: #b71c1c !important;
            border-color: #b71c1c !important;
        }

        h1, h2, h3, h4, h5, h6 { color: var(--text-main); }
        .text-muted { color: var(--text-muted) !important; }
    </style>
</head>
<body>

    <div class="mobile-header">
        <div class="brand-logo">E-<span>QANPAT</span></div>
        <button class="btn-theme" id="themeToggle">
            <i class="fas fa-moon"></i>
        </button>
    </div>

    <div class="container mt-3">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        const toggleBtn = document.getElementById('themeToggle');
        const icon = toggleBtn.querySelector('i');
        const html = document.documentElement;

        // Cek Local Storage
        if(localStorage.getItem('theme') === 'dark') {
            html.setAttribute('data-theme', 'dark');
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        }

        toggleBtn.addEventListener('click', () => {
            let theme = html.getAttribute('data-theme');
            let newTheme = theme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            if(newTheme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        });
    </script>

    @yield('scripts')
</body>
</html>