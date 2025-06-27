<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\SiteManagementController;
use App\Http\Controllers\Admin\UserManagementController;








Route::prefix('admin')->name('admin.')->group(function (){ 

    Route::middleware('admin.logged_out')->group(function () {
        Route::controller(LoginController::class)->group(function (){
            Route::get('login-form','showLoginForm')->name('login.form');
            Route::post('login-post', 'login')->name('admin.login');
            Route::post('logout','logout')->name('admin.logout');
        });
    });

    Route::middleware('admin.logged_in')->group(function () { 
        Route::get('/dashboard', [ HomeController::class,'index' ])->name('home');
        Route::get('/setting', [ HomeController::class,'settings' ])->name('settings.index');

        // category
        // Route::get('/category/list', [CategoryController::class, 'index'])->name('category.index');
        // Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        // Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
        // Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        // Route::put('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');
        // Route::delete('/category/{id}/delete', [CategoryController::class, 'destroy'])->name('category.delete');


        // product 
        // Route::get('/product/list', [ProductController::class, 'index'])->name('product.index');
        // Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        // Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        // Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        // Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
        // Route::delete('/product/{id}/delete', [ProductController::class, 'destroy'])->name('product.delete');

        // order list
        // Route::get('order/list', [OrderController::class , 'index'])->name('order.list');   
        // Route::get('/order/pending', [OrderController::class, 'pendingOrder'])->name('order.pending');  
        // Route::get('/order/progress', [OrderController::class,  'processingOrder'])->name('order.progress');
        // Route::get('/order/delivered', [OrderController::class, 'deliveredOrder'])->name('order.delivered');
        // Route::get('/order/cancel', [OrderController::class, 'cancelledOrder'])->name('order.cancel');
        // Route::put('/order/{id}/update', [OrderController::class, 'update'])->name('order.update');
        // Route::delete('/order/{id}/delete', [OrderController::class, 'destroy'])->name('order.delete');

        // site management
        // Route::get('/home-page', [SiteManagementController::class, 'index'])->name('home.page');
        // Route::post('/home/promotion/store', [SiteManagementController::class, 'promotionStore'])->name('home.promotion.store');
        // Route::post('/hone/deal/store', [SiteManagementController::class, 'dealStore'])->name('home.dealStore');
        // Route::post('/home/plugin/store', [SiteManagementController::class, 'pluginStore'])->name('home.pluginStore');

        // banner
        // Route::get('/home/banner/create', [SiteManagementController::class, 'bannerCreate'])->name('home.bannerCreate');
        // Route::post('/home/banner/store', [SiteManagementController::class, 'bannerStore'])->name('home.banner.store');
        // Route::get('/home/banner/{id}/edit', [SiteManagementController::class,  'bannerEdit'])->name('banner.edit');
        // Route::put('/home/banner/{id}/update', [SiteManagementController::class, 'bannerUpdate'])->name('home.banner.update');
        // Route::delete('/home/banner/{id}/delete', [SiteManagementController::class, 'bannerDelete'])->name('home.banner.delete');

        // shipping route 
        // Route::get('/shipping', [SiteManagementController::class, 'shippingIndex'])->name('shipping.index');
        // Route::get('/shipping/create', [SiteManagementController::class, 'shippingCreate'])->name('shipping.create');
        // Route::get('/shipping/{id}/edit', [SiteManagementController::class, 'shippingEdit'])->name('shipping.edit');
        // Route::post('/shipping/store', [SiteManagementController::class, 'shippingStore'])->name('shipping.store');
        // Route::put('/shipping/{id}/update', [SiteManagementController::class, 'shippingUpdate'])->name('shipping.update');
        // Route::delete('/shipping/{id}/delete', [SiteManagementController::class, 'shippingDelete'])->name('shipping.delete');

        // slider
        // Route::get('/slider', [SiteManagementController::class,'sliderIndex'])->name('slider.index');
        // Route::get('/slider/create', [SiteManagementController::class,'sliderCreate'])->name('slider.create');
        // Route::get('/slider/{id}/edit', [SiteManagementController::class,'sliderEdit'])->name('slider.edit');
        // Route::post('/slider/store', [SiteManagementController::class,'sliderStore'])->name('slider.store');
        // Route::put('/slider/{id}/update', [SiteManagementController::class,'sliderUpdate'])->name('slider.update');
        // Route::delete('/slider/{id}/delete', [SiteManagementController::class,'sliderDelete'])->name('slider.delete');

        // user management
        // Route::get('/customer/list', [UserManagementController::class,'index'])->name('customer.index');

        // Post Controller
        // Route::get('/post/list', [PostController::class, 'index'])->name('post.index');
        // Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
        // Route::post('/post/store', [PostController::class,'store'])->name('post.store');
        // Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
        // Route::put('/post/{id}/update', [PostController::class, 'update'])->name('post.update');
        // Route::delete('/post/{id}/delete', [PostController::class, 'destroy'])->name('post.delete');


        // Faq controller
        // Route::get('/faq/list', [FaqController::class, 'index'])->name('faq.index');
        // Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
        // Route::get('/faq/{id}/edit', [FaqController::class, 'edit'])->name('faq.edit');
        // Route::post('/faq/store', [FaqController::class, 'store'])->name('faq.store');
        // Route::put('/faq/{id}/update', [FaqController::class, 'update'])->name('faq.update');
        // Route::delete('/faq/{id}/delete', [FaqController::class, 'destroy'])->name('faq.delete');
        
        
        // plugin
        // Route::get('/plugin', [PluginController::class, 'index'])->name('plugin.index');
        // Route::post('/plugin/store', [PluginController::class, 'store'])->name('plugin.firebase.store');


        // update profile and change profile
        // Route::put('/profile/{id}/update', [HomeController::class, 'update'])->name('update.profile');
        // change password
        // Route::post('/change-password/update', [HomeController::class, 'updatePassword'])->name('change.password.update');

    });
    
});