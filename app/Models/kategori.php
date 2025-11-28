<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    // Satu kategori punya banyak menu
    public function menus()
    {
        return $this->hasMany(menu::class);
    }
}
