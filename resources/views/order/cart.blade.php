@extends('layouts.app_pelanggan')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ url()->previous() }}" class="btn btn-light rounded-circle me-3 shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Keranjang Saya</h4>
</div>

@if(session('cart'))
    <div class="card mb-4 overflow-hidden">
        <ul class="list-group list-group-flush">
            @php $total = 0; @endphp
            @foreach(session('cart') as $id => $details)
                @php $total += $details['price'] * $details['quantity'] @endphp
                <li class="list-group-item p-3 border-bottom border-light" style="background: var(--bg-card); color: var(--text-main);">
                    <div class="d-flex align-items-center">
                        @if($details['image'])
                            <img src="{{ asset('storage/'.$details['image']) }}" class="rounded-3 me-3" width="60" height="60" style="object-fit: cover;">
                        @else
                             <div class="rounded-3 me-3 bg-secondary d-flex align-items-center justify-content-center text-white" style="width:60px; height:60px;">
                                <i class="fas fa-utensils"></i>
                             </div>
                        @endif
                        
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">{{ $details['name'] }}</h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Rp {{ number_format($details['price'], 0) }}</small>
                                <span class="badge bg-danger rounded-pill">{{ $details['quantity'] }}x</span>
                            </div>
                        </div>
                        <div class="fw-bold ms-3">
                            Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="p-3" style="background: rgba(211, 47, 47, 0.05);">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small fw-bold text-uppercase">Total Pembayaran</span>
                <h5 class="fw-bold text-danger mb-0">Rp {{ number_format($total, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>

    <form action="{{ route('cart.checkout') }}" method="POST">
        @csrf
        <h6 class="fw-bold mb-3 ps-1">Info Pemesan</h6>
        
        <div class="card p-3 mb-4">
            <div class="mb-3">
                <label class="form-label small text-muted text-uppercase fw-bold">Atas Nama</label>
                <input type="text" name="nama_pelanggan" class="form-control form-control-lg bg-light border-0" placeholder="Contoh: Budi (Mhs)" required>
            </div>
            
            <label class="form-label small text-muted text-uppercase fw-bold">Metode Pembayaran</label>
            <div class="row g-2">
                <div class="col-6">
                    <input type="radio" class="btn-check" name="metode_pembayaran" id="cash" value="cash" checked>
                    <label class="btn btn-outline-secondary w-100 py-3 rounded-3 d-flex flex-column align-items-center justify-content-center h-100" for="cash">
                        <i class="fas fa-money-bill-wave fa-lg mb-2 text-success"></i>
                        <span class="small fw-bold">Tunai</span>
                    </label>
                </div>
                <div class="col-6">
                    <input type="radio" class="btn-check" name="metode_pembayaran" id="qris" value="qris">
                    <label class="btn btn-outline-secondary w-100 py-3 rounded-3 d-flex flex-column align-items-center justify-content-center h-100" for="qris">
                        <i class="fas fa-qrcode fa-lg mb-2 text-primary"></i>
                        <span class="small fw-bold">QRIS</span>
                    </label>
                </div>
            </div>
        </div>

        <div style="position: fixed; bottom: 0; left: 0; width: 100%; background: var(--bg-card); padding: 15px; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); z-index: 999;">
            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill shadow fw-bold text-uppercase" style="letter-spacing: 1px;">
                Konfirmasi Pesanan
            </button>
        </div>
    </form>
    
    <div style="height: 80px;"></div>

@else
    <div class="text-center py-5">
        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3 text-muted">
            <i class="fas fa-shopping-basket fa-3x"></i>
        </div>
        <h5 class="fw-bold">Keranjang Kosong</h5>
        <p class="text-muted">Kamu belum memilih menu apapun.</p>
        <a href="{{ url()->previous() }}" class="btn btn-danger rounded-pill px-4 mt-2">Pilih Menu Dulu</a>
    </div>
@endif

@endsection