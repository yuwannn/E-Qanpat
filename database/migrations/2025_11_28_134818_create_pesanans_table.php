<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel mejas
            $table->foreignId('meja_id')->constrained('mejas')->onDelete('cascade');
            $table->string('nama_pelanggan')->nullable();
            $table->decimal('total_harga', 12, 2)->default(0);
            // Status pesanan & pembayaran
            $table->enum('status', ['pending', 'in_progress', 'done', 'cancelled'])->default('pending');
            $table->enum('status_pembayaran', ['unpaid', 'paid'])->default('unpaid');
            $table->enum('metode_pembayaran', ['cash', 'qris'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
