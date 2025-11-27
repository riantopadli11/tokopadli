<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    // TAMBAHKAN KODE INI:
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}