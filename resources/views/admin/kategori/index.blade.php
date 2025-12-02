@extends('layouts.admin')

@section('title', 'Data Kategori')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori Menu</h6>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>
    <div class="card-body">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategoris as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_kategori }}</td>
                        <td>{{ $item->deskripsi ?? '-' }}</td>
                        <td>
                            <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button type="button" 
                                    class="btn btn-danger btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-action="{{ route('kategori.destroy', $item->id) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection