@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Kelola Produk</h1>
            <p class="text-gray-400 text-sm">Daftar item diamond yang dijual.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-primary hover:bg-indigo-500 text-white px-4 py-2 rounded-lg font-bold text-sm shadow-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Produk
        </a>
    </div>

    <!-- Tabel Produk -->
    <div class="bg-card rounded-xl border border-gray-700 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-400">
                <thead class="bg-gray-800 text-gray-200 uppercase font-bold text-xs">
                    <tr>
                        <th class="px-6 py-4">Game</th>
                        <th class="px-6 py-4">Nama Produk</th>
                        <th class="px-6 py-4">SKU (Provider)</th>
                        <th class="px-6 py-4">Harga Modal</th>
                        <th class="px-6 py-4">Harga Jual</th>
                        <th class="px-6 py-4 text-center">Profit</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4 font-bold text-white">{{ $product->game->name }}</td>
                        <td class="px-6 py-4">{{ $product->name }}</td>
                        <td class="px-6 py-4 font-mono text-xs bg-dark p-1 rounded inline-block border border-gray-600">
                            {{ $product->sku_provider }}
                        </td>
                        <td class="px-6 py-4">Rp {{ number_format($product->price_provider) }}</td>
                        <td class="px-6 py-4 text-white font-bold">Rp {{ number_format($product->price_sell) }}</td>
                        <td class="px-6 py-4 text-center text-green-400">
                            +Rp {{ number_format($product->price_sell - $product->price_provider) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            Belum ada produk. Klik tombol tambah di atas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-700">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection