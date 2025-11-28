@extends('layouts.admin')

@section('title', 'Tambah Meja')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Meja</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('meja.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nomor Meja</label>
                        <input type="text" name="nomor_meja" class="form-control" placeholder="Contoh: 01, 02, A1" required>
                        <small class="text-muted">QR Code akan otomatis digenerate berdasarkan nomor ini.</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('meja.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection