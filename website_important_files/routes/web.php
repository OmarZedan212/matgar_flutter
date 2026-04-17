<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategoryGroupController;
use App\Http\Controllers\Admin\SellersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\OrderController;


include('auth.php');

Route::get('/', [HomeController::class, 'index'])->name('home');

// تبديل اللغة
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');
//Route::middleware(['auth','role:seller'])->group(function () {
Route::middleware('auth')
    ->prefix('seller')
    ->as('seller.')
    ->controller(SellerController::class)
    ->group(function () {
        Route::middleware('seller')->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/inventory', 'inventory')->name('inventory');
            Route::get('/orders', 'orders')->name('orders');
            Route::get('/orders/{order}', 'show_order')->name('orders.show');
            Route::post('/update_order_status', 'update_order_status')->name('update_order_status');
            Route::get('/analytics', 'analytics')->name('analytics');
            Route::post('/store_product', 'store_product')->name('store_product');
            Route::put('/update_product', 'update_product')->name('update_product');
            Route::delete('/delete_product/{id}', 'delete_product')->name('delete_product');
            
        });
        
        Route::get('/settings', 'settings')->name('settings');
        Route::put('/update_settings', 'update_settings')->name('update_settings');
    });
    

Route::middleware('auth')->group(function () {
    Route::get('/wish_list', function () {
        return view('customer.wish_list');
    });
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/{id}/delete', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::resource('orders', OrderController::class)->names('orders');
    Route::get('/customer_account', [CustomerAccountController::class, 'index'])->name('customer.account');
    Route::post('/account/update', [CustomerAccountController::class, 'updateProfile'])->name('customer.account.update');
});

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/sellers', [CategoryController::class, 'index'])->name('sellers');
    //categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories/store',  [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/categories/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/delete', [CategoryController::class, 'delete'])->name('categories.delete');

    //category-groups
    Route::get('category-groups', [CategoryGroupController::class, 'index'])
        ->name('category_groups');

    Route::post('category-groups/store', [CategoryGroupController::class, 'store'])
        ->name('category_groups.store');

    Route::post('category-groups/update', [CategoryGroupController::class, 'update'])
        ->name('category_groups.update');

    Route::delete('category-groups/delete', [CategoryGroupController::class, 'delete'])
        ->name('category_groups.delete');
        Route::resource('sellers', SellersController::class)->names('sellers');
        Route::patch('sellers/{seller}/approve', [SellersController::class, 'approve'])
        ->name('sellers.approve');
    });
// Route::middleware(['auth','role:customer'])->group(function () {
//     Route::get('/account', [CustomerDashboardController::class,'index'])->name('customer.dashboard');
// });
Route::get('/dashboard', function () {
    return redirect(route('home'));
});
Route::get('/loading', function () {
    return view('customer.loading');
});
// web.php
Route::get('/about', function () {
    return view('customer.about');
})->name('about');
Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/shipping', function () {
    return view('customer.shipping');
});
Route::get('/blog', function () {
    return view('customer.blog');
})->name('blog');
Route::get('/careers', function () {
    return view('customer.careers');
});
Route::get('/contact', function () {
    return view('customer.contact');
})->name('contact');
Route::get('/faq', function () {
    return view('customer.faq');
});
Route::get('/payment', function () {
    return view('customer.payment');
});
Route::get('/privacy', function () {
    return view('customer.privacy');
});
Route::get('/return_policy', function () {
    return view('customer.return_policy');
});
Route::get('/terms', function () {
    return view('customer.terms');
});
Route::get('/track', function () {
    return view('customer.track');
});

Route::get('/product/{id}', [ProductController::class, 'show'])->name('customer.product');
