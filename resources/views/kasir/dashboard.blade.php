@extends('layouts.admin')

@section('title', 'Dashboard Kasir')

@section('content')
<style>
    /* --- CSS KHUSUS KARTU ORDER (Theme Aware) --- */
    .order-card {
        background-color: var(--bg-card); /* Putih di Light, Hitam Abu di Dark */
        color: var(--text-main);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
        overflow: hidden;
    }
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
    }

    /* Header Kartu */
    .order-header {
        background-color: var(--table-head-bg); /* Sedikit lebih gelap dari card */
        border-bottom: 1px solid var(--border-color);
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* List Item (Menu) agar transparan mengikuti tema */
    .list-group-item {
        background-color: transparent !important;
        color: var(--text-main);
        border-bottom: 1px dashed var(--border-color);
        padding-left: 0;
        padding-right: 0;
    }
    .list-group-item:last-child { border-bottom: none; }

    /* Indikator Warna Status (Border Kiri Tebal) */
    .status-pending { border-left: 6px solid #FFC107; }      /* Kuning */
    .status-cooking { border-left: 6px solid #D32F2F; }      /* Merah */
    .status-done    { border-left: 6px solid #198754; }      /* Hijau */
    .status-cancel  { border-left: 6px solid #6c757d; }      /* Abu */
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Daftar Pesanan Masuk</h4>
        <p class="text-muted small mb-0">Pantau pesanan secara real-time di sini.</p>
    </div>
    <a href="{{ route('cashier.dashboard') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
        <i class="fas fa-sync-alt me-2"></i> Refresh Data
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    @forelse($pesanans as $order)
    <div class="col-md-4 col-lg-4">
        
        @php
            $statusClass = 'status-pending';
            if($order->status == 'in_progress') $statusClass = 'status-cooking';
            if($order->status == 'done') $statusClass = 'status-done';
            if($order->status == 'cancelled') $statusClass = 'status-cancel';
        @endphp

        <div class="card order-card h-100 shadow-sm {{ $statusClass }}">
            
            <div class="order-header">
                <span class="fw-bold fs-5">Meja {{ $order->meja->nomor_meja }}</span>
                <span class="badge bg-light text-dark border">{{ $order->created_at->format('H:i') }}</span>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0 text-truncate" style="max-width: 60%;">
                        <i class="fas fa-user-circle me-1 text-muted"></i> {{ $order->nama_pelanggan }}
                    </h6>
                    
                    @if($order->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($order->status == 'in_progress')
                        <span class="badge bg-danger">Dimasak</span>
                    @elseif($order->status == 'done')
                        <span class="badge bg-success">Selesai</span>
                    @else
                        <span class="badge bg-secondary">Batal</span>
                    @endif
                </div>

                <ul class="list-group list-group-flush mb-3">
                    @foreach($order->detailPesanans as $detail)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold me-2">{{ $detail->jumlah }}x</span>
                            <span>{{ $detail->menu->nama_menu }}</span>
                        </div>
                        <span class="small opacity-75">{{ number_format($detail->harga_satuan * $detail->jumlah, 0) }}</span>
                    </li>
                    @endforeach
                </ul>

                <div class="d-flex justify-content-between align-items-center pt-2 border-top border-secondary border-opacity-25 mb-3">
                    <span class="text-muted small text-uppercase fw-bold">Total Tagihan</span>
                    <h4 class="fw-bold text-danger mb-0">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h4>
                </div>

                <div class="mb-3 d-flex justify-content-between align-items-center bg-opacity-10 rounded p-2" 
                     style="background-color: var(--sidebar-active-bg);">
                    <span class="small fw-bold">Status Bayar:</span>
                    @if($order->status_pembayaran == 'paid')
                        <span class="badge bg-success"><i class="fas fa-check-double me-1"></i> LUNAS</span>
                    @else
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger">BELUM</span>
                            <span class="badge bg-dark">{{ strtoupper($order->metode_pembayaran) }}</span>
                        </div>
                    @endif
                </div>

                <div class="d-grid gap-2">
                    
                    @if($order->status_pembayaran == 'unpaid' && $order->status != 'cancelled')
                        <form action="{{ route('cashier.update', $order->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status_pembayaran" value="paid">
                            <button class="btn btn-success btn-sm w-100 fw-bold py-2">
                                <i class="fas fa-money-bill-wave me-2"></i> Terima Pembayaran
                            </button>
                        </form>
                    @endif

                    @if($order->status == 'pending')
                        <form action="{{ route('cashier.update', $order->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="in_progress">
                            <button class="btn btn-primary btn-sm w-100 fw-bold py-2">
                                <i class="fas fa-fire me-2"></i> Proses (Masak)
                            </button>
                        </form>
                    
                    @elseif($order->status == 'in_progress')
                        <form action="{{ route('cashier.update', $order->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="done">
                            <button class="btn btn-dark btn-sm w-100 fw-bold py-2">
                                <i class="fas fa-check me-2"></i> Pesanan Selesai
                            </button>
                        </form>
                    @endif

                    @if($order->status_pembayaran == 'paid')
                        <a href="{{ route('cashier.print', $order->id) }}" target="_blank" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="fas fa-print me-2"></i> Cetak Struk
                        </a>
                    @endif

                </div>

            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="d-inline-block p-4 rounded-circle mb-3" style="background-color: var(--sidebar-active-bg);">
            <i class="fas fa-mug-hot fa-3x text-danger opacity-50"></i>
        </div>
        <h4 class="text-muted">Belum ada pesanan masuk.</h4>
        <p class="text-muted small">Pesanan baru akan muncul di sini secara otomatis.</p>
    </div>
    @endforelse
</div>

{{-- Script Auto Refresh (15 Detik) --}}
<script>
    setTimeout(function(){
       window.location.reload(1);
    }, 15000);
</script>
@endsection