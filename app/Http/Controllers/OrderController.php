<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // 1. Halaman Depan (Menampilkan daftar game)
    public function index()
    {
        // Ambil semua game yang statusnya aktif (is_active = true)
        // Urutkan dari yang terbaru (latest)
        $games = Game::where('is_active', true)->latest()->get();
        
        // Kirim variable $games ke view 'home'
        // Ini yang membuat @forelse($games as $game) di home.blade.php bekerja
        return view('home', compact('games'));
    }

    // 2. Halaman Order (Detail Game)
    public function show($slug)
    {
        // Cari game berdasarkan slug (contoh: mobile-legends)
        // Jika tidak ketemu, otomatis error 404 (firstOrFail)
        $game = Game::where('slug', $slug)->firstOrFail();
        
        return view('order', compact('game'));
    }

    // 3. Proses Checkout (Simpan Transaksi)
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'product_id' => 'required|exists:products,id',
            'payment_method' => 'required'
        ]);

        $product = Product::find($request->product_id);
        
        // Buat Invoice Code (TRX-XXXXXX)
        $invoice = 'TRX-' . strtoupper(Str::random(6));

        $trx = Transaction::create([
            'invoice_code' => $invoice,
            'product_id' => $product->id,
            'user_game_id' => $request->user_id,
            'zone_id' => $request->zone_id,
            'amount' => $product->price_sell,
            'payment_method' => $request->payment_method,
            'payment_status' => 'unpaid'
        ]);
        
        return redirect()->route('invoice', $trx->invoice_code);
    }

    // 4. Halaman Invoice
    public function invoice($code)
    {
        $trx = Transaction::with(['product.game'])->where('invoice_code', $code)->firstOrFail();
        return view('invoice', compact('trx'));
    }
        // 5. Halaman Cari Transaksi (Form)
    public function track()
    {
        return view('track');
    }

    // 6. Proses Pencarian Transaksi
    public function checkTransaction(Request $request)
    {
        $request->validate([
            'invoice' => 'required|string'
        ]);

        // Cari transaksi berdasarkan invoice code
        $trx = Transaction::where('invoice_code', $request->invoice)->first();

        if ($trx) {
            // Jika ketemu, lempar ke halaman invoice detail
            return redirect()->route('invoice', $trx->invoice_code);
        }

        // Jika tidak ketemu, kembalikan dengan pesan error
        return back()->withErrors(['invoice' => 'Invoice tidak ditemukan! Cek kembali kode pesananmu.']);
    }
}