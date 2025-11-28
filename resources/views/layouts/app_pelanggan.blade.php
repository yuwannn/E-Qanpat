<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>E-Qanpat Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; padding-bottom: 80px; }
        .hero-header {
            background: linear-gradient(45deg, #0d6efd, #0dcaf0);
            color: white;
            padding: 30px 20px;
            border-bottom-left-radius: 25px;
            border-bottom-right-radius: 25px;
            margin-bottom: 20px;
        }
        .menu-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.2s;
        }
        .menu-card:active { transform: scale(0.98); }
        .menu-img {
            height: 140px;
            object-fit: cover;
            width: 100%;
        }
        .category-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            padding-left: 10px;
            border-left: 4px solid #0d6efd;
        }
        /* Sticky Footer Cart */
        .cart-float {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: white;
            padding: 15px;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>

    <div class="hero-header shadow-sm text-center">
        <h4 class="fw-bold mb-0"><i class="fas fa-utensils me-2"></i>E-Qanpat</h4>
        <p class="mb-0 small opacity-75">Pesan makan tanpa antre</p>
    </div>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html>