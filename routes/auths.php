<?php
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ShippingAddressController;
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
        Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{id}/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
    
        // checkout routes
        Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
        Route::post('/order/process', [CheckoutController::class, 'processPayment'])->name('stripe.checkout.process');

        // wishlist
        Route::get('/wishlist', [WishListController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/add/', [WishListController::class, 'addProduct'])->name('wishlist.add');
        Route::post('/wishlist/add/cart', [WishListController::class, 'addProductToCart'])->name('wishlist.add.cart');
        Route::delete('/wishlist/{id}/remove', [WishListController::class, 'removeProduct'])->name('wishlist.remove');

        // shipping address
        Route::post('/shipping-address', [ShippingAddressController::class, 'store'])->name('shipping.address.store');
        Route::get('/shipping-address', [ShippingAddressController::class, 'edit'])->name('shipping.address.edit');
        Route::put('/shipping-address/{id}/update', [ShippingAddressController::class, 'update'])->name('shipping.address.update');
        Route::delete('/shipping-address/{id}', [ShippingAddressController::class, 'destroy'])->name('shipping.address.destroy');


        // review routes
        Route::post('/reviews', [ReviewRatingController::class, 'reviewstore'])->name('review.store');
        
       
        

        // Route::post('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
        // Route::post('/stripe/checkout', [PaymentController::class, 'processPayment'])->name('stripe.checkout.process');
        Route::get('/success', [PaymentController::class, 'stripeCheckoutSuccess'])->name('stripe.checkout.success');
        Route::get('/cancel', [PaymentController::class, 'stripeCheckoutCancel'])->name('stripe.checkout.cancel');

       

    });
});
