@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.games') }}" class="text-gray-400 hover:text-white text-sm flex items-center gap-1">
            &larr; Kembali ke List
        </a>
        <h1 class="text-2xl font-bold text-white mt-2">Tambah Game Baru</h1>
    </div>

    <div class="bg-card border border-gray-700 rounded-xl p-6 shadow-xl">
        <form action="{{ route('admin.games.store') }}" method="POST">
            @csrf
            
            <!-- Nama Game -->
            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Nama Game</label>
                <input type="text" name="name" id="name" placeholder="Contoh: Genshin Impact" required
                       class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:border-primary focus:outline-none"
                       onkeyup="generateSlug()">
            </div>

            <!-- Slug (Otomatis) -->
            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Slug (URL)</label>
                <input type="text" name="slug" id="slug" placeholder="genshin-impact" required readonly
                       class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-gray-400 cursor-not-allowed focus:outline-none">
                <p class="text-xs text-gray-500 mt-1">Slug dibuat otomatis dari nama game.</p>
            </div>

            <!-- Provider Target -->
            <div class="mb-6">
                <label class="block text-gray-400 text-sm mb-2">Target Provider</label>
                <select name="target_provider" class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:border-primary focus:outline-none">
                    <option value="digiflazz">Digiflazz</option>
                    <option value="vipreseller">VipReseller</option>
                    <option value="manual">Manual Process</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-indigo-500 text-white font-bold py-3 rounded-lg transition shadow-lg">
                Simpan Game
            </button>
        </form>
    </div>
</div>

<script>
    // Script Sederhana untuk Auto-Slug
    function generateSlug() {
        let name = document.getElementById('name').value;
        let slug = name.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '') // Hapus karakter aneh
            .replace(/\s+/g, '-')       // Ganti spasi dengan -
            .replace(/-+/g, '-');       // Hapus - ganda
        document.getElementById('slug').value = slug;
    }
</script>
@endsection