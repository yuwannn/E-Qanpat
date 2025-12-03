<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Qanpat - Kantin Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-red: #D32F2F;
            --primary-yellow: #FFC107;
            --text-main: #212529;
            --bg-gradient: linear-gradient(135deg, #ffffff 0%, #fff0f0 100%);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-gradient);
            color: var(--text-main);
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* --- WRAPPER --- */
        .hero-wrapper {
            position: relative;
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* --- ANIMASI BACKGROUND --- */
        .floating-icons {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            overflow: hidden; z-index: 0; pointer-events: none;
        }

        .food-icon {
            position: absolute; bottom: -100px;
            color: var(--primary-red);
            font-size: 80px; opacity: 0.05;
            animation: floatUp 20s linear infinite;
        }

        @keyframes floatUp {
            0% { transform: translateY(0) rotate(0deg); opacity: 0; }
            10% { opacity: 0.08; }
            90% { opacity: 0.08; }
            100% { transform: translateY(-120vh) rotate(360deg); opacity: 0; }
        }

        /* Posisi Acak Icon */
        .food-icon:nth-child(1) { left: 10%; animation-duration: 15s; font-size: 60px; }
        .food-icon:nth-child(2) { left: 25%; animation-duration: 25s; animation-delay: 2s; font-size: 100px; }
        .food-icon:nth-child(3) { left: 40%; animation-duration: 18s; animation-delay: 5s; }
        .food-icon:nth-child(4) { left: 55%; animation-duration: 22s; animation-delay: 0s; font-size: 120px; }
        .food-icon:nth-child(5) { left: 70%; animation-duration: 16s; animation-delay: 3s; }
        .food-icon:nth-child(6) { left: 85%; animation-duration: 20s; animation-delay: 7s; font-size: 50px; }

        /* --- NAVBAR & BUTTONS --- */
        .navbar-custom {
            position: absolute; top: 0; width: 100%; z-index: 10;
            padding: 25px 0;
            transition: 0.3s;
        }

        .brand-text {
            font-size: 1.8rem; font-weight: 800;
            color: var(--text-main); letter-spacing: -1px;
            white-space: nowrap; /* Mencegah teks turun baris */
        }
        .brand-text span { color: var(--primary-red); }

        .btn-staff {
            background-color: var(--primary-red);
            color: white;
            padding: 10px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(211, 47, 47, 0.3);
            border: 2px solid var(--primary-red);
            white-space: nowrap; /* Mencegah teks tombol turun baris */
        }
        .btn-staff:hover {
            background-color: white; color: var(--primary-red);
        }

        /* --- CONTENT STYLING --- */
        .hero-content {
            position: relative; z-index: 2; text-align: center;
            padding: 20px; padding-top: 100px;
        }

        .brand-pill {
            display: inline-block;
            background: rgba(211, 47, 47, 0.1); color: var(--primary-red);
            padding: 8px 20px; border-radius: 50px;
            font-weight: 600; font-size: 14px; margin-bottom: 20px;
            border: 1px solid rgba(211, 47, 47, 0.2);
        }

        .headline {
            font-size: 4rem; font-weight: 800; line-height: 1.1;
            color: var(--text-main); margin-bottom: 20px;
        }
        .headline span { color: var(--primary-red); position: relative; display: inline-block; }
        .headline span::after {
            content: ''; position: absolute; bottom: 5px; left: 0;
            width: 100%; height: 15px; background-color: var(--primary-yellow);
            z-index: -1; opacity: 0.4; transform: skewX(-20deg);
        }

        .sub-headline {
            font-size: 1.2rem; color: #6c757d; margin-bottom: 50px;
            font-weight: 400; max-width: 700px; margin-left: auto; margin-right: auto;
        }

        /* --- CARDS --- */
        .step-card {
            background: white; border-radius: 20px; padding: 40px 30px;
            transition: transform 0.3s, box-shadow 0.3s; height: 100%;
            border: 1px solid #f0f0f0; box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            position: relative; overflow: hidden;
        }
        .step-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(211, 47, 47, 0.15); border-color: rgba(211, 47, 47, 0.3);
        }
        .step-number {
            font-size: 4rem; font-weight: 900; color: #f8f9fa;
            position: absolute; top: -10px; right: 10px; line-height: 1; z-index: 0;
        }
        .icon-circle {
            width: 70px; height: 70px; background: rgba(255, 193, 7, 0.15);
            color: var(--primary-yellow); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 30px; margin-bottom: 25px; position: relative; z-index: 1;
        }
        .step-title { font-weight: 700; margin-bottom: 10px; position: relative; z-index: 1; font-size: 1.25rem; }
        .step-desc { color: #888; font-size: 0.9rem; position: relative; z-index: 1; }

        /* --- RESPONSIVE CSS (MOBILE) --- */
        @media (max-width: 768px) {
            /* 1. Navbar Lebih Ringkas */
            .navbar-custom { padding: 15px 0; }
            
            /* 2. Logo Mengecil */
            .brand-text { font-size: 1.4rem; }
            
            /* 3. Tombol Lebih Kecil & Padding Berkurang */
            .btn-staff {
                padding: 8px 15px; 
                font-size: 0.85rem; 
            }
            
            /* 4. Headline Menyesuaikan Layar */
            .headline { font-size: 2.5rem; }
            .sub-headline { font-size: 1rem; padding: 0 15px; }

            /* 5. Icon Background dikurangi biar ringan */
            .food-icon { display: none; }
            .food-icon:nth-child(1), .food-icon:nth-child(4) { display: block; opacity: 0.05; }
        }
        
        @media (max-width: 400px) {
            /* Khusus HP Layar Sangat Kecil (iPhone SE / Galaxy Mini) */
            .brand-text { font-size: 1.2rem; }
            .btn-staff { padding: 6px 12px; font-size: 0.75rem; }
        }
    </style>
</head>
<body>

    <div class="hero-wrapper">
        
        <nav class="navbar-custom">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="brand-text">E-<span>QANPAT</span></div>
                
                <div>
                    @if (Route::has('login'))
                        @auth
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="btn-staff">Dashboard</a>
                            @else
                                <a href="{{ route('cashier.dashboard') }}" class="btn-staff">Dashboard</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-staff">
                                <i class="fas fa-user-lock me-2"></i>Login
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <div class="floating-icons">
            <i class="fas fa-hamburger food-icon"></i>
            <i class="fas fa-pizza-slice food-icon"></i>
            <i class="fas fa-coffee food-icon"></i>
            <i class="fas fa-utensils food-icon"></i>
            <i class="fas fa-drumstick-bite food-icon"></i>
            <i class="fas fa-carrot food-icon"></i>
        </div>

        <div class="container hero-content">
            
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <div class="brand-pill">
                        <i class="fas fa-star me-2"></i>Kantin Masa Depan
                    </div>
                    <h1 class="headline">Lapar? Tinggal <span>Scan.</span></h1>
                    <p class="sub-headline">
                        Sistem pemesanan makanan digital yang Cepat, Praktis, dan Cashless. 
                        Duduk santai, scan QR di meja, dan pesananmu segera tiba.
                    </p>
                </div>
            </div>

            <div class="row justify-content-center g-4">
                <div class="col-md-4 col-10">
                    <div class="step-card text-start">
                        <div class="step-number">01</div>
                        <div class="icon-circle">
                            <i class="fas fa-chair"></i>
                        </div>
                        <h4 class="step-title">Cari Meja</h4>
                        <p class="step-desc">Silakan pilih meja yang kosong dan nyaman untuk Anda tempati di area kantin.</p>
                    </div>
                </div>

                <div class="col-md-4 col-10">
                    <div class="step-card text-start" style="border-bottom: 4px solid var(--primary-red);">
                        <div class="step-number" style="color: rgba(211, 47, 47, 0.05);">02</div>
                        <div class="icon-circle" style="background: rgba(211, 47, 47, 0.1); color: var(--primary-red);">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <h4 class="step-title text-danger">Scan QR Code</h4>
                        <p class="step-desc">Gunakan kamera HP untuk memindai kode QR yang tertempel di meja. Menu digital akan terbuka.</p>
                    </div>
                </div>

                <div class="col-md-4 col-10">
                    <div class="step-card text-start">
                        <div class="step-number">03</div>
                        <div class="icon-circle">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h4 class="step-title">Nikmati Makanan</h4>
                        <p class="step-desc">Pilih menu favorit, lakukan pembayaran, dan tunggu pesanan diantar oleh pelayan.</p>
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-4 text-muted" style="font-size: 0.8rem;">
                <p>&copy; {{ date('Y') }} Kanpat System. Project by Mahasiswa Semester 3.</p>
            </div>

        </div>
    </div>

</body>
</html>