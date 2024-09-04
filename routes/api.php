<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TokenAuthMiddleware;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProductDetailController;
use App\Http\Controllers\Api\V1\ProductSliderController;
use App\Http\Controllers\Api\V1\CustomerProfileController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\SSLCommerzController;
use App\Http\Controllers\Api\V1\WishlistController;


// Auth Routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'userLogin']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
});


// Public Routes
Route::apiResource('brands', BrandController::class)->only(['index']);
Route::apiResource('categories', CategoryController::class)->only(['index']);
Route::apiResource('products', ProductController::class)->only(['index', 'show']);
Route::apiResource('product-details', ProductDetailController::class)->only(['index', 'show']);
Route::apiResource('product-sliders', ProductSliderController::class)->only(['index']);


Route::group(['middleware' => TokenAuthMiddleware::class], function () {

    // Auth Routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('logout', [AuthController::class, 'userLogout']);
    });

    // User Routes
    Route::group(['prefix' => 'user'], function () {
        Route::apiResource('profiles', CustomerProfileController::class)->only(['store', 'show', 'update']);
    });

    // Customer Routes
    Route::apiResource('carts', CartController::class)->only(['index', 'store', 'destroy']);
    Route::apiResource('wishlists', WishlistController::class)->only(['index', 'store', 'destroy']);

    // Checkout Routes
    Route::apiResource('invoices', InvoiceController::class)->only(['index', 'store', 'show']);

    // Admin Routes
    Route::group(['prefix' => 'admin'], function () {
        Route::apiResource('brands', BrandController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('product-details', ProductDetailController::class);
        Route::apiResource('product-sliders', ProductSliderController::class);

        // SSLCommerz Payment Gateway info store route
        Route::post('/sslcommerz-store-credentials', [SSLCommerzController::class, 'storeCredentials']);
    });
});



// SSLCommerz Payment Gateway
Route::post('/ssl-payment-ipn', [SSLCommerzController::class, 'paymentIpn']);