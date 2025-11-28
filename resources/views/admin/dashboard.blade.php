@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Menu</h6>
                        <h2 class="mb-0">{{ $total_menu ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-burger fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Kategori</h6>
                        <h2 class="mb-0">{{ $total_kategori ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-tags fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-dark h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Meja</h6>
                        <h2 class="mb-0">{{ $total_meja ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-chair fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-danger text-white h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Order Hari Ini</h6>
                        <h2 class="mb-0">0</h2>
                    </div>
                    <i class="fas fa-receipt fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Log Aktivitas Terbaru</h6>
    </div>
    <div class="card-body">
        <p class="text-muted text-center py-5">Belum ada aktivitas transaksi.</p>
    </div>
</div>
@endsection