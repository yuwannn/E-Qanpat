@extends('layouts.app_pelanggan')

@section('content')

<style>
    /* Info Meja Banner */
    .table-info-card {
        background: linear-gradient(135deg, var(--primary-red), #b71c1c);
        color: white; padding: 20px; border-radius: 20px;
        margin-bottom: 25px; position: relative; overflow: hidden;
    }
    .table-info-card::after {
        content: ''; position: absolute; top: -20px; right: -20px;
        width: 100px; height: 100px; background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    /* Kategori Scroll */
    .category-scroll {
        display: flex; overflow-x: auto; gap: 10px; padding-bottom: 10px;
        scrollbar-width: none;
    }
    .category-scroll::-webkit-scrollbar { display: none; }
    
    .cat-pill {
        background: var(--bg-card); color: var(--text-muted);
        padding: 8px 20px; border-radius: 50px; white-space: nowrap;
        font-size: 13px; font-weight: 500; border: 1px solid var(--border-color);
        text-decoration: none; transition: 0.3s;
    }
    .cat-pill.active {
        background: var(--primary-red); color: white; border-color: var(--primary-red);
    }

    /* MENU CARD FIXED */
    .menu-card {
        overflow: hidden; height: 100%; position: relative;
        background: var(--bg-card); border-radius: 15px;
        box-shadow: var(--shadow); border: 1px solid var(--border-color);
    }
    .menu-img-wrap {
        position: relative; width: 100%; padding-top: 75%;
    }
    .menu-img {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;
    }
    
    /* Kontrol Qty (Plus Minus) */
    .qty-control {
        display: flex; align-items: center; gap: 8px;
        position: relative; z-index: 10; /* FIX: Agar tombol bisa dipencet */
    }
    
    .btn-qty {
        width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--primary-red); cursor: pointer;
        transition: 0.2s; font-size: 14px;
    }
    
    /* Tombol Plus (Merah) */
    .btn-plus { background: var(--primary-red); color: white; }
    .btn-plus:active { transform: scale(0.9); }

    /* Tombol Minus (Putih) */
    .btn-minus { background: white; color: var(--primary-red); }
    .btn-minus:active { transform: scale(0.9); background: #fee; }

    .qty-number { font-weight: bold; font-size: 14px; min-width: 20px; text-align: center; }
</style>

<div class="table-info-card shadow-sm">
    <div class="d-flex align-items-center">
        <div class="bg-white text-danger rounded-circle d-flex align-items-center justify-content-center me-3" 
             style="width: 50px; height: 50px; flex-shrink: 0;">
            <i class="fas fa-utensils fa-lg"></i>
        </div>
        <div>
            <small class="opacity-75 text-uppercase" style="letter-spacing: 1px; font-size: 10px;">Lokasi Anda</small>
            <h4 class="fw-bold mb-0 text-white">Meja {{ $meja->nomor_meja }}</h4>
        </div>
    </div>
</div>

<div class="category-scroll mb-4">
    <a href="#" class="cat-pill active">Semua</a>
    @foreach ($kategoris as $kategori)
        @if($kategori->menus->count() > 0)
            <a href="#cat-{{ $kategori->id }}" class="cat-pill">{{ $kategori->nama_kategori }}</a>
        @endif
    @endforeach
</div>

@php $cart = session('cart', []); @endphp

@foreach ($kategoris as $kategori)
    @if($kategori->menus->count() > 0)
        <div id="cat-{{ $kategori->id }}" class="mb-4">
            <h5 class="fw-bold mb-3 px-1 border-start border-4 border-danger ps-2">{{ $kategori->nama_kategori }}</h5>
            
            <div class="row g-3">
                @foreach ($kategori->menus as $menu)
                @php 
                    $currentQty = isset($cart[$menu->id]) ? $cart[$menu->id]['quantity'] : 0;
                @endphp

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card menu-card h-100">
                        <div class="menu-img-wrap">
                            @if($menu->gambar)
                                <img src="{{ asset('storage/' . $menu->gambar) }}" class="menu-img" alt="{{ $menu->nama_menu }}">
                            @else
                                <div class="menu-img bg-secondary d-flex align-items-center justify-content-center text-white">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            @endif
                        </div>

                        <div class="card-body p-3 d-flex flex-column">
                            <h6 class="fw-bold mb-1 text-truncate" style="font-size: 14px;">{{ $menu->nama_menu }}</h6>
                            <p class="text-muted small mb-2 text-truncate" style="font-size: 11px;">{{ $menu->deskripsi ?? 'Enak & Lezat' }}</p>
                            
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-danger">Rp {{ number_format($menu->harga / 1000, 0) }}k</span>
                                
                                <div class="qty-control" id="qty-control-{{ $menu->id }}">
                                    <button class="btn-qty btn-minus btn-update-cart" 
                                            data-action="decrease"
                                            data-id="{{ $menu->id }}"
                                            style="{{ $currentQty > 0 ? '' : 'display:none' }}">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <span class="qty-number" id="qty-val-{{ $menu->id }}" 
                                          style="{{ $currentQty > 0 ? '' : 'display:none' }}">
                                        {{ $currentQty }}
                                    </span>

                                    <button class="btn-qty btn-plus btn-update-cart" 
                                            data-action="increase"
                                            data-id="{{ $menu->id }}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif
@endforeach

<div class="cart-float" id="cartFloat" style="{{ count($cart) > 0 ? '' : 'display: none;' }}">
    <div class="d-flex align-items-center">
        <div class="bg-warning text-dark rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px;">
            <span id="cartCount" class="fw-bold">
                {{ array_sum(array_column($cart, 'quantity')) }}
            </span>
        </div>
        <div>
            <small class="d-block text-white-50" style="font-size: 10px;">Total Estimasi</small>
            @php 
                $totalPrice = 0;
                foreach($cart as $c) $totalPrice += $c['price'] * $c['quantity'];
            @endphp
            <span class="fw-bold" id="cartTotal">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
        </div>
    </div>
    <a href="{{ route('cart.show') }}" class="btn btn-light rounded-pill px-4 fw-bold text-danger">
        <i class="fas fa-shopping-basket me-2"></i> Bayar
    </a>
</div>

@endsection

@section('scripts')
<script>
    // Smooth Scroll Kategori
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelectorAll('.cat-pill').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
            const target = document.querySelector(this.getAttribute('href'));
            if(target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    $(document).ready(function() {
        // SATU FUNGSI UNTUK TAMBAH & KURANG
        $('.btn-update-cart').click(function(e) {
            e.preventDefault();
            
            var btn = $(this);
            var menuId = btn.data('id');
            var action = btn.data('action'); // 'increase' atau 'decrease'
            
            // Tentukan URL berdasarkan aksi
            var url = (action === 'increase') ? "{{ route('cart.add') }}" : "{{ route('cart.decrease') }}";

            // Animasi tekan
            btn.css('transform', 'scale(0.8)');
            setTimeout(() => btn.css('transform', 'scale(1)'), 150);

            $.ajax({
                url: url,
                method: "POST",
                data: { _token: '{{ csrf_token() }}', id: menuId },
                success: function(response) {
                    // 1. Update Floating Cart Total
                    $('#cartCount').text(response.totalQty);
                    $('#cartTotal').text('Rp ' + response.totalPrice);
                    
                    if(response.totalQty > 0) {
                        $('#cartFloat').fadeIn();
                    } else {
                        $('#cartFloat').fadeOut();
                    }

                    // 2. Update UI Per Item (Munculkan/Sembunyikan tombol Minus)
                    var qtySpan = $('#qty-val-' + menuId);
                    var minusBtn = btn.parent().find('.btn-minus');

                    if(response.itemQty > 0) {
                        qtySpan.text(response.itemQty).show();
                        minusBtn.show(); // Tampilkan tombol minus jika qty > 0
                        minusBtn.css('display', 'flex'); // Paksa flex agar icon tengah
                    } else {
                        qtySpan.hide();
                        minusBtn.hide(); // Sembunyikan jika 0 (reset ke tombol plus saja)
                    }
                }
            });
        });
    });
</script>
@endsection