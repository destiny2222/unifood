<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;


Route::get('', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/product', [FrontendController::class, 'product'])->name('frontend.product');
Route::get('/product/{product}', [FrontendController::class, 'productDetails'])->name('frontend.product.show');

