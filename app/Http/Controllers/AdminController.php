<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Game;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ==========================================
    // 1. DASHBOARD & TRANSAKSI
    // ==========================================

    public function dashboard()
    {
        // Statistik Ringkas
        $total_transaksi = Transaction::count();
        $pendapatan = Transaction::where('payment_status', 'paid')->sum('amount');
        
        // List Transaksi Terbaru (Pagination 10 per halaman)
        $transactions = Transaction::with(['product.game'])->latest()->paginate(10);

        return view('admin.dashboard', compact('transactions', 'total_transaksi', 'pendapatan'));
    }

    // Update Status Transaksi (Payment / Process)
    public function updateTransaction(Request $request, $id)
    {
        $trx = Transaction::findOrFail($id);
        
        // Teknik "Partial Update": Hanya update kolom yang dikirim dari form
        // Ini mencegah kolom lain ter-reset jadi null jika tidak ikut dikirim
        $dataToUpdate = [];
        
        if ($request->has('payment_status')) {
            $dataToUpdate['payment_status'] = $request->payment_status;
        }
        
        if ($request->has('process_status')) {
            $dataToUpdate['process_status'] = $request->process_status;
        }

        $trx->update($dataToUpdate);

        return back()->with('success', 'Status transaksi berhasil diperbarui!');
    }

    // FITUR BARU: Hapus Riwayat Transaksi
    public function destroyTransaction($id)
    {
        $trx = Transaction::findOrFail($id);
        $trx->delete();

        return back()->with('success', 'Riwayat transaksi berhasil dihapus dari database.');
    }


    // ==========================================
    // 2. KELOLA GAMES (CRUD)
    // ==========================================

    public function games()
    {
        $games = Game::latest()->get();
        return view('admin.games.index', compact('games'));
    }

    public function gameCreate()
    {
        return view('admin.games.create');
    }

    public function gameStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:games,slug',
            'target_provider' => 'required',
        ]);

        Game::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'target_provider' => $request->target_provider,
            'thumbnail' => null, // Nanti bisa ditambah fitur upload gambar
            'is_active' => true,
        ]);

        return redirect()->route('admin.games')->with('success', 'Game baru berhasil ditambahkan!');
    }

    public function gameDestroy($id)
    {
        Game::destroy($id);
        return back()->with('success', 'Game berhasil dihapus!');
    }


    // ==========================================
    // 3. KELOLA PRODUK (CRUD)
    // ==========================================

    public function products()
    {
        $products = Product::with('game')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function productCreate()
    {
        $games = Game::all();
        return view('admin.products.create', compact('games'));
    }

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

    public function productDestroy($id)
    {
        Product::destroy($id);
        return back()->with('success', 'Produk berhasil dihapus!');
    }
}