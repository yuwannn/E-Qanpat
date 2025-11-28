@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pesanan #{{ $pesanan->id }}</h6>
                <a href="{{ route('riwayat.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-6">
                        <p class="mb-1"><strong>Tanggal:</strong> {{ $pesanan->created_at->format('d F Y H:i') }}</p>
                        <p class="mb-1"><strong>Pelanggan:</strong> {{ $pesanan->nama_pelanggan }}</p>
                        <p class="mb-1"><strong>Lokasi:</strong> Meja {{ $pesanan->meja->nomor_meja }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="mb-1">Status: <span class="badge bg-success">LUNAS</span></p>
                        <p class="mb-1">Metode: {{ strtoupper($pesanan->metode_pembayaran) }}</p>
                        <p class="mb-1">Kasir: {{ Auth::user()->name }}</p> </div>
                </div>

                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>Menu</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan->detailPesanans as $detail)
                        <tr>
                            <td>{{ $detail->menu->nama_menu }}</td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td class="text-end">Rp {{ number_format($detail->harga_satuan, 0) }}</td>
                            <td class="text-end">Rp {{ number_format($detail->harga_satuan * $detail->jumlah, 0) }}</td>
                        </tr>
                        @endforeach
                        <tr class="fw-bold fs-5">
                            <td colspan="3" class="text-end">TOTAL</td>
                            <td class="text-end text-primary">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="text-end mt-4">
                    <a href="{{ route('cashier.print', $pesanan->id) }}" target="_blank" class="btn btn-dark">
                        <i class="fas fa-print me-2"></i> Cetak Struk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection