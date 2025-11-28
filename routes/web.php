<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. PUBLIC ROUTES (Bisa diakses siapa saja) ---
Route::get('/', [OrderController::class, 'index'])->name('home');
Route::get('/order/{slug}', [OrderController::class, 'show'])->name('order.game');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout');
Route::get('/invoice/{code}', [OrderController::class, 'invoice'])->name('invoice');
Route::delete('/invoice/{code}', [OrderController::class, 'destroy'])->name('invoice.destroy'); // User Batal Pesanan

// Fitur Cek Transaksi
Route::get('/track', [OrderController::class, 'track'])->name('track');
Route::post('/track', [OrderController::class, 'checkTransaction'])->name('track.check');


// --- 2. AUTHENTICATION ROUTES ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});


// --- 3. ADMIN ROUTES (Hanya Role Admin) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Dashboard & Transaction Management
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Update Status Transaksi
    Route::put('/transaction/{id}', [AdminController::class, 'updateTransaction'])->name('admin.transaction.update');
    
    // FITUR BARU: Hapus Transaksi (Admin)
    // Route ini yang dicari oleh tombol "Hapus" di Dashboard Admin
    Route::delete('/transaction/{id}', [AdminController::class, 'destroyTransaction'])->name('admin.transaction.destroy');

    // Kelola Games
    Route::get('/games', [AdminController::class, 'games'])->name('admin.games');
    Route::get('/games/create', [AdminController::class, 'gameCreate'])->name('admin.games.create');
    Route::post('/games', [AdminController::class, 'gameStore'])->name('admin.games.store');
    Route::delete('/games/{id}', [AdminController::class, 'gameDestroy'])->name('admin.games.destroy');

    // Kelola Produk
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'productCreate'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'productStore'])->name('admin.products.store');
    Route::delete('/products/{id}', [AdminController::class, 'productDestroy'])->name('admin.products.destroy');
});