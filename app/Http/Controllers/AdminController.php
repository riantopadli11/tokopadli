<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Game;
use App\Models\Product; // <--- WAJIB DITAMBAHKAN AGAR TIDAK ERROR
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Ambil data ringkasan
        $total_transaksi = Transaction::count();
        $pendapatan = Transaction::where('payment_status', 'paid')->sum('amount');
        
        // Ambil list transaksi terbaru
        $transactions = Transaction::latest()->paginate(10);

        return view('admin.dashboard', compact('transactions', 'total_transaksi', 'pendapatan'));
    }

    // Fitur Update Status Transaksi (Penting buat manual process)
    public function updateTransaction(Request $request, $id)
    {
        $trx = Transaction::findOrFail($id);
        
        $trx->update([
            'payment_status' => $request->payment_status,
            'process_status' => $request->process_status
        ]);

        return back()->with('success', 'Status transaksi diperbarui!');
    }

    // --- FITUR KELOLA GAME (Tampil di Halaman Home) ---

    // 1. Tampilkan Daftar Game
    public function games()
    {
        $games = Game::latest()->get();
        return view('admin.games.index', compact('games'));
    }

    // 2. Form Tambah Game
    public function gameCreate()
    {
        return view('admin.games.create');
    }

    // 3. Simpan Game Baru (Otomatis muncul di Home)
    public function gameStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:games,slug', // Slug harus unik (url)
            'target_provider' => 'required', // misal: digiflazz / manual
        ]);

        Game::create([
            'name' => $request->name,
            'slug' => $request->slug, // contoh: mobile-legends
            'target_provider' => $request->target_provider,
            'thumbnail' => null, // sementara null atau bisa diupdate fitur upload
            'is_active' => true,
        ]);

        return redirect()->route('admin.games')->with('success', 'Game berhasil ditambahkan ke Home!');
    }

    // 4. Hapus Game (Hilang dari Home)
    public function gameDestroy($id)
    {
        Game::destroy($id);
        return back()->with('success', 'Game berhasil dihapus dari Home!');
    }

    // --- FITUR KELOLA PRODUK ---

    public function products()
    {
        $products = Product::with('game')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // 2. Tampilkan Form Tambah Produk
    public function productCreate()
    {
        $games = Game::all();
        return view('admin.products.create', compact('games'));
    }

    // 3. Simpan Produk Baru
    public function productStore(Request $request)
    {
        $request->validate([
            'game_id' => 'required',
            'name' => 'required',
            'sku_provider' => 'required',
            'price_provider' => 'required|numeric',
            'price_sell' => 'required|numeric',
        ]);

        Product::create($request->all());
        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan!');
    }

    // 4. Hapus Produk
    public function productDestroy($id)
    {
        Product::destroy($id);
        return back()->with('success', 'Produk berhasil dihapus!');
    }
}