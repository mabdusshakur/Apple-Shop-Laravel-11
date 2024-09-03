<?php

use App\Http\Controllers\Api\V1\SSLCommerzController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::post('/ssl-payment-success', [SSLCommerzController::class, 'paymentSuccess']);
Route::post('/ssl-payment-fail', [SSLCommerzController::class, 'paymentFail']);
Route::post('/ssl-payment-cancel', [SSLCommerzController::class, 'paymentCancel']);