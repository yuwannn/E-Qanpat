@extends('layouts.admin')

@section('title', 'Edit Meja')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Nomor Meja</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('meja.update', $meja->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nomor Meja</label>
                        <input type="text" name="nomor_meja" class="form-control" value="{{ $meja->nomor_meja }}" required>
                        <small class="text-danger">Mengubah nomor meja akan mengubah data QR Code juga!</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('meja.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection