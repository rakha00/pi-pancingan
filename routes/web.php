<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{product:slug}', [HomeController::class, 'show'])->name('product.show');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/confirm', [App\Http\Controllers\OrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/orders/{order}/report', [App\Http\Controllers\OrderController::class, 'report'])->name('orders.report');

    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/messages', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
    Route::delete('/chat/clear', [App\Http\Controllers\ChatController::class, 'clearHistory'])->name('chat.clear');
});

Route::post('/midtrans/callback', [CheckoutController::class, 'callback'])->name('midtrans.callback');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);

    Route::get('/chats', [App\Http\Controllers\Admin\ChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{customer}', [App\Http\Controllers\Admin\ChatController::class, 'show'])->name('chats.show');
    Route::post('/chats/{customer}', [App\Http\Controllers\Admin\ChatController::class, 'store'])->name('chats.store');
    Route::get('/chats/{customer}/messages', [App\Http\Controllers\Admin\ChatController::class, 'getMessages'])->name('chats.messages');
});
