@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10">
    <div class="bg-card border border-gray-700 rounded-2xl p-8 shadow-2xl relative overflow-hidden">
        
        <!-- Status Badge -->
        <div class="absolute top-0 right-0 px-6 py-2 rounded-bl-xl font-bold text-sm text-white
            {{ $trx->payment_status == 'paid' ? 'bg-green-600' : ($trx->payment_status == 'expired' ? 'bg-red-600' : 'bg-yellow-600') }}">
            {{ strtoupper($trx->payment_status) }}
        </div>

        <!-- TAMPILAN KHUSUS JIKA SUDAH BAYAR (SUCCESS PAGE) -->
        @if($trx->payment_status == 'paid')
            <div class="text-center mb-8 py-6">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-500/20 rounded-full mb-6 animate-bounce">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-white mb-2 tracking-tight">Pembayaran Berhasil!</h1>
                <p class="text-gray-400">Terima kasih! Diamond kamu sedang diproses otomatis.</p>
                
                <div class="mt-4 bg-dark/50 inline-block px-4 py-2 rounded-lg border border-gray-700">
                    <span class="text-gray-500 text-xs uppercase tracking-wider">Invoice Code</span>
                    <div class="font-mono font-bold text-xl text-primary select-all">{{ $trx->invoice_code }}</div>
                </div>
            </div>
        @else
            <!-- TAMPILAN MENUNGGU PEMBAYARAN -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Menunggu Pembayaran</h1>
                <p class="text-gray-400">Kode Invoice Pesanan Kamu:</p>
                <h2 class="text-4xl font-mono font-bold text-primary mt-2 select-all">{{ $trx->invoice_code }}</h2>
            </div>
        @endif

        <div class="space-y-4 border-t border-gray-700 pt-6">
            <div class="flex justify-between text-gray-300">
                <span>Game</span>
                <span class="font-bold text-white">{{ $trx->product->game->name }}</span>
            </div>
            <div class="flex justify-between text-gray-300">
                <span>Item</span>
                <span class="font-bold text-white">{{ $trx->product->name }}</span>
            </div>
            <div class="flex justify-between text-gray-300">
                <span>User ID</span>
                <span class="font-bold text-white">{{ $trx->user_game_id }} {{ $trx->zone_id ? '('.$trx->zone_id.')' : '' }}</span>
            </div>
            <div class="flex justify-between text-gray-300">
                <span>Metode Pembayaran</span>
                <span class="font-bold text-white">{{ $trx->payment_method }}</span>
            </div>
            
            <div class="flex justify-between text-xl font-bold text-primary border-t border-gray-700 pt-4 mt-4">
                <span>Total Bayar</span>
                <span>Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Instruksi Pembayaran Sederhana (Hanya muncul jika UNPAID) -->
        @if($trx->payment_status == 'unpaid')
        <div class="mt-8 bg-dark p-4 rounded-lg border border-gray-600 text-sm text-gray-300">
            <p class="font-bold text-white mb-2">Instruksi:</p>
            <p>Silakan lakukan pembayaran sesuai metode yang dipilih. Jika menggunakan QRIS, scan kode yang muncul (Simulasi: Silakan ubah status menjadi PAID lewat Halaman Admin).</p>
        </div>
        @endif

        <div class="mt-8 grid grid-cols-2 gap-4">
            <a href="{{ route('home') }}" class="block w-full text-center bg-gray-700 hover:bg-gray-600 text-white py-3 rounded-xl transition">
                {{ $trx->payment_status == 'paid' ? 'Beli Lagi' : 'Ke Beranda' }}
            </a>
            
            <!-- Tombol Konfirmasi / Refresh -->
            @if($trx->payment_status == 'unpaid')
                <button onclick="window.location.reload()" class="block w-full text-center bg-green-600 hover:bg-green-500 text-white py-3 rounded-xl transition font-bold">
                    Cek Status
                </button>
            @else
                 <!-- Jika Paid, tampilkan tombol bantuan/screenshot -->
                 <button onclick="window.print()" class="block w-full text-center bg-primary hover:bg-indigo-600 text-white py-3 rounded-xl transition">
                    Simpan Bukti
                </button>
            @endif
        </div>
    </div>
</div>
@endsection