@extends('layouts.app_pelanggan')

@section('content')
<style>
    .success-icon-box {
        width: 80px; height: 80px;
        background: #e8f5e9; color: #198754;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 10px 20px rgba(25, 135, 84, 0.2);
    }
    
    .qris-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        position: relative;
        overflow: hidden;
    }
    
    /* Hiasan gerigi di bawah struk */
    .receipt-edge {
        position: absolute; bottom: 0; left: 0; width: 100%; height: 10px;
        background: radial-gradient(circle, transparent 50%, white 50%), radial-gradient(circle, transparent 50%, white 50%);
        background-position: 0 10px; background-size: 20px 20px;
    }

    .amount-display {
        font-size: 2rem; font-weight: 800; color: var(--primary-red);
        margin: 10px 0; letter-spacing: -1px;
    }
    
    .qris-box {
        background: white;
        padding: 15px;
        display: inline-block;
        border-radius: 10px;
        border: 2px solid #eee;
        margin: 20px 0;
    }

    .order-details-mini {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        text-align: left;
        margin-top: 20px;
    }
</style>

<div class="py-4">
    
    <div class="text-center mb-4">
        <div class="success-icon-box">
            <i class="fas fa-check fa-3x"></i>
        </div>
        <h4 class="fw-bold mb-1">Pesanan Diterima!</h4>
        <p class="text-muted small">Mohon selesaikan pembayaran Anda.</p>
    </div>

    <div class="qris-card">
        
        @if($pesanan->metode_pembayaran == 'qris' && $pesanan->status_pembayaran == 'unpaid')
            
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/1200px-Logo_QRIS.svg.png" width="80" class="mb-3">
            
            <p class="text-muted small mb-0 text-uppercase fw-bold">Total Pembayaran</p>
            <div class="amount-display">
                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                <button class="btn btn-sm btn-light rounded-circle text-muted" onclick="copyTotal({{ $pesanan->total_harga }})">
                    <i class="fas fa-copy"></i>
                </button>
            </div>

            <div class="alert alert-warning py-2 small rounded-pill d-inline-block">
                <i class="fas fa-clock me-1"></i> Menunggu Pembayaran
            </div>

            <div class="qris-box shadow-sm">
                {!! QrCode::size(200)->generate("EQANPAT-ORDER-" . $pesanan->id . "-RP-" . $pesanan->total_harga) !!}
            </div>

            <p class="small text-muted mb-0">
                Scan QRIS di atas menggunakan<br>GoPay, OVO, Dana, atau Mobile Banking.
            </p>

        @else
            <div class="mb-3">
                <i class="fas fa-cash-register fa-3x text-warning mb-3"></i>
                <h2 class="fw-bold">Bayar di Kasir</h2>
            </div>
            
            <div class="amount-display text-dark">
                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
            </div>

            <p class="text-muted">
                Silakan menuju kasir dan sebutkan nomor meja <b>{{ $pesanan->meja->nomor_meja }}</b> atau tunjukkan halaman ini.
            </p>
        @endif
        
        <div class="order-details-mini">
            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                <span class="text-muted small">ID Pesanan</span>
                <span class="fw-bold small">#{{ $pesanan->id }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                <span class="text-muted small">Meja</span>
                <span class="fw-bold small">Nomor {{ $pesanan->meja->nomor_meja }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted small">Item</span>
                <span class="fw-bold small">{{ $pesanan->detailPesanans->sum('jumlah') }} Menu</span>
            </div>
        </div>

        <div class="receipt-edge"></div>
    </div>

    <div class="mt-4 text-center px-3">
        <a href="{{ route('order.index', $pesanan->meja->nomor_meja) }}?token={{ $pesanan->meja->token }}" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">
            <i class="fas fa-plus me-2"></i> Pesan Lagi
        </a>
        <a href="#" class="btn btn-link text-muted mt-2 small text-decoration-none">
            <i class="fas fa-download me-1"></i> Simpan Bukti Pesanan
        </a>
    </div>

</div>

<script>
    function copyTotal(amount) {
        navigator.clipboard.writeText(amount);
        alert('Nominal Rp ' + amount + ' disalin!');
    }
</script>
@endsection