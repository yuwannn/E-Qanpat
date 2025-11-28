<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class meja extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Satu meja bisa punya banyak riwayat pesanan
    public function pesanans()
    {
        return $this->hasMany(pesanan::class);
    }
}
