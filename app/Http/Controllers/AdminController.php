<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu;
use App\Models\kategori;
use App\Models\meja;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil data ringkasan untuk dashboard
        $total_menu = menu::count();
        $total_kategori = kategori::count();
        $total_meja = meja::count();

        return view('admin.dashboard', compact('total_menu', 'total_kategori', 'total_meja'));
    }
}