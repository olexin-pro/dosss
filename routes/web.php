<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\Shop\ProductController::class, 'index'])
    ->name('app.home');

Route::get('/catalog/product/{product:slug}', [App\Http\Controllers\Shop\ProductController::class, 'show'])
    ->name('app.shop.product.show');

Route::get('/catalog/category/{category:slug}', [App\Http\Controllers\Shop\ProductController::class, 'category'])
    ->name('app.shop.category.show');

Route::get('/search', [App\Http\Controllers\Shop\ProductController::class, 'search'])
    ->name('app.shop.search');

Route::get('/filter', [App\Http\Controllers\Shop\ProductController::class, 'filter'])
    ->name('app.shop.filter');
