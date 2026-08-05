<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\B2BRegisterController;
use App\Http\Controllers\Api\V1\Auth\B2BLoginController;
use App\Http\Controllers\Api\V1\Auth\B2BKycController;
use App\Http\Controllers\Api\V1\Auth\B2BCartController;
use App\Http\Controllers\Api\V1\Auth\B2BCheckoutController;
use App\Http\Controllers\Api\V1\B2BCatalogController;
use App\Http\Controllers\Api\V1\B2BRfqController;
use App\Http\Controllers\Api\V1\B2BPurchaseOrderController;
use App\Http\Controllers\Api\V1\B2BWishListController;
use App\Http\Controllers\Api\V1\B2BShippingAddressController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth');


Route::prefix('v1')->group(function () {
    // Guest route for B2B Registration and Login
    Route::post('/b2b/register', [B2BRegisterController::class, 'register']);
    Route::post('/b2b/login', [B2BLoginController::class, 'login']);

    // Product Endpoints
    Route::get('/b2b/catalog', [B2BCatalogController::class, 'index']);
    Route::get('/b2b/catalog/{slug}', [B2BCatalogController::class, 'show']);
    
    // Authenticated Sanctum Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user/me', [B2BLoginController::class, 'me']);
        Route::post('/account/switch-context', [B2BKycController::class, 'switchView']);

        Route::post('/kyc', [B2BKycController::class, 'submitKyc']);
        Route::get('/profile', [B2BKycController::class, 'profile']);
        Route::put('/profile', [B2BKycController::class, 'updateProfile']);
        Route::post('/switch-view', [B2BKycController::class, 'switchView']);
        Route::post('/resubmit', [B2BKycController::class, 'resubmit']);
        Route::get('/authorized-buyers', [B2BKycController::class, 'getAuthorizedBuyers']);
        Route::post('/authorized-buyers', [B2BKycController::class, 'addAuthorizedBuyer']);

        // Shipping Addresses
        Route::get('/shipping-addresses', [B2BShippingAddressController::class, 'index']);
        Route::post('/shipping-addresses', [B2BShippingAddressController::class, 'store']);
        Route::get('/shipping-addresses/{id}', [B2BShippingAddressController::class, 'show']);
        Route::put('/shipping-addresses/{id}', [B2BShippingAddressController::class, 'update']);
        Route::delete('/shipping-addresses/{id}', [B2BShippingAddressController::class, 'destroy']);
        Route::post('/shipping-addresses/{id}/set-default', [B2BShippingAddressController::class, 'setDefault']);


        // B2B Protected Endpoints (Requires Approved Trade Status)
        Route::middleware('b2b.approved')->group(function () {
            // Cart Endpoints
            Route::get('/cart', [B2BCartController::class, 'index']);
            Route::post('/cart', [B2BCartController::class, 'add']);
            Route::put('/cart/{id}', [B2BCartController::class, 'update']);
            Route::delete('/cart/{id}', [B2BCartController::class, 'destroy']);
            Route::delete('/cart', [B2BCartController::class, 'clear']);

            // Wishlist
            Route::get('/wishlist', [B2BWishlistController::class, 'index']);
            Route::post('/wishlist', [B2BWishlistController::class, 'store']);
            Route::delete('/wishlist/{id}', [B2BWishlistController::class, 'destroy']);
            Route::post('/wishlist/{id}/move-to-cart', [B2BWishlistController::class, 'moveToCart']);

            // Checkout Endpoints
            Route::get('/checkout', [B2BCheckoutController::class, 'getCheckoutDetails']);
            Route::post('/checkout', [B2BCheckoutController::class, 'processCheckout']);

            // Purchase Order Endpoints
            Route::post('/b2b/orders', [B2BPurchaseOrderController::class, 'store']);
            Route::get('/b2b/orders', [B2BPurchaseOrderController::class, 'index']);
            Route::get('/b2b/orders/drafts', [B2BPurchaseOrderController::class, 'drafts']);
            Route::post('/b2b/orders/{id}/approve', [B2BPurchaseOrderController::class, 'approveDraft']);
            Route::get('/b2b/orders/{id}', [B2BPurchaseOrderController::class, 'show']);
            Route::post('/b2b/orders/{id}/recurring', [B2BPurchaseOrderController::class, 'scheduleRecurring']);

            // RFQ Endpoints
            Route::post('/b2b/rfq', [B2BRfqController::class, 'store']);
            Route::get('/b2b/rfq', [B2BRfqController::class, 'index']);
            Route::get('/b2b/rfq/{id}', [B2BRfqController::class, 'show']);
            Route::put('/b2b/rfq/{id}/status', [B2BRfqController::class, 'updateStatus']);
        });
    });
});

// B2B Authenticated Endpoints
