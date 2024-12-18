<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ManageTransactionsController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\GuestDashboardController;
use App\Http\Controllers\GuestCheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/guest/dashboard', [GuestDashboardController::class, 'index'])->name('guest.dashboard');
Route::get('/guest/product/{product}/view', [GuestDashboardController::class, 'show'])->name('guest.product.view');

Route::post('/guest/checkout/{product_id}', [GuestCheckoutController::class, 'processCheckout'])->name('guest.checkout.process');
Route::get('/guest/checkout/success', [GuestCheckoutController::class, 'checkoutSuccess'])->name('guest.checkout.success');
Route::get('/guest/checkout/cancel', [GuestCheckoutController::class, 'checkoutCancel'])->name('guest.checkout.cancel');

Route::get('/help', [HelpController::class, 'view'])->name('help.view');
Route::get('/promo', [PromoController::class, 'view'])->name('promo.view');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/product/{product}/view', [DashboardController::class, 'show'])->name('product.view');
    Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    Route::post('/cart/add/{product_id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
    Route::get('/transaction', [TransactionController::class, 'view'])->name('transaction.view');
    Route::post('/transaction/{transaction}/refund', [TransactionController::class, 'requestRefund'])->name('transaction.refund');
    Route::post('/webhook/stripe', [CheckoutController::class, 'handleWebhook']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['admin'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('promotion', PromotionController::class);
    Route::get('/transactions', [ManageTransactionsController::class, 'view'])->name('transactions.view');
    Route::get('/analytics', [AnalyticController::class, 'view'])->name('analytics.view');
    Route::post('/transactions/{transaction}/refund', [ManageTransactionsController::class, 'refund'])->name('transactions.refund');
});

require __DIR__.'/auth.php';
