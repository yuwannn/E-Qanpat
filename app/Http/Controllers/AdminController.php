<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu;
use App\Models\kategori;
use App\Models\meja;
use App\Models\pesanan;
use App\Models\detail_pesanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Data Ringkasan (Card Atas)
        $total_menu = Menu::count();
        $total_kategori = Kategori::count();
        $total_meja = Meja::count();

        // 2. Data Top 5 Menu Terlaris
        // Menggabungkan tabel detail_pesanan & menu, lalu hitung jumlahnya
        $top_menus = detail_pesanan::with('menu')
            ->select('menu_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('menu_id')
            ->orderByDesc('total_terjual')
            ->take(5) // Ambil 5 saja
            ->get();

        // 3. Data Grafik Pendapatan (7 Hari Terakhir)
        $startDate = Carbon::now()->subDays(6); // 6 hari lalu + hari ini = 7 hari
        
        // Ambil data pesanan 'paid', kelompokkan per tanggal
        $incomeData = pesanan::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_harga) as total'))
            ->where('status_pembayaran', 'paid')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->get()
            ->pluck('total', 'date');

        // Siapkan Array untuk Chart.js (Looping manual agar tanggal yang 0 tetap muncul)
        $chartLabels = [];
        $chartValues = [];

        for ($i = 0; $i < 7; $i++) {
            $dateObj = Carbon::now()->subDays(6 - $i);
            $dateString = $dateObj->format('Y-m-d'); // Format key database
            
            $chartLabels[] = $dateObj->format('d M'); // Label Grafik: "03 Dec"
            $chartValues[] = $incomeData[$dateString] ?? 0; // Kalau tidak ada data, isi 0
        }

        return view('admin.dashboard', compact(
            'total_menu', 
            'total_kategori', 
            'total_meja', 
            'top_menus',
            'chartLabels',
            'chartValues'
        ));
    }
}