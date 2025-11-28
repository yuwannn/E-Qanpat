<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategori; // Pastikan ini sesuai nama Class di model Anda

class KategoriController extends Controller
{
    // 1. TAMPILKAN DAFTAR KATEGORI
    public function index()
    {
        $kategoris = kategori::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    // 2. TAMPILKAN FORM TAMBAH
    public function create()
    {
        return view('admin.kategori.create');
    }

    // 3. PROSES SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        kategori::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    // 4. TAMPILKAN FORM EDIT
    public function edit($id)
    {
        $kategori = kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    // 5. PROSES UPDATE DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $kategori = kategori::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    // 6. PROSES HAPUS DATA
    public function destroy($id)
    {
        $kategori = kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}