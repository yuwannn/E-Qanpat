<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pesanan extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Pesanan milik satu meja
    public function meja()
    {
        return $this->belongsTo(meja::class);
    }

    // Pesanan punya banyak detail item
    public function detailPesanans()
    {
        return $this->hasMany(detail_pesanan::class);
    }
}
