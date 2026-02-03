<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Redirect setelah login berdasarkan role
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('customer.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- GROUP ROUTE ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');    
    
    // Tambahkan ini: Route untuk Manajemen Menu
    Route::resource('admin/menus', \App\Http\Controllers\MenuController::class)->names([
        'index' => 'admin.menus.index',
        'create' => 'admin.menus.create',
        'store' => 'admin.menus.store',
        'edit' => 'admin.menus.edit',
        'update' => 'admin.menus.update',
        'destroy' => 'admin.menus.destroy',
    ]);

    // Manajemen Pesanan
    Route::get('/admin/orders', [App\Http\Controllers\AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{id}', [App\Http\Controllers\AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/admin/orders/{id}/confirm', [App\Http\Controllers\AdminOrderController::class, 'confirmPayment'])->name('admin.orders.confirm');
    Route::patch('/admin/orders/{id}/status', [App\Http\Controllers\AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');
    Route::post('/admin/orders/{id}/complete', [App\Http\Controllers\AdminOrderController::class, 'completeOrder'])->name('admin.orders.complete');

    // Laporan
    Route::get('/admin/reports', [App\Http\Controllers\AdminReportController::class, 'index'])->name('admin.reports.index');
});

// --- GROUP ROUTE CUSTOMER ---
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');
});

// --- ROUTE PROFILE (Bawaan Breeze) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- GROUP ROUTE CUSTOMER ---
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', [App\Http\Controllers\OrderController::class, 'index'])->name('customer.dashboard');
    
    // Update Quantity
    Route::patch('update-cart', [App\Http\Controllers\OrderController::class, 'updateCart'])->name('update_cart');

    // Keranjang
    Route::get('cart', [App\Http\Controllers\OrderController::class, 'cart'])->name('cart');
    Route::get('add-to-cart/{id}', [App\Http\Controllers\OrderController::class, 'addToCart'])->name('add_to_cart');
    Route::delete('remove-from-cart', [App\Http\Controllers\OrderController::class, 'removeCart'])->name('remove_from_cart');
    
    // Checkout
    Route::get('checkout', [App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
    Route::post('place-order', [App\Http\Controllers\OrderController::class, 'storeOrder'])->name('place_order');
    
    // Riwayat
    Route::get('my-orders', [App\Http\Controllers\OrderController::class, 'history'])->name('customer.orders.index');
});

require __DIR__.'/auth.php';