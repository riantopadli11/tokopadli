@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- Header Dashboard -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Dashboard Admin</h1>
        <p class="text-gray-400 text-sm mt-1">Pantau performa penjualan dan update status transaksi.</p>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-card p-6 rounded-xl border border-gray-700 shadow-lg flex justify-between items-center">
            <div>
                <h3 class="text-gray-400 text-sm font-medium">Total Transaksi</h3>
                <p class="text-3xl font-bold text-white mt-1">{{ $total_transaksi }}</p>
            </div>
            <div class="bg-blue-600/20 p-3 rounded-lg text-blue-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-card p-6 rounded-xl border border-gray-700 shadow-lg flex justify-between items-center">
            <div>
                <h3 class="text-gray-400 text-sm font-medium">Pendapatan (Paid)</h3>
                <p class="text-3xl font-bold text-green-400 mt-1">Rp {{ number_format($pendapatan, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-600/20 p-3 rounded-lg text-green-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-card p-6 rounded-xl border border-gray-700 shadow-lg flex justify-between items-center">
            <div>
                <h3 class="text-gray-400 text-sm font-medium">Status Server</h3>
                <p class="text-3xl font-bold text-primary mt-1">Online</p>
            </div>
            <div class="bg-indigo-600/20 p-3 rounded-lg text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="bg-card rounded-xl border border-gray-700 shadow-xl overflow-hidden">
        <div class="p-6 border-b border-gray-700">
            <h2 class="text-xl font-bold text-white">Riwayat Transaksi Terbaru</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-400">
                <thead class="bg-gray-800 text-gray-200 uppercase font-bold text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Invoice</th>
                        <th class="px-6 py-4">User Game</th>
                        <th class="px-6 py-4">Item</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4 text-center">Payment</th>
                        <th class="px-6 py-4 text-center">Process</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($transactions as $trx)
                    <tr class="hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4 font-mono font-bold text-white">{{ $trx->invoice_code }}</td>
                        <td class="px-6 py-4">
                            <div class="text-white font-bold">{{ $trx->user_game_id }}</div>
                            <div class="text-xs">{{ $trx->zone_id }}</div>
                        </td>
                        <td class="px-6 py-4">{{ $trx->product->name }}</td>
                        <td class="px-6 py-4 text-white font-medium">Rp {{ number_format($trx->amount) }}</td>
                        
                        <!-- Form Update Status -->
                        <form action="{{ route('admin.transaction.update', $trx->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <td class="px-6 py-4 text-center">
                                <select name="payment_status" onchange="this.form.submit()" 
                                        class="bg-dark border rounded px-2 py-1 text-xs focus:outline-none cursor-pointer font-bold
                                        {{ $trx->payment_status == 'paid' ? 'border-green-500 text-green-400' : 'border-red-500 text-red-400' }}">
                                    <option value="unpaid" {{ $trx->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="paid" {{ $trx->payment_status == 'paid' ? 'selected' : '' }}>PAID</option>
                                    <option value="expired" {{ $trx->payment_status == 'expired' ? 'selected' : '' }}>Expired</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <select name="process_status" onchange="this.form.submit()" 
                                        class="bg-dark border rounded px-2 py-1 text-xs focus:outline-none cursor-pointer font-bold
                                        {{ $trx->process_status == 'success' ? 'border-green-500 text-green-400' : 
                                           ($trx->process_status == 'failed' ? 'border-red-500 text-red-400' : 'border-yellow-500 text-yellow-400') }}">
                                    <option value="pending" {{ $trx->process_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $trx->process_status == 'processing' ? 'selected' : '' }}>Proses</option>
                                    <option value="success" {{ $trx->process_status == 'success' ? 'selected' : '' }}>Success</option>
                                    <option value="failed" {{ $trx->process_status == 'failed' ? 'selected' : '' }}>Gagal</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button type="submit" class="text-primary hover:text-white text-xs underline">Simpan</button>
                            </td>
                        </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-700 bg-gray-800/50">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection