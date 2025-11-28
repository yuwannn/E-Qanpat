<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Menu milik satu kategori
    public function kategori()
    {
        return $this->belongsTo(kategori::class);
    }
}
