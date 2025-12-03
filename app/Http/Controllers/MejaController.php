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

    // 1. UPDATE LOGIKA SIMPAN (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|unique:mejas,nomor_meja',
        ]);

        // GANTI BAGIAN INI:
        // Gunakan Link Production Railway secara eksplisit
        $baseUrl = 'https://e-qanpat-production.up.railway.app';
        $url_order = "{$baseUrl}/order/{$request->nomor_meja}";

        Meja::create([
            'nomor_meja' => $request->nomor_meja,
            'qr_code' => $url_order 
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
        
        // GANTI BAGIAN INI JUGA:
        $baseUrl = 'https://e-qanpat-production.up.railway.app';
        $url_order = "{$baseUrl}/order/{$request->nomor_meja}";

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