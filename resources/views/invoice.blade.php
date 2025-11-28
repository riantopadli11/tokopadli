@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10">
    <div class="bg-card border border-gray-700 rounded-2xl p-8 shadow-2xl relative overflow-hidden">
        
        <!-- Status Badge -->
        <div class="absolute top-0 right-0 px-6 py-2 rounded-bl-xl font-bold text-sm text-white
            {{ $trx->payment_status == 'paid' ? 'bg-green-600' : ($trx->payment_status == 'expired' ? 'bg-red-600' : 'bg-yellow-600') }}">
            {{ strtoupper($trx->payment_status) }}
        </div>

        <!-- =========================== -->
        <!-- LOGIKA TAMPILAN UTAMA -->
        <!-- =========================== -->

        @if($trx->payment_status == 'paid')
            <!-- 1. JIKA SUDAH BAYAR (SUKSES) -->
            <div class="text-center mb-8 py-6">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-500/20 rounded-full mb-6 animate-bounce">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-white mb-2 tracking-tight">Pembayaran Berhasil!</h1>
                <p class="text-gray-400">Terima kasih! Diamond kamu sedang diproses otomatis.</p>
            </div>

        @elseif($trx->payment_status == 'expired')
            <!-- 2. JIKA KADALUARSA -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-red-500 mb-2">Invoice Kadaluarsa</h1>
                <p class="text-gray-400">Silakan lakukan pemesanan ulang.</p>
            </div>

        @else
            <!-- 3. JIKA BELUM BAYAR (MENUNGGU) -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-white mb-2">Selesaikan Pembayaran</h1>
                
                @if(str_contains($trx->payment_method, 'MANUAL'))
                    <p class="text-gray-400 text-sm">Transfer sesuai nominal ke rekening di bawah ini.</p>
                @else
                    <p class="text-gray-400 text-sm">Selesaikan pembayaran melalui metode yang dipilih.</p>
                @endif
            </div>

            <!-- A. TAMPILAN TRANSFER MANUAL (BCA/DANA) -->
            @if(str_contains($trx->payment_method, 'MANUAL'))
                <div class="bg-gray-800 p-6 rounded-xl border border-gray-600 mb-6 text-center shadow-inner">
                    <p class="text-gray-400 text-sm mb-4">Silakan transfer ke:</p>
                    
                    @if($trx->payment_method == 'MANUAL_BCA')
                        <div class="flex items-center justify-center gap-2 mb-2">
                            <div class="bg-white p-1 rounded h-8 flex items-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/2560px-Bank_Central_Asia.svg.png" class="h-4">
                            </div>
                            <span class="font-bold text-xl text-white">Bank BCA</span>
                        </div>
                        <div class="text-3xl font-mono font-bold text-primary select-all mb-1 tracking-wider">1234-5678-90</div>
                        <div class="text-sm text-gray-400">a.n Admin TokoPadli</div>
                    
                    @elseif($trx->payment_method == 'MANUAL_DANA')
                        <div class="flex items-center justify-center gap-2 mb-2">
                            <div class="bg-white p-1 rounded h-8 flex items-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" class="h-4">
                            </div>
                            <span class="font-bold text-xl text-white">DANA</span>
                        </div>
                        <div class="text-3xl font-mono font-bold text-primary select-all mb-1 tracking-wider">0812-3456-7890</div>
                        <div class="text-sm text-gray-400">a.n Admin TokoPadli</div>
                    @endif

                    <div class="mt-6 pt-4 border-t border-gray-700">
                        <div class="bg-yellow-900/30 border border-yellow-700 p-3 rounded-lg mb-4">
                            <p class="text-yellow-500 text-xs font-bold">PENTING!</p>
                            <p class="text-yellow-200 text-xs">Pastikan transfer sesuai nominal hingga 3 digit terakhir.</p>
                        </div>
                        
                        <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20sudah%20transfer%20untuk%20invoice%20{{ $trx->invoice_code }}%20sebesar%20Rp%20{{ number_format($trx->amount, 0, ',', '.') }}" 
                           target="_blank"
                           class="inline-flex items-center justify-center w-full gap-2 bg-green-600 hover:bg-green-500 text-white px-4 py-3 rounded-xl font-bold transition shadow-lg hover:shadow-green-500/20">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            Konfirmasi via WhatsApp
                        </a>
                    </div>
                </div>

            <!-- B. TAMPILAN QRIS (Tripay/Otomatis) -->
            @elseif(($trx->payment_method == 'QRIS' || $trx->payment_method == 'QRIS2') && $trx->qr_string)
                <div class="bg-white p-4 rounded-xl mx-auto w-64 h-64 mb-6 shadow-lg flex items-center justify-center relative group">
                    <img src="{{ $trx->qr_string }}" alt="Scan QRIS" class="w-full h-full object-contain">
                </div>
                <p class="text-center text-xs text-gray-500 mb-6">Scan menggunakan GoPay, OVO, Dana, atau Mobile Banking.</p>

            <!-- C. TAMPILAN LINK (VA/Alfamart Otomatis) -->
            @elseif($trx->payment_url)
                <div class="text-center mb-6">
                    <a href="{{ $trx->payment_url }}" target="_blank" class="inline-flex items-center gap-2 bg-primary hover:bg-indigo-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Bayar Sekarang
                    </a>
                    <p class="text-xs text-gray-500 mt-3">Klik tombol untuk melihat kode pembayaran.</p>
                </div>

            <!-- D. FALLBACK JIKA ERROR -->
            @else
                <div class="text-center mb-6 p-4 bg-yellow-900/30 border border-yellow-700 rounded-lg">
                    <p class="text-yellow-500 text-sm">Menunggu data pembayaran...</p>
                </div>
            @endif

        @endif

        <!-- =========================== -->
        <!-- DETAIL TRANSAKSI (UMUM) -->
        <!-- =========================== -->
        <div class="space-y-4 border-t border-gray-700 pt-6">
            <div class="flex justify-between text-gray-300">
                <span>Invoice</span>
                <span class="font-mono text-white select-all">{{ $trx->invoice_code }}</span>
            </div>
            <div class="flex justify-between text-gray-300">
                <span>Game / Item</span>
                <span class="font-bold text-white">{{ $trx->product->game->name }} - {{ $trx->product->name }}</span>
            </div>
            <div class="flex justify-between text-gray-300">
                <span>User ID</span>
                <span class="font-bold text-white">{{ $trx->user_game_id }} {{ $trx->zone_id ? '('.$trx->zone_id.')' : '' }}</span>
            </div>
            <div class="flex justify-between text-gray-300">
                <span>Metode Pembayaran</span>
                <span class="font-bold text-white bg-gray-700 px-2 py-0.5 rounded text-xs">{{ $trx->payment_method }}</span>
            </div>
            
            <div class="flex justify-between text-xl font-bold text-primary border-t border-gray-700 pt-4 mt-4">
                <span>Total Bayar</span>
                <span>Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-2 gap-4">
            <a href="{{ route('home') }}" class="block w-full text-center bg-gray-700 hover:bg-gray-600 text-white py-3 rounded-xl transition">
                {{ $trx->payment_status == 'paid' ? 'Beli Lagi' : 'Ke Beranda' }}
            </a>
            
            @if($trx->payment_status == 'unpaid')
                <button onclick="window.location.reload()" class="block w-full text-center bg-gray-600 hover:bg-gray-500 text-white py-3 rounded-xl transition font-bold flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Refresh
                </button>
            @else
                 <button onclick="window.print()" class="block w-full text-center bg-primary hover:bg-indigo-600 text-white py-3 rounded-xl transition">
                    Simpan Bukti
                </button>
            @endif
        </div>

        <!-- =========================== -->
        <!-- FITUR HAPUS RIWAYAT -->
        <!-- =========================== -->
        @if($trx->payment_status == 'unpaid' || $trx->payment_status == 'expired')
            <div class="mt-6 pt-4 border-t border-gray-700">
                <form action="{{ route('invoice.destroy', $trx->invoice_code) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Data akan dihapus.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="block w-full text-center text-red-500 hover:text-red-400 text-sm font-medium transition flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Batalkan & Hapus Pesanan
                    </button>
                </form>
            </div>
        @endif

    </div>
</div>
@endsection