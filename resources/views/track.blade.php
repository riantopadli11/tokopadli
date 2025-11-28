@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10">
    
    <!-- Judul & Ikon -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-primary/20 rounded-full mb-4">
            <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-white">Lacak Pesanan</h1>
        <p class="text-gray-400 mt-2">Masukkan kode invoice untuk melihat status top up kamu.</p>
    </div>

    <!-- Card Form -->
    <div class="bg-card border border-gray-700 rounded-2xl p-8 shadow-2xl relative overflow-hidden">
        
        <!-- Hiasan Background -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary blur-[80px] opacity-20 pointer-events-none"></div>

        <form action="{{ route('track.check') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-gray-300 font-bold mb-2 text-sm ml-1">Kode Invoice / Nomor Pesanan</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                        </svg>
                    </div>
                    <input type="text" name="invoice" required placeholder="Contoh: TRX-PADLI-001" 
                           class="w-full pl-10 pr-4 py-4 bg-dark border border-gray-600 rounded-xl text-white focus:ring-2 focus:ring-primary focus:border-primary transition outline-none text-lg font-mono placeholder-gray-600">
                </div>
                @error('invoice')
                    <p class="text-red-500 text-sm mt-2 ml-1 animate-pulse">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-indigo-600 text-white font-bold py-4 rounded-xl text-lg shadow-lg shadow-indigo-500/50 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Cek Sekarang
            </button>
        </form>
    </div>

    <!-- Info Bantuan -->
    <div class="mt-8 text-center text-sm text-gray-500">
        <p>Lupa kode invoice? Cek riwayat browser atau hubungi Admin WhatsApp.</p>
    </div>
</div>
@endsection