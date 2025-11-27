<?php

use App\Http\Controllers\OrderController;

Route::get('/', [OrderController::class, 'index'])->name('home');
Route::get('/order/{slug}', [OrderController::class, 'show'])->name('order.game');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout');
Route::get('/invoice/{code}', [OrderController::class, 'invoice'])->name('invoice');

use App\Http\Controllers\AuthController;

// Route untuk Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk Logout (Hanya bisa diakses jika sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Update Transaksi
    Route::put('/transaction/{id}', [AdminController::class, 'updateTransaction'])->name('admin.transaction.update');
        // PRODUK ROUTES
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'productCreate'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'productStore'])->name('admin.products.store');
    Route::delete('/products/{id}', [AdminController::class, 'productDestroy'])->name('admin.products.destroy');


    // Nanti bisa tambah route manage game disini
});

