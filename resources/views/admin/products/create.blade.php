@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.products') }}" class="text-gray-400 hover:text-white text-sm flex items-center gap-1">
            &larr; Kembali ke List
        </a>
        <h1 class="text-2xl font-bold text-white mt-2">Tambah Produk Baru</h1>
    </div>

    <div class="bg-card border border-gray-700 rounded-xl p-6 shadow-xl">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            
            <!-- Pilih Game -->
            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Pilih Game</label>
                <select name="game_id" class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:border-primary focus:outline-none">
                    @foreach($games as $game)
                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Nama Produk -->
            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Nama Produk (Display)</label>
                <input type="text" name="name" placeholder="Contoh: 86 Diamonds" required
                       class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:border-primary focus:outline-none">
            </div>

            <!-- SKU Provider -->
            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">SKU / Kode Provider</label>
                <input type="text" name="sku_provider" placeholder="Contoh: ML86" required
                       class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:border-primary focus:outline-none">
                <p class="text-xs text-gray-500 mt-1">Kode ini harus sama persis dengan kode di Digiflazz/VipReseller.</p>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <!-- Harga Modal -->
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Harga Modal (Rp)</label>
                    <input type="number" name="price_provider" placeholder="19000" required
                           class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:border-primary focus:outline-none">
                </div>
                <!-- Harga Jual -->
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Harga Jual (Rp)</label>
                    <input type="number" name="price_sell" placeholder="23000" required
                           class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:border-primary focus:outline-none">
                </div>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-indigo-500 text-white font-bold py-3 rounded-lg transition shadow-lg">
                Simpan Produk
            </button>
        </form>
    </div>
</div>
@endsection