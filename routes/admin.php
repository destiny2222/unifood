<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PluginController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ShippingRateController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;









Route::prefix('admin')->name('admin.')->group(function (){ 

    Route::middleware('admin.logged_out')->group(function () {
        Route::controller(LoginController::class)->group(function (){
            Route::get('login','showLoginForm')->name('login.form');
            Route::post('login-post', 'login')->name('login');
            Route::post('logout','logout')->name('logout');
        });
    });

    Route::middleware('admin.logged_in')->group(function () { 
        Route::get('/dashboard', [ HomeController::class,'index' ])->name('home');
        Route::get('/setting', [ HomeController::class,'settings' ])->name('settings.index');

        // category
        Route::get('/category/list', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{id}/delete', [CategoryController::class, 'destroy'])->name('category.delete');


        // product 
        Route::get('/product/list', [ProductController::class, 'index'])->name('product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/{id}/delete', [ProductController::class, 'destroy'])->name('product.delete');

        // order list
        Route::get('order/list', [OrderController::class , 'index'])->name('order.list');   
        Route::get('order-show/{id}', [OrderController::class, 'show'])->name('order.show');
        Route::get('/order/pending', [OrderController::class, 'pendingOrder'])->name('order.pending');  
        Route::get('/order/progress', [OrderController::class,  'processingOrder'])->name('order.progress');
        Route::get('/order/delivered', [OrderController::class, 'deliveredOrder'])->name('order.delivered');
        Route::get('/order/cancel', [OrderController::class, 'cancelledOrder'])->name('order.cancel');
        Route::put('/order/{id}/update', [OrderController::class, 'update'])->name('order.update');
        Route::delete('/order/{id}/delete', [OrderController::class, 'destroy'])->name('order.delete');

        //system clear
         Route::get('/system', [SystemController::class, 'index'])->name('system.index');
        Route::post('/system/clear-all-cache', [SystemController::class, 'clearAllCache'])->name('system.clear-all-cache');
        Route::post('/system/clear-app-cache', [SystemController::class, 'clearAppCache'])->name('system.clear-app-cache');
        Route::post('/system/clear-config-cache', [SystemController::class, 'clearConfigCache'])->name('system.clear-config-cache');
        Route::post('/system/clear-route-cache', [SystemController::class, 'clearRouteCache'])->name('system.clear-route-cache');
        Route::post('/system/clear-view-cache', [SystemController::class, 'clearViewCache'])->name('system.clear-view-cache');
        Route::post('/system/optimize', [SystemController::class, 'optimizeApp'])->name('system.optimize');
        Route::post('/system/clear-logs', [SystemController::class, 'clearLogs'])->name('system.clear-logs');
        

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

        // Delivery Area route 
        Route::get('/delivery-area', [DeliveryAreaController::class, 'index'])->name('delivery.area.index');
        Route::get('/delivery-area/create', [DeliveryAreaController::class, 'create'])->name('delivery.area.create');
        Route::post('/delivery-area/store', [DeliveryAreaController::class, 'store'])->name('delivery.area.store');
        Route::get('/delivery-area/{id}/edit', [DeliveryAreaController::class, 'edit'])->name('delivery.area.edit');
        Route::put('/delivery-area/{id}/update', [DeliveryAreaController::class, 'update'])->name('delivery.area.update');
        Route::delete('/delivery-area/{id}/delete', [DeliveryAreaController::class, 'destroy'])->name('delivery.area.delete');

        // slider
        Route::get('/slider', [SliderController::class,'index'])->name('slider.index');
        Route::get('/slider/create', [SliderController::class,'create'])->name('slider.create');
        Route::get('/slider/{id}/edit', [SliderController::class,'edit'])->name('slider.edit');
        Route::post('/slider/store', [SliderController::class,'store'])->name('slider.store');
        Route::put('/slider/{id}/update', [SliderController::class,'update'])->name('slider.update');
        Route::delete('/slider/{id}/delete', [SliderController::class,'destroy'])->name('slider.delete');

        // Advertisement route
        Route::get('/advertisement', [PageController::class,'advertisementPage'])->name('advertisement.index');
        Route::get('/advertisement/create', [PageController::class,'advertisementCreate'])->name('advertisement.create');
        Route::post('/advertisement/store', [PageController::class,'advertisementStore'])->name('advertisement.store');
        Route::get('/advertisement/{id}/edit', [PageController::class,'advertisementEdit'])->name('advertisement.edit');
        Route::put('/advertisement/{id}/update', [PageController::class,'advertisementUpdate'])->name('advertisement.update');
        Route::delete('/advertisement/{id}/delete', [PageController::class,'advertisementDelete'])->name('advertisement.delete');

        // App Section route
        Route::get('/app-section', [PageController::class,'AppSectionPage'])->name('app-section.index');
        Route::post('/app-section/store', [PageController::class,'AppSectionStore'])->name('app-section.store');

        // Contact route
        Route::get('/contact', [PageController::class,'contactPage'])->name('contact.index');
        Route::post('/contact/store', [PageController::class,'contactStore'])->name('contact.store');

        // Counter route
        Route::get('/counter', [PageController::class,'counterPage'])->name('counter.index');
        Route::get('/counter/create', [PageController::class,'counterCreate'])->name('counter.create');
        Route::post('/counter/store', [PageController::class,'counterStore'])->name('counter.store');
        Route::delete('/counter/{id}/delete', [PageController::class,'counterDelete'])->name('counter.delete');
        Route::get('/counter/{id}/edit', [PageController::class,'counterEdit'])->name('counter.edit');
        Route::put('/counter/{id}/update', [PageController::class,'counterUpdate'])->name('counter.update');


        // Service route
        Route::get('/service', [PageController::class,'servicePage'])->name('service.index');
        Route::get('/service/create', [PageController::class,'serviceCreate'])->name('service.create');
        Route::post('/service/store', [PageController::class,'serviceStore'])->name('service.store');
        Route::get('/service/{id}/edit', [PageController::class,'serviceEdit'])->name('service.edit');
        Route::put('/service/{id}/update', [PageController::class,'serviceUpdate'])->name('service.update');
        Route::delete('/service/{id}/delete', [PageController::class,'serviceDelete'])->name('service.delete');

        // About route
        Route::get('/about-us', [PageController::class,'aboutPage'])->name('about.index');
        Route::post('/about/store', [PageController::class,'aboutStore'])->name('about.store');

        // user management
        Route::get('/customer/list', [UserManagementController::class,'index'])->name('customer.index');

        // partner route
        Route::get('/partner/list', [PartnerController::class,'index'])->name('partner.index');
        Route::get('/partner/create', [PartnerController::class,'create'])->name('partner.create');
        Route::post('/partner/store', [PartnerController::class,'store'])->name('partner.store');
        Route::get('/partner/{id}/edit', [PartnerController::class,'edit'])->name('partner.edit');
        Route::put('/partner/{id}/update', [PartnerController::class,'update'])->name('partner.update');
        Route::delete('/partner/{id}/delete', [PartnerController::class,'destroy'])->name('partner.delete');

        // Post Route
        Route::get('/post/list', [PostController::class, 'index'])->name('post.index');
        Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/post/store', [PostController::class,'store'])->name('post.store');
        Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
        Route::put('/post/{id}/update', [PostController::class, 'update'])->name('post.update');
        Route::delete('/post/{id}/delete', [PostController::class, 'destroy'])->name('post.delete');

        // Post Category Route
        Route::get('/post/category/list', [PostCategoryController::class, 'index'])->name('post.category.index');
        Route::get('/post/category/create', [PostCategoryController::class, 'create'])->name('post.category.create');
        Route::post('/post/category/store', [PostCategoryController::class,'store'])->name('post.category.store');
        Route::get('/post/category/{id}/edit', [PostCategoryController::class, 'edit'])->name('post.category.edit');
        Route::put('/post/category/{id}/update', [PostCategoryController::class, 'update'])->name('post.category.update');
        Route::delete('/post/category/{id}/delete', [PostCategoryController::class, 'destroy'])->name('post.category.delete');

        // Review route
        Route::get('/review/list', [ReviewController::class, 'index'])->name('review.index');
        Route::put('/review/{id}/update', [ReviewController::class, 'update'])->name('review.update');
        Route::delete('/review/{id}/delete', [ReviewController::class, 'destroy'])->name('review.delete');


        // Faq controller
        Route::get('/faq/list', [FaqController::class, 'index'])->name('faq.index');
        Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
        Route::get('/faq/{id}/edit', [FaqController::class, 'edit'])->name('faq.edit');
        Route::post('/faq/store', [FaqController::class, 'store'])->name('faq.store');
        Route::put('/faq/{id}/update', [FaqController::class, 'update'])->name('faq.update');
        Route::delete('/faq/{id}/delete', [FaqController::class, 'destroy'])->name('faq.delete');

        // testimonial
        Route::get('/testimonial/list', [TestimonialController::class, 'index'])->name('testimonial.index');
        Route::get('/testimonial/create', [TestimonialController::class, 'create'])->name('testimonial.create');
        Route::get('/testimonial/{id}/edit', [TestimonialController::class, 'edit'])->name('testimonial.edit');
        Route::post('/testimonial/store', [TestimonialController::class, 'store'])->name('testimonial.store');
        Route::put('/testimonial/{id}/update', [TestimonialController::class, 'update'])->name('testimonial.update');
        Route::delete('/testimonial/{id}/delete', [TestimonialController::class, 'destroy'])->name('testimonial.delete');
        
        // plugin
        Route::get('/plugin', [PluginController::class, 'index'])->name('plugin.index');
        Route::post('/plugin/store', [PluginController::class, 'store'])->name('plugin.firebase.store');

        // term
        Route::get('/term/list', [PageController::class, 'terms'])->name('terms.index');
        Route::post('/term/store', [PageController::class, 'termStore'])->name('terms.store');

        // Shipping Rate
        Route::get('/shipping/rate', [ShippingRateController::class, 'index'])->name('shipping.rate.index');
        Route::get('/shipping/rate/create', [ShippingRateController::class, 'create'])->name('shipping.rate.create');
        Route::post('/shipping/rate/store', [ShippingRateController::class, 'store'])->name('shipping.rate.store');
        Route::get('/shipping/rate/{id}/edit', [ShippingRateController::class, 'edit'])->name('shipping.rate.edit');
        Route::put('/shipping/rate/{id}/update', [ShippingRateController::class, 'update'])->name('shipping.rate.update');
        Route::get('/shipping/rate/{id}/delete', [ShippingRateController::class, 'destroy'])->name('shipping.rate.delete');

        // policy
        Route::get('/policy/list', [PageController::class, 'policy'])->name('policy.index');
        Route::post('/policy/store', [PageController::class, 'policyStore'])->name('policy.store');

        // whyChooseUs
        // Route::get('/why-choose-us/list', [PageController::class, 'whyChoose'])->name('why-choose-us.index');
        Route::post('/why-choose-us/store', [PageController::class, 'whyChooseStore'])->name('why-choose-us.store');


        // update profile and change profile
        Route::put('/profile/{id}/update', [HomeController::class, 'update'])->name('update.profile');
        // change password
        Route::post('/change-password/update', [HomeController::class, 'updatePassword'])->name('change.password.update');

    });
    
});
