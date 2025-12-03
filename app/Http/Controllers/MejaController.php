<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\meja; // Huruf kecil sesuai model Anda
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class MejaController extends Controller
{
    // 1. DAFTAR MEJA
    public function index()
    {
        $mejas = meja::all();
        return view('admin.meja.index', compact('mejas'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        return view('admin.meja.create');
    } 

    // 1. UPDATE LOGIKA SIMPAN (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|unique:mejas,nomor_meja',
        ]);

        // 1. Buat Token Rahasia Acak
        $token = Str::random(32);

        // 2. Masukkan Token ke URL QR
        $baseUrl = 'https://e-qanpat-production.up.railway.app';
        // URL jadi: .../order/01?token=ajshd76as...
        $url_order = "{$baseUrl}/order/{$request->nomor_meja}?token={$token}";

        Meja::create([
            'nomor_meja' => $request->nomor_meja,
            'qr_code' => $url_order ,
            'token' => $token
        ]);

        return redirect()->route('meja.index')->with('success', 'Meja berhasil ditambahkan');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $meja = meja::findOrFail($id);
        return view('admin.meja.edit', compact('meja'));
    }

    // 2. UPDATE LOGIKA EDIT (UPDATE)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_meja' => 'required|unique:mejas,nomor_meja,' . $id,
        ]);

        $meja = Meja::findOrFail($id);

        // Cek: Jika meja belum punya token (data lama), buatkan baru. 
        // Jika sudah ada, pakai yang lama agar QR code fisik tidak berubah (kecuali Anda mau reset).
        $token = $meja->token ?? Str::random(32);
        
        $baseUrl = 'https://e-qanpat-production.up.railway.app';
        $url_order = "{$baseUrl}/order/{$request->nomor_meja}?token={$token}";

        $meja->update([
            'nomor_meja' => $request->nomor_meja,
            'qr_code' => $url_order,
            'token' => $token
        ]);

        return redirect()->route('meja.index')->with('success', 'Meja berhasil diperbarui');
    }

    // 6. HAPUS MEJA
    public function destroy($id)
    {
        $meja = meja::findOrFail($id);
        $meja->delete();

        return redirect()->route('meja.index')->with('success', 'Meja berhasil dihapus');
    }
}