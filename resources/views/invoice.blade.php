@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10">
    <div class="bg-card border border-gray-700 rounded-2xl p-8 shadow-2xl relative overflow-hidden">
        
        <!-- Status Badge -->
        <div class="absolute top-0 right-0 px-6 py-2 rounded-bl-xl font-bold text-sm text-white
            {{ $trx->payment_status == 'paid' ? 'bg-green-600' : ($trx->payment_status == 'expired' ? 'bg-red-600' : 'bg-yellow-600') }}">
            {{ strtoupper($trx->payment_status) }}
        </div>

        <!-- LOGIKA TAMPILAN -->
        @if($trx->payment_status == 'paid')
            <!-- === TAMPILAN 1: PEMBAYARAN SUKSES === -->
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

        @elseif($trx->payment_status == 'expired')
            <!-- === TAMPILAN 2: EXPIRED === -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-red-500 mb-2">Invoice Kadaluarsa</h1>
                <p class="text-gray-400">Silakan lakukan pemesanan ulang.</p>
            </div>

        @else
            <!-- === TAMPILAN 3: MENUNGGU PEMBAYARAN (QRIS / LINK) === -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-white mb-2">Selesaikan Pembayaran</h1>
                <p class="text-gray-400 text-sm">Scan QRIS atau klik tombol bayar di bawah ini.</p>
            </div>

            <!-- AREA QR CODE (Khusus QRIS) -->
            <!-- LOGIKA DIPERBAIKI: Cek dulu metodenya QRIS, baru cek datanya -->
            @if($trx->payment_method == 'QRIS' || $trx->payment_method == 'QRIS2')
                <div class="bg-white p-4 rounded-xl mx-auto w-64 h-64 mb-6 shadow-lg flex items-center justify-center relative group">
                    
                    @if($trx->qr_string)
                        <!-- 1. Jika ada data QR Asli dari Tripay -->
                        <img src="{{ $trx->qr_string }}" alt="Scan QRIS" class="w-full h-full object-contain">
                    @else
                        <!-- 2. Fallback/Placeholder jika QR belum masuk (misal API error/loading) -->
                        <div class="text-center flex flex-col items-center justify-center h-full w-full">
                             <!-- Gambar QR Dummy -->
                             <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=MenungguProvider" alt="QR Loading" class="w-32 h-32 opacity-20">
                             <p class="text-[10px] text-gray-500 mt-2 animate-pulse">Menunggu QR dari Provider...</p>
                        </div>
                    @endif
                    
                    <!-- Hover Instruction -->
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition rounded-xl">
                        <span class="text-white font-bold text-sm">Scan Pakai E-Wallet</span>
                    </div>
                </div>
                <p class="text-center text-xs text-gray-500 mb-6">Mendukung GoPay, OVO, Dana, ShopeePay, LinkAja, BCA Mobile, dll.</p>
            
            @elseif($trx->payment_url)
                <!-- AREA TOMBOL LINK (Untuk VA, Alfamart, dll) -->
                <div class="text-center mb-6">
                    <a href="{{ $trx->payment_url }}" target="_blank" class="inline-flex items-center gap-2 bg-primary hover:bg-indigo-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Bayar Sekarang
                    </a>
                    <p class="text-xs text-gray-500 mt-3">Klik tombol di atas untuk melihat instruksi pembayaran.</p>
                </div>
            @else
                <!-- FALLBACK JIKA BELUM ADA LINK SAMA SEKALI -->
                <div class="text-center mb-6 p-4 bg-yellow-900/30 border border-yellow-700 rounded-lg">
                    <p class="text-yellow-500 text-sm">Link pembayaran belum tersedia. Silakan refresh halaman.</p>
                </div>
            @endif

        @endif

        <!-- DETAIL TRANSAKSI -->
        <div class="space-y-4 border-t border-gray-700 pt-6">
            <div class="flex justify-between text-gray-300">
                <span>Invoice</span>
                <span class="font-mono text-white select-all">{{ $trx->invoice_code }}</span>
            </div>
            <div class="flex justify-between text-gray-300">
                <span>Game / Item</span>
                <span class="font-bold text-white">{{ $trx->product->game->name }} - {{ $trx->product->name }}</span>
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

        <!-- TOMBOL AKSI BAWAH -->
        <div class="mt-8 grid grid-cols-2 gap-4">
            <a href="{{ route('home') }}" class="block w-full text-center bg-gray-700 hover:bg-gray-600 text-white py-3 rounded-xl transition">
                {{ $trx->payment_status == 'paid' ? 'Beli Lagi' : 'Ke Beranda' }}
            </a>
            
            @if($trx->payment_status == 'unpaid')
                <button onclick="window.location.reload()" class="block w-full text-center bg-green-600 hover:bg-green-500 text-white py-3 rounded-xl transition font-bold flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Cek Status
                </button>
            @elseif($trx->payment_status == 'paid')
                 <button onclick="window.print()" class="block w-full text-center bg-primary hover:bg-indigo-600 text-white py-3 rounded-xl transition">
                    Simpan Bukti
                </button>
            @endif
        </div>
    </div>
</div>
@endsection