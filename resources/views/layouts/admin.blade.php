<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - {{ config('app.name', 'TokoPadli') }}</title>

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
                        primary: '#6366f1', // Indigo lebih terang untuk Admin
                        dark: '#0f172a',    // Background Gelap
                        card: '#1e293b',    // Background Kartu
                        danger: '#ef4444',  // Merah untuk aksi berbahaya
                        success: '#22c55e', // Hijau untuk sukses
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #0f172a;
            color: #ffffff;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col">

    <!-- NAVBAR ADMIN -->
    <nav class="bg-card border-b border-gray-700 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- KIRI: Logo & Menu Utama -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                        <span class="bg-primary text-white font-bold px-2 py-1 rounded text-xs">ADMIN</span>
                        <span class="font-bold text-xl tracking-wide text-white">Panel</span>
                    </a>

                    <!-- Desktop Menu -->
                    <div class="hidden sm:flex sm:space-x-4">
                        <!-- Menu Dashboard (Aktif jika rute bernama admin.dashboard) -->
                        <a href="{{ route('admin.dashboard') }}" 
                           class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium transition">
                            Dashboard
                        </a>
                        
                        <!-- Menu Kelola Games (Placeholder) -->
                        <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium transition">
                            Kelola Games
                        </a>

                        <!-- Menu Kelola Produk (Aktif jika rute diawali admin.products) -->
                        <a href="{{ route('admin.products') }}" 
                           class="{{ request()->routeIs('admin.products*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium transition">
                            Kelola Produk
                        </a>
                    </div>
                </div>

                <!-- KANAN: User Profile & Back to Site -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="hidden sm:flex items-center gap-2 text-sm text-gray-400 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Lihat Website
                    </a>

                    <div class="relative ml-3">
                        <div class="flex items-center gap-3">
                            <div class="text-right hidden sm:block">
                                <div class="text-sm font-bold text-white">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500">Administrator</div>
                            </div>
                            
                            <!-- Logout Button -->
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-danger hover:bg-red-600 text-white px-3 py-2 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <!-- Notifikasi -->
        @if(session('success'))
            <div class="bg-green-600/20 border border-green-500 text-green-200 p-4 rounded-lg mb-6 shadow-lg flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-600/20 border border-red-500 text-red-200 p-4 rounded-lg mb-6 shadow-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER SIMPLE -->
    <footer class="bg-card border-t border-gray-800 mt-auto py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} TokoPadli Admin System. v1.0
        </div>
    </footer>

</body>
</html>