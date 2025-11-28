@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">
    
    <!-- HEADER GAME -->
    <div class="flex items-center gap-6 mb-8 bg-card p-6 rounded-2xl shadow-lg border border-gray-700">
        <img src="{{ $game->thumbnail ? asset('storage/'.$game->thumbnail) : 'https://placehold.co/200x200/1e293b/FFF?text='.substr($game->name, 0, 2) }}" 
             class="w-24 h-24 rounded-2xl shadow-lg object-cover">
        <div>
            <h1 class="text-3xl font-bold text-white">{{ $game->name }}</h1>
            <p class="text-gray-400 text-sm mt-1">Layanan Aktif 24 Jam • Proses Otomatis</p>
        </div>
    </div>

    <form action="{{ route('checkout') }}" method="POST">
        @csrf
        <input type="hidden" name="game_id" value="{{ $game->id }}">

        <!-- LANGKAH 1: Masukkan ID -->
        <div class="bg-card rounded-2xl p-6 mb-6 border border-gray-700 shadow-lg relative overflow-hidden">
            <div class="absolute top-0 left-0 bg-primary px-4 py-1 rounded-br-xl text-xs font-bold">Langkah 1</div>
            <h2 class="text-xl font-bold mb-4 mt-2">Masukkan User ID</h2>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-2">User ID</label>
                    <input type="text" name="user_id" required placeholder="Contoh: 12345678" 
                           class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:ring-2 focus:ring-primary focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Zone ID <span class="text-xs">(Opsional)</span></label>
                    <input type="text" name="zone_id" placeholder="Contoh: 2024" 
                           class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:ring-2 focus:ring-primary focus:outline-none transition">
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2 italic">*Untuk Mobile Legends, gabungkan User ID dan Zone ID.</p>
        </div>

        <!-- LANGKAH 2: Pilih Nominal -->
        <div class="bg-card rounded-2xl p-6 mb-6 border border-gray-700 shadow-lg relative overflow-hidden">
            <div class="absolute top-0 left-0 bg-primary px-4 py-1 rounded-br-xl text-xs font-bold">Langkah 2</div>
            <h2 class="text-xl font-bold mb-4 mt-2">Pilih Nominal Top Up</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($game->products as $product)
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="product_id" value="{{ $product->id }}" class="peer sr-only" required>
                        
                        <div class="bg-dark border border-gray-600 rounded-xl p-4 hover:border-primary transition-all peer-checked:border-primary peer-checked:bg-indigo-900/30 peer-checked:ring-1 peer-checked:ring-primary">
                            <div class="text-sm font-bold text-gray-200 group-hover:text-white">{{ $product->name }}</div>
                            <div class="mt-2 flex justify-between items-center">
                                <span class="text-primary font-bold">Rp {{ number_format($product->price_sell, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <div class="absolute top-2 right-2 hidden peer-checked:block text-primary">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- LANGKAH 3: Pilih Pembayaran -->
        <div class="bg-card rounded-2xl p-6 mb-6 border border-gray-700 shadow-lg relative overflow-hidden">
            <div class="absolute top-0 left-0 bg-primary px-4 py-1 rounded-br-xl text-xs font-bold">Langkah 3</div>
            <h2 class="text-xl font-bold mb-4 mt-2">Metode Pembayaran</h2>

            <div class="space-y-3">
                <!-- OPSI 1: MANUAL BCA -->
                <label class="flex items-center justify-between p-4 bg-dark border border-gray-600 rounded-xl cursor-pointer hover:border-primary peer-checked:border-primary transition">
                    <div class="flex items-center gap-4">
                        <input type="radio" name="payment_method" value="MANUAL_BCA" class="text-primary focus:ring-primary" required>
                        <div>
                            <span class="font-bold block">Transfer BCA (Manual)</span>
                            <span class="text-xs text-gray-400">Cek Otomatis 1-5 Menit</span>
                        </div>
                    </div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/2560px-Bank_Central_Asia.svg.png" class="h-4 bg-white p-0.5 rounded">
                </label>

                <!-- OPSI 2: MANUAL DANA -->
                <label class="flex items-center justify-between p-4 bg-dark border border-gray-600 rounded-xl cursor-pointer hover:border-primary transition">
                    <div class="flex items-center gap-4">
                        <input type="radio" name="payment_method" value="MANUAL_DANA" class="text-primary focus:ring-primary">
                        <div>
                            <span class="font-bold block">DANA (Manual)</span>
                            <span class="text-xs text-gray-400">Kirim Bukti ke WA</span>
                        </div>
                    </div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" class="h-4 bg-white p-0.5 rounded">
                </label>

                <!-- OPSI 3: QRIS (Tripay - Nonaktif Sementara) -->
                <label class="flex items-center justify-between p-4 bg-dark border border-gray-600 rounded-xl cursor-not-allowed opacity-50">
                    <div class="flex items-center gap-4">
                        <input type="radio" name="payment_method" value="QRIS" class="text-primary focus:ring-primary" disabled>
                        <div>
                            <span class="font-bold block text-gray-500">QRIS Otomatis (Maintenance)</span>
                            <span class="text-xs text-gray-500">Belum tersedia</span>
                        </div>
                    </div>
                    <div class="text-xs bg-gray-600 text-gray-300 px-2 py-1 font-bold rounded">QRIS</div>
                </label>
            </div>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="w-full bg-primary hover:bg-indigo-600 text-white font-bold py-4 rounded-xl text-lg shadow-lg shadow-indigo-500/50 transition transform hover:-translate-y-1">
            Beli Sekarang
        </button>
    </form>

</div>
@endsection