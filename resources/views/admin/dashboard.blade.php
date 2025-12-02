@extends('layouts.admin')

@section('title', 'Overview Dashboard')

@section('content')
<style>
    /* Card Khusus Dashboard */
    .stat-card {
        background-color: var(--bg-card); /* Ikuti tema */
        border-radius: 15px;
        padding: 25px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: transform 0.3s;
        border: 1px solid var(--border-color);
        height: 100%;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary-red);
    }
    .stat-card h2 { 
        font-weight: 800; 
        margin-bottom: 5px; 
        font-size: 2.5rem; 
        color: var(--text-main); /* Warna teks dinamis */
    }
    .stat-card p { 
        color: var(--text-muted); 
        font-weight: 600; 
        margin: 0; 
        text-transform: uppercase; 
        font-size: 0.8rem; 
        letter-spacing: 1px; 
    }
    .icon-bg {
        position: absolute;
        right: -15px;
        bottom: -20px;
        font-size: 110px;
        opacity: 0.05; /* Transparan halus */
        transform: rotate(-15deg);
        color: var(--text-main);
        transition: 0.3s;
    }
    
    /* Aksen Warna */
    .accent-red { border-left: 5px solid var(--primary-red); }
    .accent-yellow { border-left: 5px solid var(--primary-yellow); }
    .accent-dark { border-left: 5px solid var(--text-main); }
</style>

<div class="row g-4">
    <div class="col-md-4">
        <div class="stat-card accent-red">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p>Total Menu</p>
                    <h2>{{ $total_menu ?? 0 }}</h2>
                </div>
                <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" 
                     style="width: 50px; height: 50px; background: rgba(211, 47, 47, 0.1); color: var(--primary-red);">
                    <i class="fas fa-hamburger fa-lg"></i>
                </div>
            </div>
            <i class="fas fa-hamburger icon-bg"></i>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card accent-yellow">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p>Kategori</p>
                    <h2>{{ $total_kategori ?? 0 }}</h2>
                </div>
                <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" 
                     style="width: 50px; height: 50px; background: rgba(255, 193, 7, 0.1); color: var(--primary-yellow);">
                    <i class="fas fa-tags fa-lg"></i>
                </div>
            </div>
            <i class="fas fa-tags icon-bg"></i>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card accent-dark">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p>Total Meja</p>
                    <h2>{{ $total_meja ?? 0 }}</h2>
                </div>
                <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" 
                     style="width: 50px; height: 50px; background: var(--bg-body); color: var(--text-main);">
                    <i class="fas fa-chair fa-lg"></i>
                </div>
            </div>
            <i class="fas fa-chair icon-bg"></i>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8 mb-4">
        <div class="card p-4 h-100 shadow-sm border-0">
            <h5 class="fw-bold mb-3">Statistik Penjualan</h5>
            <div class="d-flex align-items-center justify-content-center rounded" 
                 style="height: 300px; background-color: var(--bg-body); border: 2px dashed var(--border-color);">
                <p class="text-muted"><i class="fas fa-chart-line me-2"></i>Area Grafik Penjualan</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card p-4 h-100 text-white border-0" 
             style="background: linear-gradient(145deg, #1a1a1a, #000000);">
            <h5 class="fw-bold text-warning mb-4"><i class="fas fa-crown me-2"></i>Top Menu</h5>
            
            <div class="d-flex align-items-center mb-4">
                <h1 class="fw-bold me-3 text-white-50">1</h1>
                <div>
                    <h6 class="mb-1 text-white">Nasi Goreng Spesial</h6>
                    <small class="text-warning"><i class="fas fa-star"></i> 50 Terjual</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center mb-4">
                <h1 class="fw-bold me-3 text-white-50">2</h1>
                <div>
                    <h6 class="mb-1 text-white">Es Teh Manis</h6>
                    <small class="text-warning"><i class="fas fa-star"></i> 42 Terjual</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection