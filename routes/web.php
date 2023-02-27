<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/products', 'App\Http\Controllers\ProductController@index')->name('products');
    Route::get('/product/{code}', 'App\Http\Controllers\ProductController@show')->name('product-detail');

    Route::get('/checkout', 'App\Http\Controllers\CheckoutController@index')->name('checkout');
    Route::post('/checkout/confirm', 'App\Http\Controllers\CheckoutController@confirm')->name('checkout-confirm');
    Route::post('/checkout/{code}', 'App\Http\Controllers\CheckoutController@store')->name('checkout-store');

    Route::get('/reports', 'App\Http\Controllers\ReportController@index')->name('reports');
});
