<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (): void {
    Route::post('register', [AuthController::class, 'register'])->middleware('throttle:10,1');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->middleware('throttle:5,1');
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::put('profile', [AuthController::class, 'updateProfile']);
    });
});

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);
Route::get('categories', [CategoryController::class, 'index']);

Route::prefix('payments')->group(function (): void {
    Route::post('stripe/webhook', [PaymentController::class, 'handleStripeWebhook']);
    Route::get('paypal/success', [PaymentController::class, 'paypalSuccess']);
    Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel']);
});

Route::middleware('auth:sanctum')->group(function (): void {
    Route::prefix('cart')->group(function (): void {
        Route::get('/', [CartController::class, 'show']);
        Route::post('items', [CartController::class, 'addItem']);
        Route::put('items/{item}', [CartController::class, 'updateItem']);
        Route::delete('items/{item}', [CartController::class, 'removeItem']);
        Route::delete('/', [CartController::class, 'clear']);
    });

    Route::prefix('wishlist')->group(function (): void {
        Route::get('/', [WishlistController::class, 'index']);
        Route::post('{product}', [WishlistController::class, 'store']);
        Route::delete('{product}', [WishlistController::class, 'destroy']);
    });

    Route::post('checkout/summary', [CheckoutController::class, 'summary'])->middleware('throttle:15,1');
    Route::post('checkout/place-order', [CheckoutController::class, 'placeOrder'])->middleware('throttle:10,1');

    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{order}', [OrderController::class, 'show']);
    Route::post('orders/{order}/cancel', [OrderController::class, 'cancel']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function (): void {
    Route::get('dashboard', AdminDashboardController::class);
    Route::apiResource('products', AdminProductController::class);
    Route::apiResource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
});
