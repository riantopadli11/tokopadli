<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController; // <--- PENTING: Import ini jangan lupa

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

// Fitur Cek Transaksi
Route::get('/track', [OrderController::class, 'track'])->name('track');
Route::post('/track', [OrderController::class, 'checkTransaction'])->name('track.check');


// --- 2. AUTHENTICATION ROUTES ---

// Route untuk Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk User yang Sudah Login (Logout & Profile)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile User
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});


// --- 3. ADMIN ROUTES (Hanya Role Admin) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Update Status Transaksi
    Route::put('/transaction/{id}', [AdminController::class, 'updateTransaction'])->name('admin.transaction.update');

    // Kelola Games (CRUD)
    Route::get('/games', [AdminController::class, 'games'])->name('admin.games');
    Route::get('/games/create', [AdminController::class, 'gameCreate'])->name('admin.games.create');
    Route::post('/games', [AdminController::class, 'gameStore'])->name('admin.games.store');
    Route::delete('/games/{id}', [AdminController::class, 'gameDestroy'])->name('admin.games.destroy');

    // Kelola Produk (CRUD)
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'productCreate'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'productStore'])->name('admin.products.store');
    Route::delete('/products/{id}', [AdminController::class, 'productDestroy'])->name('admin.products.destroy');
});