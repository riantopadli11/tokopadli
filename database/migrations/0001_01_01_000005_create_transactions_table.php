<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique(); 
            // Pastikan tabel 'products' sudah ada sebelum baris ini jalan
            $table->foreignId('product_id')->constrained();
            $table->string('user_game_id'); 
            $table->string('zone_id')->nullable(); 
            $table->string('whatsapp')->nullable(); 
            $table->decimal('amount', 10, 2); 
            $table->string('payment_method'); 
            $table->string('payment_status')->default('unpaid'); 
            $table->string('process_status')->default('pending'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};