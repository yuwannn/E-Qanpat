@extends('layouts.app_pelanggan')

@section('content')

<div class="alert alert-light shadow-sm d-flex align-items-center mb-4 border-0" role="alert">
    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px;">
        <i class="fas fa-chair"></i>
    </div>
    <div>
        <small class="text-muted d-block">Lokasi Anda</small>
        <span class="fw-bold text-dark">Meja Nomor {{ $meja->nomor_meja }}</span>
    </div>
</div>

@foreach ($kategoris as $kategori)
    @if($kategori->menus->count() > 0)
        <h5 class="category-title">{{ $kategori->nama_kategori }}</h5>
        
        <div class="row g-3">
            @foreach ($kategori->menus as $menu)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card menu-card shadow-sm h-100">
                    @if($menu->gambar)
                        <img src="{{ asset('storage/' . $menu->gambar) }}" class="menu-img" alt="{{ $menu->nama_menu }}">
                    @else
                        <div class="bg-secondary text-white d-flex justify-content-center align-items-center menu-img">
                            <i class="fas fa-image fa-2x"></i>
                        </div>
                    @endif
                    
                    <div class="card-body p-2 d-flex flex-column">
                        <h6 class="card-title fw-bold mb-1 text-truncate" style="font-size: 14px;">{{ $menu->nama_menu }}</h6>
                        <p class="text-muted small mb-2 text-truncate" style="font-size: 11px;">{{ $menu->deskripsi }}</p>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold small">Rp {{ number_format($menu->harga / 1000, 0) }}k</span>
                            
                            <button class="btn btn-sm btn-outline-primary rounded-circle btn-add-cart" 
                                    data-id="{{ $menu->id }}" 
                                    data-name="{{ $menu->nama_menu }}"
                                    data-price="{{ $menu->harga }}"
                                    style="width: 30px; height: 30px; padding: 0;">
                                <i class="fas fa-plus" style="font-size: 12px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
@endforeach

<div class="cart-float" id="cartFloat" style="display: none;">
    <div class="d-flex align-items-center">
        <div class="bg-dark text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 35px; height: 35px;">
            <span id="cartCount" class="fw-bold small">0</span>
        </div>
        <div>
            <small class="d-block text-muted" style="font-size: 10px;">Total Estimasi</small>
            <span class="fw-bold text-dark" id="cartTotal">Rp 0</span>
        </div>
    </div>
    <a href="#" class="btn btn-primary btn-sm rounded-pill px-3">
        Lihat Pesanan <i class="fas fa-arrow-right ms-1"></i>
    </a>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Klik Tombol Tambah
        $('.btn-add-cart').click(function(e) {
            e.preventDefault();
            var menuId = $(this).data('id');
            var btn = $(this);

            // Animasi Loading tombol
            btn.html('<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url: "{{ route('cart.add') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: menuId
                },
                success: function(response) {
                    // Kembalikan ikon tombol
                    btn.html('<i class="fas fa-plus"></i>');
                    
                    // Update tampilan Floating Cart
                    $('#cartCount').text(response.totalQty);
                    $('#cartTotal').text('Rp ' + response.totalPrice);
                    $('#cartFloat').fadeIn();
                    
                    // Ubah link tombol "Lihat Pesanan"
                    $('#cartFloat a').attr('href', "{{ route('cart.show') }}");
                }
            });
        });
    });
</script>
@endsection