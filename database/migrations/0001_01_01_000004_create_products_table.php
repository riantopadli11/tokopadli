<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Pastikan tabel 'games' sudah ada sebelum baris ini jalan
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->string('name'); 
            $table->string('sku_provider'); 
            $table->decimal('price_provider', 10, 2); 
            $table->decimal('price_sell', 10, 2); 
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};