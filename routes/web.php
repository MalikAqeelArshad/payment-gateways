<?php

use App\Models\Payment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\StripeController;

Route::view('/', 'welcome');
Route::view('failed', 'failed')->name('failed');
// Route::view('success', 'success')->name('success');

Route::group([
    'as' => 'paypal.',
    'prefix' => 'paypal',
    'controller' => PaypalController::class
], function() {
    Route::post('/', 'paypal')->name('index');
    Route::get('transaction', 'transaction')->name('transaction');
});

Route::group([
    'as' => 'stripe.',
    'prefix' => 'stripe',
    'controller' => StripeController::class
], function() {
    Route::post('/', 'stripe')->name('index');
    Route::get('transaction', 'transaction')->name('transaction');
});