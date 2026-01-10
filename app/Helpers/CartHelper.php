<?php

namespace App\Helpers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartHelper
{
    /**
     * Get the total count of items in the cart
     *
     * @return int
     */
    public static function getCartCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::user()->id)->count();
        }
        
        return count(session()->get('cart', []));
    }

    /**
     * Get the total number of items (including quantities)
     *
     * @return int
     */
    public static function getCartItemsCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::user()->id)->sum('quantity');
        }
        
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Get cart subtotal
     *
     * @return float
     */
    public static function getCartSubtotal()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::user()->id)
                ->get()
                ->sum(function ($item) {
                    return $item->price * $item->quantity;
                });
        }
        
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }
}