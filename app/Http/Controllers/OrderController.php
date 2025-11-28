<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu;
use App\Models\kategori;
use App\Models\meja;
use App\Models\pesanan;
use App\Models\detail_pesanan;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1. HALAMAN AWAL (SAAT SCAN QR)
    public function index($nomor_meja)
    {
        // Cek apakah nomor meja valid (ada di database)
        $meja = meja::where('nomor_meja', $nomor_meja)->first();

        if (!$meja) {
            return abort(404, 'Meja tidak ditemukan!');
        }

        // Simpan nomor meja ke session user
        session(['nomor_meja' => $nomor_meja]);
        session(['meja_id' => $meja->id]);

        // Ambil semua kategori beserta menunya yang 'tersedia'
        $kategoris = kategori::with(['menus' => function($query) {
            $query->where('tersedia', true);
        }])->get();

        return view('order.index', compact('meja', 'kategoris'));
    }

    // 1. TAMBAH KE KERANJANG (AJAX)
    public function addToCart(Request $request)
    {
        $id = $request->id;
        $cart = session()->get('cart', []);

        // Jika menu sudah ada di cart, tambah jumlahnya
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Jika belum, masukkan data baru
            $menu = menu::find($id);
            $cart[$id] = [
                "name" => $menu->nama_menu,
                "quantity" => 1,
                "price" => $menu->harga,
                "image" => $menu->gambar
            ];
        }

        session()->put('cart', $cart);
        
        // Hitung total item dan total harga untuk respons JSON
        $totalQty = 0;
        $totalPrice = 0;
        foreach($cart as $item) {
            $totalQty += $item['quantity'];
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true, 
            'totalQty' => $totalQty, 
            'totalPrice' => number_format($totalPrice, 0, ',', '.')
        ]);
    }

    // 2. LIHAT HALAMAN KERANJANG
    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('order.cart', compact('cart'));
    }

    // 3. PROSES CHECKOUT
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        
        if(!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // Gunakan Database Transaction agar aman (semua tersimpan atau batal semua)
        try {
            DB::beginTransaction();

            // Hitung total bayar
            $total_harga = 0;
            foreach($cart as $id => $details) {
                $total_harga += $details['price'] * $details['quantity'];
            }

            // Simpan ke Tabel Pesanans
            $pesanan = pesanan::create([
                'meja_id' => session('meja_id'),
                'nama_pelanggan' => $request->nama_pelanggan ?? 'Pelanggan',
                'total_harga' => $total_harga,
                'status' => 'pending',
                'status_pembayaran' => 'unpaid',
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            // Simpan ke Tabel Detail Pesanans
            foreach($cart as $id => $details) {
                // Perhatikan: Model detail_pesanan atau detail_pesanan (sesuaikan nama class Anda)
                \App\Models\detail_pesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $id,
                    'jumlah' => $details['quantity'],
                    'harga_satuan' => $details['price']
                ]);
            }

            DB::commit();

            // Kosongkan keranjang
            session()->forget('cart');

            return redirect()->route('order.success', $pesanan->id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // 4. HALAMAN SUKSES
    public function success($id)
    {
        $pesanan = pesanan::with('meja')->findOrFail($id);
        return view('order.success', compact('pesanan'));
    }
}