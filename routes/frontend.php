<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;


Route::get('', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/products', [FrontendController::class, 'product'])->name('frontend.product');
Route::get('/products/{product}', [FrontendController::class, 'productDetails'])->name('frontend.product.show');
Route::get('/product/{product}', [FrontendController::class, 'product_show'])->name('frontend.product.details');
Route::get('/blog', [FrontendController::class, 'blog'])->name('frontend.blog');
Route::get('/blog/{post}', [FrontendController::class, 'blogDetails'])->name('frontend.blog.show');
Route::get('/blog', [FrontendController::class, 'searchBlog'])->name('frontend.blog.search');
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
 // route post comment
Route::post('/posts/{post}/comments', [FrontendController::class, 'commentStore'])->name('comments.store');
Route::get('/products/search', [FrontendController::class, 'searchProduct'])->name('frontend.product.search');
Route::get('/search', [FrontendController::class, 'searchEngine'])->name('search');
Route::get('terms-and-condition', [FrontendController::class, 'terms'])->name('frontend.terms-and-condition');
Route::get('privacy-policy', [FrontendController::class, 'privacy'])->name('frontend.privacy-policy');
Route::get('/faq', [FrontendController::class, 'faq'])->name('frontend.faq');
Route::post('/contact/store', [FrontendController::class, 'contactStore'])->name('frontend.contact.store');
Route::get('/products/category/{categorySlug}', [FrontendController::class, 'productsByCategory'])
     ->name('products.by.category');
Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');
