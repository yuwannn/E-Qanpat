<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu;      // Huruf kecil sesuai request
use App\Models\kategori;  // Huruf kecil sesuai request
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // 1. TAMPILKAN DAFTAR MENU
    public function index()
    {
        // Kita load relasi 'kategori' agar tidak query berulang-ulang (N+1 problem)
        $menus = menu::with('kategori')->get();
        return view('admin.menu.index', compact('menus'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        // Ambil semua kategori untuk dropdown
        $kategoris = kategori::all();
        return view('admin.menu.create', compact('kategoris'));
    }

    // 3. PROSES SIMPAN
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'deskripsi' => 'nullable|string',
            'tersedia' => 'boolean'
        ]);

        $data = $request->all();

        // Logika Upload Gambar
        if ($request->hasFile('gambar')) {
            // Simpan ke folder: storage/app/public/menus
            $path = $request->file('gambar')->store('menus', 'public');
            $data['gambar'] = $path;
        }

        menu::create($data);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $menu = menu::findOrFail($id);
        $kategoris = kategori::all();
        return view('admin.menu.edit', compact('menu', 'kategoris'));
    }

    // 5. PROSES UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $menu = menu::findOrFail($id);
        $data = $request->all();

        // Cek jika ada gambar baru yang diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
                Storage::disk('public')->delete($menu->gambar);
            }
            // Upload gambar baru
            $path = $request->file('gambar')->store('menus', 'public');
            $data['gambar'] = $path;
        }

        $menu->update($data);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui');
    }

    // 6. PROSES HAPUS
    public function destroy($id)
    {
        $menu = menu::findOrFail($id);

        // Hapus file gambar dari storage
        if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
            Storage::disk('public')->delete($menu->gambar);
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus');
    }
}