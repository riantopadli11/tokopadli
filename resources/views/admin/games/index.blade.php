@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Kelola Games</h1>
            <p class="text-gray-400 text-sm">Daftar game yang tampil di halaman depan.</p>
        </div>
        <a href="{{ route('admin.games.create') }}" class="bg-primary hover:bg-indigo-500 text-white px-4 py-2 rounded-lg font-bold text-sm shadow-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Game
        </a>
    </div>

    <!-- Tabel Games -->
    <div class="bg-card rounded-xl border border-gray-700 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-400">
                <thead class="bg-gray-800 text-gray-200 uppercase font-bold text-xs">
                    <tr>
                        <th class="px-6 py-4">Thumbnail</th>
                        <th class="px-6 py-4">Nama Game</th>
                        <th class="px-6 py-4">Slug (URL)</th>
                        <th class="px-6 py-4">Provider</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($games as $game)
                    <tr class="hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4">
                            <img src="{{ $game->thumbnail ? asset('storage/'.$game->thumbnail) : 'https://placehold.co/100x100/1e293b/FFF?text='.substr($game->name, 0, 2) }}" 
                                 class="w-10 h-10 rounded-lg object-cover">
                        </td>
                        <td class="px-6 py-4 font-bold text-white">{{ $game->name }}</td>
                        <td class="px-6 py-4 font-mono text-xs">{{ $game->slug }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-dark border border-gray-600 px-2 py-1 rounded text-xs">
                                {{ $game->target_provider }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($game->is_active)
                                <span class="text-green-400 font-bold text-xs">Aktif</span>
                            @else
                                <span class="text-red-400 font-bold text-xs">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST" onsubmit="return confirm('Hapus game {{ $game->name }}? Produk didalamnya juga akan terhapus!')">
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
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Belum ada game. Klik tombol tambah di atas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection