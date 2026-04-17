<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MobileApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('mobile')->controller(MobileApiController::class)->group(function () {
    Route::get('/categories', 'categories');
    Route::get('/products', 'products');
    Route::get('/products/{id}', 'product');
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', 'profile');
        Route::put('/profile', 'updateProfile');
        Route::post('/logout', 'logout');

        Route::get('/cart', 'cart');
        Route::post('/cart', 'addToCart');
        Route::put('/cart/{cart}', 'updateCartItem');
        Route::delete('/cart/{cart}', 'removeCartItem');

        Route::post('/checkout', 'checkout');
        Route::get('/orders', 'orders');
        Route::get('/orders/{order}', 'order');
    });
});
