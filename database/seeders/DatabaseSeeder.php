<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Product;
use App\Models\User; // Tambahkan ini
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Tambahkan ini

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin Default
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@tokopadli.com',
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'admin',
        ]);

        // 2. Buat Game: Mobile Legends
        $ml = Game::create([
            'name' => 'Mobile Legends',
            'slug' => 'mobile-legends',
            'thumbnail' => null, 
            'target_provider' => 'digiflazz',
            'is_active' => true,
        ]);

        // 3. Buat Produk Diamond untuk ML
        $diamonds = [
            ['name' => '3 Diamonds', 'sku' => 'ML3', 'modal' => 900, 'jual' => 1500],
            ['name' => '86 Diamonds', 'sku' => 'ML86', 'modal' => 19500, 'jual' => 23000],
            ['name' => '172 Diamonds', 'sku' => 'ML172', 'modal' => 38000, 'jual' => 45000],
            ['name' => 'Weekly Diamond Pass', 'sku' => 'WDP', 'modal' => 26000, 'jual' => 28500],
        ];

        foreach ($diamonds as $d) {
            Product::create([
                'game_id' => $ml->id,
                'name' => $d['name'],
                'sku_provider' => $d['sku'],
                'price_provider' => $d['modal'],
                'price_sell' => $d['jual'],
            ]);
        }
    }
}
