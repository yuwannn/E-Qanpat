@extends('layouts.admin')

@section('title', 'Manajemen Meja')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Meja & QR Code</h6>
        <a href="{{ route('meja.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Meja
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            @foreach ($mejas as $item)
            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center border-left-primary shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold">Meja {{ $item->nomor_meja }}</h5>
                        
                        <div class="my-3 d-flex justify-content-center">
                            {!! QrCode::size(120)->generate($item->qr_code) !!}
                        </div>
                        
                        <p class="small text-muted text-truncate">{{ $item->qr_code }}</p>

                        <div class="mt-3">
                            <a href="{{ route('meja.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" 
                                    class="btn btn-danger btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-action="{{ route('meja.destroy', $item->id) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection