<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/

// 首页直接用 Catalog
Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');

Route::get('/category/{slug}', [CatalogController::class, 'category'])->name('catalog.category');
Route::get('/product/{slug}', [CatalogController::class, 'product'])->name('catalog.product');

// 购物车（不用登录也能先加）
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Auth required
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Profile（Breeze 自带）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Account Dashboard（左侧菜单那个页面）
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'dashboard'])->name('dashboard');
    });

    // Checkout 流程
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // My Orders
    Route::get('/my-orders', [UserOrderController::class, 'index'])
        ->name('user.orders.index');

    Route::get('/my-orders/{order}', [UserOrderController::class, 'show'])
        ->name('user.orders.show');
});

require __DIR__ . '/auth.php';
