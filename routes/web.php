<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/products', [PublicController::class, 'products'])->name('products.index');
Route::get('/products/{product:slug}', [PublicController::class, 'product'])->name('products.show');
Route::get('/announcements', [PublicController::class, 'announcements'])->name('announcements.index');
Route::get('/announcements/{announcement:slug}', [PublicController::class, 'announcement'])->name('announcements.show');
Route::get('/faq', [PublicController::class, 'faq'])->name('faq');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [DashboardController::class, 'order'])->name('orders.show');
    Route::get('/receipts/{order}', [DashboardController::class, 'receipt'])->name('receipts.show');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{key}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{key}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout', [CartController::class, 'place'])->name('checkout.place');
    Route::post('/orders/{order}/payments', [PaymentController::class, 'upload'])->name('payments.upload');
});

Route::middleware(['auth', 'role:admin,super_admin,payments_admin,inventory_admin,operations_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::patch('/products/{product}/toggle', [AdminController::class, 'toggleProduct'])->name('products.toggle');

    Route::get('/batches', [AdminController::class, 'batches'])->name('batches');
    Route::post('/batches', [AdminController::class, 'storeBatch'])->name('batches.store');
    Route::patch('/batches/{batch}/status', [AdminController::class, 'updateBatchStatus'])->name('batches.status');

    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');

    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
    Route::patch('/payments/{payment}/verify', [AdminController::class, 'verifyPayment'])->name('payments.verify');
    Route::patch('/payments/{payment}/reject', [AdminController::class, 'rejectPayment'])->name('payments.reject');

    Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements');
    Route::post('/announcements', [AdminController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::patch('/announcements/{announcement}/toggle', [AdminController::class, 'toggleAnnouncement'])->name('announcements.toggle');

    Route::get('/voting', [AdminController::class, 'voting'])->name('voting');
    Route::post('/voting', [AdminController::class, 'storeVote'])->name('voting.store');
    Route::post('/voting/{vote}/options', [AdminController::class, 'storeVoteOption'])->name('voting.options.store');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
});
