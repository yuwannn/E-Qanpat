<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pesanan; // Huruf kecil sesuai model Anda
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query pesanan
        $query = pesanan::with(['meja', 'detailPesanans'])
            ->where('status_pembayaran', 'paid') // Hanya yang sudah bayar
            ->orderBy('created_at', 'desc');

        // Logika Filter Tanggal
        if ($request->has('start_date') && $request->start_date != "" && $request->has('end_date') && $request->end_date != "") {
            $start = Carbon::parse($request->start_date)->startOfDay(); // 00:00:00
            $end = Carbon::parse($request->end_date)->endOfDay();     // 23:59:59
            
            $query->whereBetween('created_at', [$start, $end]);
        }

        // Ambil data dengan pagination (10 data per halaman)
        $riwayat = $query->paginate(10);
        
        // Append query string agar saat pindah halaman filter tanggal tidak hilang
        $riwayat->appends($request->all());

        return view('admin.riwayat.index', compact('riwayat'));
    }

    // Detail Riwayat (Opsional jika ingin melihat item apa saja yang dibeli)
    public function show($id)
    {
        $pesanan = pesanan::with(['meja', 'detailPesanans.menu'])->findOrFail($id);
        return view('admin.riwayat.detail', compact('pesanan'));
    }
}