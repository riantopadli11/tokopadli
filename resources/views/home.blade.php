@extends('layouts.app')

@section('content')

<!-- HERO SECTION: Banner Promosi -->
<div class="relative bg-gradient-to-r from-indigo-900 to-dark rounded-2xl p-8 mb-10 overflow-hidden shadow-2xl">
    <div class="relative z-10">
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4">
            Top Up Game <span class="text-primary">Tercepat</span>
        </h1>
        <p class="text-gray-300 mb-6 max-w-lg">
            Harga termurah, proses otomatis detik-an, dan tersedia 24 jam. Pilih game favoritmu sekarang!
        </p>
        <a href="#games" class="bg-primary hover:bg-indigo-500 text-white font-bold py-3 px-6 rounded-full transition shadow-lg shadow-indigo-500/50">
            Mulai Top Up
        </a>
    </div>
    <!-- Hiasan background abstract -->
    <div class="absolute right-0 top-0 h-full w-1/2 bg-indigo-600 opacity-10 blur-3xl transform rotate-12"></div>
</div>

<!-- LIST GAME SECTION -->
<div id="games">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white border-l-4 border-primary pl-4">Populer Sekarang</h2>
        <!-- Search bar sederhana -->
        <input type="text" placeholder="Cari Game..." class="bg-card border border-gray-700 text-sm rounded-lg px-4 py-2 focus:outline-none focus:border-primary w-1/3 text-white hidden md:block">
    </div>

    <!-- Grid Game Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6">
        @forelse($games as $game)
        <a href="{{ route('order.game', $game->slug) }}" class="group block bg-card rounded-xl overflow-hidden hover:ring-2 hover:ring-primary transition transform hover:-translate-y-1 shadow-lg">
            <!-- Thumbnail Game -->
            <div class="relative aspect-[3/4] overflow-hidden">
                <!-- Jika ada gambar pakai gambar database, jika tidak pakai placeholder -->
                <img src="{{ $game->thumbnail ? asset('storage/'.$game->thumbnail) : 'https://placehold.co/300x400/1e293b/FFF?text='.urlencode($game->name) }}" 
                     alt="{{ $game->name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                
                <!-- Overlay Hitam saat hover -->
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition"></div>
            </div>
            
            <div class="p-4 text-center">
                <h3 class="font-bold text-white truncate group-hover:text-primary transition">{{ $game->name }}</h3>
                
                {{-- LOGIKA: Tampilkan Harga Termurah --}}
                @php
                    // MENGGUNAKAN SAFE NAVIGATION (?->) AGAR TIDAK ERROR JIKA NULL
                    $minPrice = $game->products?->min('price_sell');
                @endphp

                @if($minPrice)
                    <span class="text-xs text-green-400 font-bold block mt-1">
                        Mulai Rp {{ number_format($minPrice, 0, ',', '.') }}
                    </span>
                @else
                    <span class="text-xs text-gray-400 block mt-1">Cek Harga</span>
                @endif
            </div>
        </a>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <p>Belum ada game yang tersedia.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection