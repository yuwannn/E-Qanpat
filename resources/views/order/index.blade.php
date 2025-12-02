@extends('layouts.app_pelanggan')

@section('content')

<style>
    /* Info Meja Card */
    .table-info-card {
        background: linear-gradient(135deg, var(--primary-red), #b71c1c);
        color: white;
        padding: 20px;
        border-radius: 20px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }
    .table-info-card::after {
        content: ''; position: absolute; top: -20px; right: -20px;
        width: 100px; height: 100px; background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    /* Kategori Horizontal Scroll */
    .category-scroll {
        display: flex;
        overflow-x: auto;
        gap: 10px;
        padding-bottom: 10px;
        scrollbar-width: none; /* Hide scrollbar FF */
    }
    .category-scroll::-webkit-scrollbar { display: none; } /* Hide scrollbar Chrome */
    
    .cat-pill {
        background: var(--bg-card);
        color: var(--text-muted);
        padding: 8px 20px;
        border-radius: 50px;
        white-space: nowrap;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid var(--border-color);
        transition: 0.3s;
        text-decoration: none;
    }
    .cat-pill.active {
        background: var(--primary-red);
        color: white;
        border-color: var(--primary-red);
        box-shadow: 0 4px 10px rgba(211, 47, 47, 0.3);
    }

    /* Menu Grid */
    .menu-card {
        overflow: hidden;
        height: 100%;
        position: relative;
    }
    .menu-img-wrap {
        position: relative;
        width: 100%;
        padding-top: 75%; /* Aspect Ratio 4:3 */
    }
    .menu-img {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover;
    }
    .menu-badge {
        position: absolute; top: 10px; left: 10px;
        background: rgba(0,0,0,0.6); color: white;
        padding: 3px 10px; border-radius: 20px;
        font-size: 10px; backdrop-filter: blur(5px);
    }
    
    .btn-add {
        width: 35px; height: 35px;
        border-radius: 50%;
        background: var(--bg-body);
        color: var(--primary-red);
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--border-color);
        transition: 0.2s;
    }
    .btn-add:active { transform: scale(0.9); background: var(--primary-red); color: white; }
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

@foreach ($kategoris as $kategori)
    @if($kategori->menus->count() > 0)
        <div id="cat-{{ $kategori->id }}" class="mb-4">
            <h5 class="fw-bold mb-3 px-1 border-start border-4 border-danger ps-2">{{ $kategori->nama_kategori }}</h5>
            
            <div class="row g-3">
                @foreach ($kategori->menus as $menu)
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
                            <span class="menu-badge"><i class="fas fa-star text-warning"></i> 4.8</span>
                        </div>

                        <div class="card-body p-3 d-flex flex-column">
                            <h6 class="fw-bold mb-1 text-truncate" style="font-size: 14px;">{{ $menu->nama_menu }}</h6>
                            <p class="text-muted small mb-2 text-truncate" style="font-size: 11px;">{{ $menu->deskripsi ?? 'Enak & Lezat' }}</p>
                            
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-danger">Rp {{ number_format($menu->harga / 1000, 0) }}k</span>
                                
                                <button class="btn-add btn-add-cart shadow-sm" 
                                        data-id="{{ $menu->id }}" 
                                        data-name="{{ $menu->nama_menu }}"
                                        data-price="{{ $menu->harga }}">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif
@endforeach

<div class="cart-float" id="cartFloat" style="display: none;">
    <div class="d-flex align-items-center">
        <div class="bg-warning text-dark rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px;">
            <span id="cartCount" class="fw-bold">0</span>
        </div>
        <div>
            <small class="d-block text-white-50" style="font-size: 10px;">Total Estimasi</small>
            <span class="fw-bold" id="cartTotal">Rp 0</span>
        </div>
    </div>
    <a href="{{ route('cart.show') }}" class="btn btn-light rounded-pill px-4 fw-bold text-danger">
        <i class="fas fa-shopping-basket me-2"></i> Bayar
    </a>
</div>

@endsection

@section('scripts')
<script>
    // Smooth Scroll untuk kategori
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            // Reset active class
            document.querySelectorAll('.cat-pill').forEach(el => el.classList.remove('active'));
            this.classList.add('active');

            const target = document.querySelector(this.getAttribute('href'));
            if(target){
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    $(document).ready(function() {
        // Logic Add to Cart (Sama seperti sebelumnya, tapi tombolnya lebih stylish)
        $('.btn-add-cart').click(function(e) {
            e.preventDefault();
            var menuId = $(this).data('id');
            var btn = $(this);

            // Efek Click
            btn.css('transform', 'scale(0.8)');
            setTimeout(() => btn.css('transform', 'scale(1)'), 150);

            $.ajax({
                url: "{{ route('cart.add') }}",
                method: "POST",
                data: { _token: '{{ csrf_token() }}', id: menuId },
                success: function(response) {
                    $('#cartCount').text(response.totalQty);
                    $('#cartTotal').text('Rp ' + response.totalPrice);
                    $('#cartFloat').fadeIn();
                }
            });
        });
    });
</script>
@endsection