<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staff - E-Qanpat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fff; }
        .login-container { min-height: 100vh; display: flex; }
        .login-image {
            background: url('storage/kanpat.jpeg') no-repeat center center;
            background-size: cover;
            flex: 1;
            position: relative;
        }
        .login-image::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.3));
        }
        .login-image .caption {
            position: absolute; bottom: 50px; left: 50px; color: white; z-index: 2;
        }
        .login-form-wrap {
            flex: 1; display: flex; justify-content: center; align-items: center; padding: 50px;
            max-width: 600px;
        }
        .login-card { width: 100%; max-width: 400px; }
        .btn-red {
            background-color: #D32F2F; color: white; border: none; padding: 12px;
            border-radius: 8px; font-weight: 600; width: 100%; transition: 0.3s;
        }
        .btn-red:hover { background-color: #b71c1c; }
        .form-control {
            padding: 12px; border-radius: 8px; background-color: #f8f9fa; border: 1px solid #eee;
        }
        .form-control:focus { border-color: #D32F2F; box-shadow: none; background-color: #fff; }
        .logo-text { font-weight: 800; color: #D32F2F; font-size: 28px; letter-spacing: -1px; }
        .logo-text span { color: #121212; }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-image d-none d-md-block">
        <div class="caption">
            <h2 class="fw-bold">Welcome Back!</h2>
            <p class="mb-0">Kelola pesanan pelanggan dengan lebih cepat dan efisien.</p>
        </div>
    </div>

    <div class="login-form-wrap">
        <div class="login-card">
            <div class="mb-5">
                <a href="{{route('home')}}" style="text-decoration: none;">
                    <div class="logo-text">E-<span>QANPAT</span></div>
                </a>
                <p class="text-muted mt-2">Masuk ke panel Admin & Kasir</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger py-2 small rounded-3 border-0 bg-danger bg-opacity-10 text-danger mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.action') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase text-muted">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@kanpat.com" required value="{{ old('email') }}">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase text-muted">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-red shadow-sm">
                    Masuk Sekarang <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </form>

            <div class="mt-5 text-center text-muted small">
                &copy; {{ date('Y') }} Kanpat System
            </div>
        </div>
    </div>
</div>

</body>
</html>