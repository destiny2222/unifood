<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\WishListController;
use App\Http\Controllers\User\ReviewRatingController;





Route::prefix('dashboard')->group(function (){
    Route::middleware(['auth','verified', 'check.user'])->group(function (){
        Route::get("",[HomeController::class, "index"])->name("home");

        // profile routes
        Route::put("/profile/{id}/update", [HomeController::class, "EditProfile"])->name("profile.edit");
        Route::post('/profile/picture/update', [HomeController::class, 'updateProfilePicture'])->name('profile.picture.update');
        Route::post('/profile/password/update', [HomeController::class, 'ChangePassword'])->name('profile.password.update');
        

        // order route list
        // Route::get('/order/list', [HomeController::class, 'orderHistory'])->name('orders.index');
        // Route::get('/order/{id}/invoice', [HomeController::class, 'invoice'])->name('invoice.index');
        

        // cart routes
        // Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
        // Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        // Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
        // Route::delete('/cart/{id}/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
    
        // checkout routes
        // Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
        // Route::post('/order/process', [CheckoutController::class, 'processCheckout'])->name('checkout.placeOrder');
        // Route::get('/order/success', [CheckoutController::class, 'success'])->name('order.success');
        // Route::get('/order/failed', [CheckoutController::class, 'failed'])->name('order.failed');

        // wishlist
        Route::get('/wishlist', [WishListController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/add/', [WishListController::class, 'addProduct'])->name('wishlist.add');
        Route::post('/wishlist/add/cart', [WishListController::class, 'addProductToCart'])->name('wishlist.add.cart');
        Route::delete('/wishlist/{id}/remove', [WishListController::class, 'removeProduct'])->name('wishlist.remove');

        // review routes
        // Route::post('/reviews', [ReviewRatingController::class, 'reviewstore'])->name('review.store');

       

    });
});
