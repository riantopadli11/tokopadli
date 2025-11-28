@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <!-- Header -->
    <div class="mb-8 flex items-center gap-4">
        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center text-2xl font-bold text-white shadow-lg">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <div>
            <h1 class="text-3xl font-bold text-white">Pengaturan Akun</h1>
            <p class="text-gray-400">Kelola informasi profil dan keamanan akunmu.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- CARD 1: EDIT PROFIL -->
        <div class="bg-card border border-gray-700 rounded-2xl p-6 shadow-xl">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Data Diri
            </h2>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-400 text-sm mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                           class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:border-primary focus:outline-none transition">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-400 text-sm mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                           class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:border-primary focus:outline-none transition">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-primary hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg transition shadow-lg">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- CARD 2: GANTI PASSWORD -->
        <div class="bg-card border border-gray-700 rounded-2xl p-6 shadow-xl">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Ganti Password
            </h2>

            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-400 text-sm mb-2">Password Saat Ini</label>
                    <input type="password" name="current_password" required
                           class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:border-red-500 focus:outline-none transition">
                    @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-400 text-sm mb-2">Password Baru</label>
                    <input type="password" name="password" required
                           class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:border-red-500 focus:outline-none transition">
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-400 text-sm mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:border-red-500 focus:outline-none transition">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-gray-700 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-lg transition">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- Info Tambahan -->
    <div class="mt-8 text-center text-sm text-gray-500">
        <p>Bergabung sejak {{ Auth::user()->created_at->format('d M Y') }} • Role: <span class="uppercase font-bold text-gray-300">{{ Auth::user()->role }}</span></p>
    </div>
</div>
@endsection