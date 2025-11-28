@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white">
        <h6 class="m-0 font-weight-bold text-primary">Data Riwayat Pesanan Lunas</h6>
    </div>
    <div class="card-body">
        
        <form action="{{ route('riwayat.index') }}" method="GET" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('riwayat.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </div>
        </form>

        <hr>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Meja</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $index => $item)
                    <tr>
                        <td>{{ $riwayat->firstItem() + $index }}</td>
                        <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                        <td>{{ $item->nama_pelanggan }}</td>
                        <td><span class="badge bg-info">Meja {{ $item->meja->nomor_meja }}</span></td>
                        <td class="fw-bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ strtoupper($item->metode_pembayaran) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('riwayat.show', $item->id) }}" class="btn btn-info btn-sm text-white">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('cashier.print', $item->id) }}" target="_blank" class="btn btn-dark btn-sm">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Tidak ada data transaksi ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $riwayat->links() }} 
            </div>

    </div>
</div>
@endsection