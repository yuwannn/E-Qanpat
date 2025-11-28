@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Menu</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Menu</label>
                            <input type="text" name="nama_menu" class="form-control" value="{{ $menu->nama_menu }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-select" required>
                                @foreach($kategoris as $cat)
                                    <option value="{{ $cat->id }}" {{ $menu->kategori_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="{{ $menu->harga }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar Saat Ini</label><br>
                        @if($menu->gambar)
                            <img src="{{ asset('storage/' . $menu->gambar) }}" width="100" class="mb-2 rounded border">
                        @else
                            <span class="text-muted">Belum ada gambar</span>
                        @endif
                        <input type="file" name="gambar" class="form-control mt-1" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ $menu->deskripsi }}</textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="tersedia" value="1" id="stokCheck" {{ $menu->tersedia ? 'checked' : '' }}>
                            <label class="form-check-label" for="stokCheck">Stok Tersedia?</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Menu</button>
                    <a href="{{ route('menu.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection