<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TokoPadli') }} - Top Up Game Murah</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Config Warna -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4F46E5', // Ungu Utama
                        dark: '#0F172A',    // Background Gelap
                        card: '#1E293B',    // Background Kartu
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #0F172A;
            color: #ffffff;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="bg-card border-b border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- KIRI: Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        <span class="font-bold text-xl tracking-wide text-white">TokoPadli</span>
                    </a>
                </div>

                <!-- KANAN: Menu Desktop -->
                <div class="hidden sm:flex sm:items-center sm:space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        Beranda
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        Cek Transaksi
                    </a>

                    <!-- LOGIKA AUTHENTICATION -->
                    @guest
                        <!-- Jika Belum Login -->
                        <div class="flex gap-2 items-center">
                            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white font-bold text-sm px-3 py-2">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="bg-primary hover:bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                Daftar
                            </a>
                        </div>
                    @else
                        <!-- Jika Sudah Login (Dropdown dengan Klik) -->
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center gap-2 text-white font-bold focus:outline-none py-2 hover:text-gray-300 transition">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 transition-transform" id="user-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <!-- Isi Dropdown (Default Hidden) -->
                            <div id="user-menu-dropdown" class="absolute right-0 mt-2 w-48 bg-card border border-gray-600 rounded-lg shadow-xl py-2 hidden z-50">
                                <div class="px-4 py-2 border-b border-gray-700 text-xs text-gray-400">
                                    Halo, {{ Auth::user()->name }}
                                </div>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">Profile Saya</a>
                                
                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-700 hover:text-red-300">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
                
                <!-- Tombol Mobile Menu (Hamburger) -->
                <div class="flex items-center sm:hidden">
                    <button id="mobile-menu-button" class="text-gray-300 hover:text-white focus:outline-none p-2">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- MOBILE MENU (Hidden by default) -->
        <div id="mobile-menu" class="hidden sm:hidden bg-card border-t border-gray-700">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-base font-medium">Beranda</a>
                <a href="#" class="block text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-base font-medium">Cek Transaksi</a>
                
                @guest
                    <div class="border-t border-gray-700 mt-2 pt-2">
                        <a href="{{ route('login') }}" class="block text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-base font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="block text-primary font-bold hover:bg-gray-700 px-3 py-2 rounded-md text-base">Daftar Akun</a>
                    </div>
                @else
                    <div class="border-t border-gray-700 mt-2 pt-2">
                        <div class="px-3 py-2 text-gray-400 text-sm">Login sebagai: {{ Auth::user()->name }}</div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-left text-red-400 hover:bg-gray-700 px-3 py-2 rounded-md text-base font-medium">Logout</button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="bg-green-600/90 border border-green-500 text-white p-4 rounded-lg mb-6 shadow-lg flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.style.display='none'" class="text-white font-bold">&times;</button>
            </div>
        @endif

        <!-- Notifikasi Error -->
        @if($errors->any())
            <div class="bg-red-600/90 border border-red-500 text-white p-4 rounded-lg mb-6 shadow-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-card border-t border-gray-800 mt-auto">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Info Toko -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-4">TokoPadli</h3>
                    <p class="text-gray-400 text-sm">
                        Platform Top Up Game termurah, tercepat, dan terpercaya di Indonesia. Buka 24 Jam Non-stop.
                    </p>
                </div>
                
                <!-- Link Cepat -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-4">Bantuan</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-primary transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-primary transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-primary transition">Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Pembayaran -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-4">Metode Pembayaran</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-white text-black px-2 py-1 rounded text-xs font-bold">QRIS</span>
                        <span class="bg-white text-black px-2 py-1 rounded text-xs font-bold">DANA</span>
                        <span class="bg-white text-black px-2 py-1 rounded text-xs font-bold">OVO</span>
                        <span class="bg-white text-black px-2 py-1 rounded text-xs font-bold">BCA</span>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-800 pt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} TokoPadli. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- SCRIPT UTILITIES (Mobile Menu & Dropdown) -->
    <script>
        // 1. Logic Mobile Menu
        const mobileBtn = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // 2. Logic User Dropdown (Klik, Bukan Hover)
        const userBtn = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-menu-dropdown');
        const userIcon = document.getElementById('user-menu-icon');

        if (userBtn && userDropdown) {
            // Toggle saat tombol diklik
            userBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // Mencegah event klik tembus ke body
                userDropdown.classList.toggle('hidden');
                
                // Animasi panah sederhana (putar 180 derajat)
                if (!userDropdown.classList.contains('hidden')) {
                    userIcon.style.transform = 'rotate(180deg)';
                } else {
                    userIcon.style.transform = 'rotate(0deg)';
                }
            });

            // Tutup dropdown jika klik di mana saja di luar area dropdown
            document.addEventListener('click', (e) => {
                if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                    if (userIcon) userIcon.style.transform = 'rotate(0deg)';
                }
            });
        }
    </script>
</body>
</html>