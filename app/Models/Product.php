<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi: Produk milik satu Game
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}