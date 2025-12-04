@extends('layouts.app_pelanggan')

@section('content')
<div class="text-center py-5">
    <div class="mb-4">
        <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
    </div>
    <h3 class="fw-bold mb-2">Pesanan Diterima!</h3>
    <p class="text-muted">Terima kasih, pesanan Anda sedang diproses oleh dapur.</p>
    
    <div class="card shadow-sm mx-auto mt-4" style="max-width: 400px;">
        <div class="card-body text-start">
            <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                <span>Nomor Order</span>
                <span class="fw-bold">#{{ $pesanan->id }}</span>
            </div>
            <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                <span>Meja</span>
                <span class="fw-bold">{{ $pesanan->meja->nomor_meja }}</span>
            </div>
            <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                <span>Status</span>
                <span class="badge bg-warning text-dark">{{ strtoupper($pesanan->status) }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Total</span>
                <span class="fw-bold text-primary">Rp {{ number_format($pesanan->total_harga, 0) }}</span>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <p class="small text-muted">Silakan lakukan pembayaran di kasir jika memilih Tunai.</p>
        <a href="{{ route('order.index', $pesanan->meja->nomor_meja) }}" class="btn btn-outline-primary rounded-pill px-4">
            Pesan Lagi
        </a>
    </div>
</div>
@endsection