<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\kategori;
use App\Models\menu;
use App\Models\meja;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User (Admin & Cashier)
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@kanpat.com',
            'password' => Hash::make('password'), // Password default
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kasir Satu',
            'email' => 'kasir@kanpat.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
        ]);

        // 2. Buat Data meja (Contoh 5 meja)
        // Kita pakai loop biar cepat
        for ($i = 1; $i <= 5; $i++) {
            meja::create([
                'nomor_meja' => '0' . $i,
                'qr_code' => 'kanpat_qr_meja_0' . $i, // Dummy QR string dulu
            ]);
        }

        // 3. Buat kategori
        $makanan = kategori::create([
            'nama_kategori' => 'Makanan Berat',
            'deskripsi' => 'Nasi, Mie, dan lauk pauk'
        ]);

        $minuman = kategori::create([
            'nama_kategori' => 'Minuman',
            'deskripsi' => 'Minuman dingin dan hangat'
        ]);

        $snack = kategori::create([
            'nama_kategori' => 'Camilan',
            'deskripsi' => 'Jajanan ringan pelengkap nongkrong'
        ]);

        // 4. Buat menu Makanan (Relasi ke kategori Makanan)
        menu::create([
            'kategori_id' => $makanan->id,
            'nama_menu' => 'Nasi Goreng Spesial',
            'deskripsi' => 'Nasi goreng dengan telur mata sapi dan sosis',
            'harga' => 15000,
            'tersedia' => true,
            'gambar' => 'nasi_goreng.jpg'
        ]);

        menu::create([
            'kategori_id' => $makanan->id,
            'nama_menu' => 'Ayam Geprek Sambal Ijo',
            'deskripsi' => 'Ayam krispi digeprek dengan sambal ijo pedas',
            'harga' => 13000,
            'tersedia' => true,
            'gambar' => 'ayam_geprek.jpg'
        ]);

        // 5. Buat menu Minuman (Relasi ke kategori Minuman)
        menu::create([
            'kategori_id' => $minuman->id,
            'nama_menu' => 'Es Teh Manis',
            'deskripsi' => 'Teh manis dingin segar',
            'harga' => 3000,
            'tersedia' => true,
            'gambar' => 'es_teh.jpg'
        ]);

        menu::create([
            'kategori_id' => $minuman->id,
            'nama_menu' => 'Kopi Hitam Panas',
            'deskripsi' => 'Kopi kapal api gula aren',
            'harga' => 5000,
            'tersedia' => true,
            'gambar' => 'kopi.jpg'
        ]);

        // 6. Buat menu Snack
        menu::create([
            'kategori_id' => $snack->id,
            'nama_menu' => 'Kentang Goreng',
            'deskripsi' => 'French fries dengan saus sambal',
            'harga' => 10000,
            'tersedia' => true,
            'gambar' => 'kentang.jpg'
        ]);
    }
}