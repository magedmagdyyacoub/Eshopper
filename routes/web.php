<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

// Use HomeController to handle the homepage without authentication
Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');  // Redirect to the welcome page
})->name('logout');

/*------------------------------------------
| All Normal Users Routes List
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/shop', function () {
        return view('shop');
    })->name('shop');
    Route::get('/detail', function () {
      return view('detail');
  })->name('detail');
  Route::get('/cart', function () {
    return view('cart');
})->name('cart');
Route::get('/checkout', function () {
  return view('checkout');
})->name('checkout');
Route::get('/contact', function () {
  return view('contact');
})->name('contact');
Route::get('/product/{id}', [ProductController::class, 'showw'])->name('product.detail');
});

/*------------------------------------------
| All Admin Routes List
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->prefix('admin')->group(function () {
    
    // Admin dashboard/home route
    Route::get('/home', [HomeController::class, 'adminHome'])->name('admin.home');

    // Category and product resource routes
    Route::resource('categories', CategoryController::class, ['as' => 'admin']);
    Route::resource('products', ProductController::class, ['as' => 'admin']);
});

/*------------------------------------------
| All Manager Routes List
--------------------------------------------*/
Route::middleware(['auth', 'user-access:manager'])->prefix('manager')->group(function () {
    Route::get('/home', [HomeController::class, 'managerHome'])->name('manager.home');
});

Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/autocomplete', [ProductController::class, 'autocomplete'])->name('products.autocomplete');
Route::get('/categories/{id}', [CategoryController::class, 'usershow'])->name('categories.show');

