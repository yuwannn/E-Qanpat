@extends('layouts.app_pelanggan')

@section('content')
<div class="py-3">
    <h4 class="fw-bold mb-3">Pesanan Anda</h4>
    
    <div class="card shadow-sm mb-3">
        <div class="card-body p-0">
            @if(session('cart'))
                <ul class="list-group list-group-flush">
                    @php $total = 0; @endphp
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                @if($details['image'])
                                    <img src="{{ asset('storage/'.$details['image']) }}" class="rounded me-3" width="50" height="50" style="object-fit: cover">
                                @endif
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $details['name'] }}</h6>
                                    <small class="text-muted">{{ $details['quantity'] }} x Rp {{ number_format($details['price'], 0) }}</small>
                                </div>
                            </div>
                            <span class="fw-bold">Rp {{ number_format($details['price'] * $details['quantity'], 0) }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="p-3 bg-light d-flex justify-content-between">
                    <span class="fw-bold">Total Pembayaran</span>
                    <span class="fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-basket fa-3x text-muted mb-3"></i>
                    <p>Keranjang masih kosong.</p>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm">Kembali Menu</a>
                </div>
            @endif
        </div>
    </div>

    @if(session('cart'))
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <label class="form-label fw-bold">Atas Nama</label>
                    <input type="text" name="nama_pelanggan" class="form-control" placeholder="Tulis nama anda..." required>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <label class="form-label fw-bold">Metode Pembayaran</label>
                    
                    <div class="form-check p-3 border rounded mb-2">
                        <input class="form-check-input" type="radio" name="metode_pembayaran" id="cash" value="cash" checked>
                        <label class="form-check-label w-100 stretched-link" for="cash">
                            <i class="fas fa-money-bill-wave text-success me-2"></i> Bayar Tunai (Kasir)
                        </label>
                    </div>

                    <div class="form-check p-3 border rounded">
                        <input class="form-check-input" type="radio" name="metode_pembayaran" id="qris" value="qris">
                        <label class="form-check-label w-100 stretched-link" for="qris">
                            <i class="fas fa-qrcode text-primary me-2"></i> QRIS
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow">
                    Konfirmasi Pesanan
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-light text-muted">Tambah Menu Lagi</a>
            </div>
        </form>
    @endif
</div>
@endsection