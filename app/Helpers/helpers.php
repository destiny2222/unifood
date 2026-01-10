<?php

use App\Helpers\CartHelper;

if (!function_exists('cart_count')) {
    function cart_count()
    {
        return CartHelper::getCartCount();
    }
}

if (!function_exists('cart_items_count')) {
    function cart_items_count()
    {
        return CartHelper::getCartItemsCount();
    }
}

if (!function_exists('cart_subtotal')) {
    function cart_subtotal()
    {
        return CartHelper::getCartSubtotal();
    }
}