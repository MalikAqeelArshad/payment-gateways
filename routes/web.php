<?php

use App\Models\Payment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\StripeController;

Route::view('/', 'welcome');
Route::view('failed', 'failed')->name('failed');
// Route::view('success', 'success')->name('success');

Route::get('/payments', fn() => Payment::all());
Route::get('/payments/{id}', fn($id) => Payment::wherePaymentId($id)->first());

Route::group([
    'as' => 'paypal.',
    'prefix' => 'paypal',
    'controller' => PaypalController::class
], function() {
    Route::match(['get','post'], '/', 'paypal')->name('index');
    Route::get('transaction', 'transaction')->name('transaction');
});

Route::group([
    'as' => 'stripe.',
    'prefix' => 'stripe',
    'controller' => StripeController::class
], function() {
    Route::match(['get','post'], '/', 'stripe')->name('index');
    Route::get('transaction', 'transaction')->name('transaction');
});