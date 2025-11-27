@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <div class="bg-card border border-gray-700 p-8 rounded-2xl shadow-2xl">
        <h2 class="text-2xl font-bold text-white mb-6 text-center">Login TokoPadli</h2>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-400 mb-2 text-sm">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:ring-primary focus:border-primary">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-400 mb-2 text-sm">Password</label>
                <input type="password" name="password" required 
                       class="w-full bg-dark border border-gray-600 rounded-lg p-3 text-white focus:ring-primary focus:border-primary">
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-indigo-600 text-white font-bold py-3 rounded-lg transition">
                Masuk
            </button>
        </form>

        <p class="mt-6 text-center text-gray-400 text-sm">
            Belum punya akun? <a href="{{ route('register') }}" class="text-primary hover:underline">Daftar disini</a>
        </p>
    </div>
</div>
@endsection