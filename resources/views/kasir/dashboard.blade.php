@extends('layouts.admin') {{-- Kita pakai layout admin saja biar sama --}}

@section('title', 'Dashboard Kasir')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Pesanan Masuk</h1>
    <a href="{{ route('cashier.dashboard') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-sync-alt me-1"></i> Refresh Data
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    @forelse($pesanans as $order)
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 border-0 {{ $order->status == 'pending' ? 'border-start border-warning border-5' : ($order->status == 'done' ? 'border-start border-success border-5' : 'border-start border-primary border-5') }}">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark">Meja {{ $order->meja->nomor_meja }}</span>
                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-bold">{{ $order->nama_pelanggan }}</span>
                    @if($order->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($order->status == 'in_progress')
                        <span class="badge bg-primary">Dimasak</span>
                    @elseif($order->status == 'done')
                        <span class="badge bg-success">Selesai</span>
                    @else
                        <span class="badge bg-secondary">Batal</span>
                    @endif
                </div>

                <ul class="list-group list-group-flush mb-3 small">
                    @foreach($order->detailPesanans as $detail)
                    <li class="list-group-item d-flex justify-content-between px-0 py-1">
                        <span>{{ $detail->jumlah }}x {{ $detail->menu->nama_menu }}</span>
                        <span>{{ number_format($detail->harga_satuan * $detail->jumlah, 0) }}</span>
                    </li>
                    @endforeach
                </ul>

                <h5 class="fw-bold text-end mb-3">Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h5>

                <hr>

                <div class="mb-3">
                    <span class="small text-muted">Pembayaran:</span>
                    @if($order->status_pembayaran == 'paid')
                        <span class="badge bg-success"><i class="fas fa-check"></i> LUNAS</span>
                    @else
                        <span class="badge bg-danger">BELUM BAYAR</span>
                        <span class="badge bg-light text-dark border">{{ strtoupper($order->metode_pembayaran) }}</span>
                    @endif
                </div>

                <div class="d-grid gap-2">
                    @if($order->status_pembayaran == 'unpaid' && $order->status != 'cancelled')
                        <form action="{{ route('cashier.update', $order->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status_pembayaran" value="paid">
                            <button class="btn btn-success btn-sm w-100 mb-1">
                                <i class="fas fa-money-bill-wave"></i> Terima Pembayaran
                            </button>
                        </form>
                    @endif

                    @if($order->status == 'pending')
                        <form action="{{ route('cashier.update', $order->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="in_progress">
                            <button class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-fire"></i> Proses Pesanan (Masak)
                            </button>
                        </form>
                    @elseif($order->status == 'in_progress')
                        <form action="{{ route('cashier.update', $order->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="done">
                            <button class="btn btn-secondary btn-sm w-100">
                                <i class="fas fa-check"></i> Pesanan Selesai
                            </button>
                        </form>
                    @endif
                    
                    @if($order->status_pembayaran == 'paid')
                        <a href="{{ route('cashier.print', $order->id) }}" target="_blank" class="btn btn-dark btn-sm w-100 mt-2">
                            <i class="fas fa-print"></i> Cetak Struk
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <h4 class="text-muted">Belum ada pesanan masuk.</h4>
    </div>
    @endforelse
</div>

{{-- Script Auto Refresh (Opsional: Reload halaman setiap 15 detik) --}}
<script>
    setTimeout(function(){
       window.location.reload(1);
    }, 15000);
</script>
@endsection