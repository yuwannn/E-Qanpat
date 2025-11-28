<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\meja; // Huruf kecil sesuai model Anda
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

    // 3. SIMPAN MEJA
    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|unique:mejas,nomor_meja',
        ]);

        // Kita generate string unik untuk QR Code, misalnya URL login meja
        // Nanti user scan ini langsung masuk ke menu
        $url_order = url("/order/{$request->nomor_meja}");

        meja::create([
            'nomor_meja' => $request->nomor_meja,
            'qr_code' => $url_order // Kita simpan isi URL-nya di database
        ]);

        return redirect()->route('meja.index')->with('success', 'Meja berhasil ditambahkan');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $meja = meja::findOrFail($id);
        return view('admin.meja.edit', compact('meja'));
    }

    // 5. UPDATE MEJA
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_meja' => 'required|unique:mejas,nomor_meja,' . $id,
        ]);

        $meja = meja::findOrFail($id);
        
        // Update URL QR jika nomor meja berubah
        $url_order = url("/order/{$request->nomor_meja}");

        $meja->update([
            'nomor_meja' => $request->nomor_meja,
            'qr_code' => $url_order
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