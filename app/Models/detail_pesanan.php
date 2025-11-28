<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_pesanan extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Detail milik satu pesanan
    public function pesanan()
    {
        return $this->belongsTo(pesanan::class);
    }

    // Detail merujuk ke satu menu
    public function menu()
    {
        return $this->belongsTo(menu::class);
    }
}
