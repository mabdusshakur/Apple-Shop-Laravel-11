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
use App\Http\Controllers\Api\V1\ProductReviewController;
use App\Http\Controllers\Api\V1\SSLCommerzController;
use App\Http\Controllers\Api\V1\WishlistController;
use App\Http\Middleware\TokenAdminAuthMiddleware;

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
Route::apiResource('product-reviews', ProductReviewController::class)->only(['index']);


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
    Route::apiResource('reviews', ProductReviewController::class)->only(['index', 'store', 'update', 'destroy']);

    // Checkout Routes
    Route::apiResource('invoices', InvoiceController::class)->only(['index', 'store', 'show']);

    // Admin Routes
    Route::group(['prefix' => 'admin', 'middleware' => TokenAdminAuthMiddleware::class], function () {
        Route::apiResource('brands', BrandController::class);
        Route::post('brands/{brand}', [BrandController::class, 'update']); // Update product with post, if PATCH OR PUT method not working

        Route::apiResource('categories', CategoryController::class);
        Route::post('categories/{category}', [CategoryController::class, 'update']); // Update product with post, if PATCH OR PUT method not working

        Route::apiResource('products', ProductController::class);
        Route::post('products/{product}', [ProductController::class, 'update']); // Update product with post, if PATCH OR PUT method not working

        Route::apiResource('product-details', ProductDetailController::class);
        Route::post('product-details/{product_detail}', [ProductDetailController::class, 'update']); // Update product with post, if PATCH OR PUT method not working

        Route::apiResource('product-sliders', ProductSliderController::class);

        // SSLCommerz Payment Gateway info store route
        Route::post('/sslcommerz-store-credentials', [SSLCommerzController::class, 'storeCredentials']);
    });
});



// SSLCommerz Payment Gateway
Route::post('/ssl-payment-ipn', [SSLCommerzController::class, 'paymentIpn']);