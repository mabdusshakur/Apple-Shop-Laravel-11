<?php

use App\Http\Controllers\Api\V1\SSLCommerzController;
use App\Http\Controllers\UserFrontController;
use Illuminate\Support\Facades\Route;







Route::get('/', [UserFrontController::class, 'homePage'])->name('web.home');
Route::get('/login', [UserFrontController::class, 'loginPage'])->name('web.login');
Route::get('/verify-otp', [UserFrontController::class, 'verifyOtpPage'])->name('web.verify-otp');
Route::get('/profile', [UserFrontController::class, 'profilePage'])->name('web.profile');
Route::get('/wish-list', [UserFrontController::class, 'wishListPage'])->name('web.wish-list');
Route::get('/cart-list', [UserFrontController::class, 'cartListPage'])->name('web.cart-list');
Route::get('/product-details/{id?}', [UserFrontController::class, 'productDetailsPage'])->name('web.product-details');
Route::get('/policy', [UserFrontController::class, 'policyPage'])->name('web.policy');
Route::get('/product-by-brand/{id?}', [UserFrontController::class, 'productByBrandPage'])->name('web.product-by-brand');
Route::get('/product-by-category/{id?}', [UserFrontController::class, 'productByCategoryPage'])->name('web.product-by-category');


Route::post('/ssl-payment-success', [SSLCommerzController::class, 'paymentSuccess']);
Route::post('/ssl-payment-fail', [SSLCommerzController::class, 'paymentFail']);
Route::post('/ssl-payment-cancel', [SSLCommerzController::class, 'paymentCancel']);