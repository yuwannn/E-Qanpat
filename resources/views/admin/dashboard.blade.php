@extends('layouts.admin')

@section('title', 'Dashboard')

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
            <h5 class="fw-bold mb-3">Statistik Penjualan (7 Hari)</h5>
            
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card p-4 h-100 text-white border-0" 
             style="background: linear-gradient(145deg, #1a1a1a, #000000);">
            <h5 class="fw-bold text-warning mb-4"><i class="fas fa-crown me-2"></i>Top Menu</h5>
            
            <div class="d-flex flex-column gap-3">
                @forelse($top_menus as $index => $top)
                    <div class="d-flex align-items-center">
                        <h1 class="fw-bold me-3 text-white-50" style="width: 30px;">{{ $index + 1 }}</h1>
                        
                        <div class="flex-grow-1">
                            <h6 class="mb-1 text-white">{{ $top->menu->nama_menu ?? 'Menu Terhapus' }}</h6>
                            <small class="text-warning">
                                <i class="fas fa-star me-1"></i> {{ $top->total_terjual }} Terjual
                            </small>
                        </div>

                        @if($top->menu && $top->menu->gambar)
                            <img src="{{ asset('storage/' . $top->menu->gambar) }}" class="rounded-circle border border-secondary" width="40" height="40" style="object-fit: cover;">
                        @endif
                    </div>
                    
                    @if(!$loop->last)
                        <hr class="border-secondary opacity-25 my-1">
                    @endif
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-ghost mb-2"></i><br>Belum ada data penjualan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // Ambil data dari Controller (Blade to JS)
        const labels = @json($chartLabels);
        const dataValues = @json($chartValues);

        // Buat Gradient Merah untuk Grafik
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(211, 47, 47, 0.5)'); // Merah Transparan atas
        gradient.addColorStop(1, 'rgba(211, 47, 47, 0.0)'); // Putih/Transparan bawah

        new Chart(ctx, {
            type: 'line', // Jenis Grafik: Garis
            data: {
                labels: labels,
                datasets: [{
                    label: 'Omzet (Rp)',
                    data: dataValues,
                    backgroundColor: gradient,
                    borderColor: '#D32F2F', // Warna Garis Merah Kanpat
                    borderWidth: 3,
                    pointBackgroundColor: '#FFC107', // Titik warna Kuning
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true, // Isi warna di bawah garis
                    tension: 0.4 // Garis melengkung (estetik)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }, // Sembunyikan legenda biar bersih
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#FFC107',
                        callbacks: {
                            label: function(context) {
                                // Format Rupiah di Tooltip
                                let value = context.raw;
                                return ' Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' }, // Grid halus
                        ticks: {
                            callback: function(value) {
                                // Singkat angka (misal 15000 jadi 15k)
                                if (value >= 1000) return 'Rp ' + (value/1000) + 'k';
                                return value;
                            }
                        }
                    },
                    x: {
                        grid: { display: false } // Hilangkan grid vertikal
                    }
                }
            }
        });
    });
</script>
@endsection