<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Qanpat - Kantin Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Hero Section dengan Background Gelap Transparan */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('storage/kanpat-2.jpeg');
            background-size: cover;
            background-position: center;
            height: 100vh; /* Full layar */
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 24px;
            color: white !important;
        }

        .btn-login {
            border: 2px solid white;
            color: white;
            border-radius: 50px;
            padding: 8px 25px;
            transition: 0.3s;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-login:hover {
            background-color: white;
            color: black;
        }

        .step-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            height: 100%;
            transition: transform 0.3s;
        }
        
        .step-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.2);
        }

        .icon-box {
            font-size: 40px;
            margin-bottom: 15px;
            color: #0dcaf0;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top p-3">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-utensils me-2"></i>E-Qanpat
            </a>
            
            <div class="ms-auto">
                @if (Route::has('login'))
                    @auth
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn-login">Dashboard Admin</a>
                        @else
                            <a href="{{ route('cashier.dashboard') }}" class="btn-login">Dashboard Kasir</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-login">
                            <i class="fas fa-user-lock me-2"></i>Login Petugas
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-3 fw-bold mb-3">Lapar? Gak Perlu Antre!</h1>
            <p class="lead mb-5">Pesan makanan dan minuman favoritmu langsung dari meja.<br>Cepat, Mudah, dan Cashless.</p>

            <div class="row justify-content-center g-4">
                <div class="col-md-3 col-8">
                    <div class="step-card">
                        <div class="icon-box"><i class="fas fa-chair"></i></div>
                        <h5>1. Cari Meja</h5>
                        <p class="small text-white-50">Silakan duduk di meja yang tersedia di area kantin.</p>
                    </div>
                </div>
                <div class="col-md-3 col-8">
                    <div class="step-card">
                        <div class="icon-box"><i class="fas fa-qrcode"></i></div>
                        <h5>2. Scan QR Code</h5>
                        <p class="small text-white-50">Scan kode QR yang tertempel di meja menggunakan HP Anda.</p>
                    </div>
                </div>
                <div class="col-md-3 col-8">
                    <div class="step-card">
                        <div class="icon-box"><i class="fas fa-bell-concierge"></i></div>
                        <h5>3. Pesanan Diantar</h5>
                        <p class="small text-white-50">Pilih menu, bayar, dan tunggu pesanan diantar ke meja Anda.</p>
                    </div>
                </div>
            </div>

            <div class="mt-5 text-white-50 small">
                &copy; {{ date('Y') }} Kanpat System. Project by Kelompok 9.
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>