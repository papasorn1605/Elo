<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('order.update');
Route::get('orders/{OrderID}/edit', [OrderController::class, 'edit'])->name('order.edit');
Route::resource('orders', OrderController::class)->parameters(['Orders' => 'OrderID']);
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
Route::get('/orders/create', [OrderController::class, 'create'])->name('products.create');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');

require __DIR__.'/auth.php';