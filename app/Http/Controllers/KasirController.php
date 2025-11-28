<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pesanan; // Model Pesanan
use App\Models\meja;

class KasirController extends Controller
{
    // 1. HALAMAN DASHBOARD KASIR
    public function index()
    {
        // Ambil pesanan hari ini atau semua pesanan yang belum selesai
        // Urutkan dari yang terbaru
        $pesanans = pesanan::with(['meja', 'detailPesanans.menu'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('kasir.dashboard', compact('pesanans'));
    }

    // 2. UPDATE STATUS (Bayar / Masak / Selesai / Batal)
    public function updateStatus(Request $request, $id)
    {
        $pesanan = pesanan::findOrFail($id);

        // Update Status Pesanan
        if ($request->has('status')) {
            $pesanan->status = $request->status;
        }

        // Update Status Pembayaran
        if ($request->has('status_pembayaran')) {
            $pesanan->status_pembayaran = $request->status_pembayaran;
        }

        $pesanan->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function printStruk($id)
    {
        $pesanan = pesanan::with(['meja', 'detailPesanans.menu'])->findOrFail($id);
        return view('kasir.struk', compact('pesanan'));
    }
}