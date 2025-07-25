<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cart()
    {
        $sessionCart = session()->get('cart', []);
        
        // dd($sessionCart);
        $cartItems = [];

        foreach ($sessionCart as $productId => $item) {
            $product = \App\Models\Product::find($productId);

            if ($product) {
                $cartItems[] = [
                    'id' => $productId,
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $item['quantity'] * $item['price'],
                    'price' => $item['price'],
                    'size' => $item['size'],
                ];
            }
        }
        // dd($cartItems);

        return view('frontend.cart', [
            'carts' => $cartItems,
        ]);
    }

  
    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = (int) $request->quantity ?: 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
            $message = 'Quantity has been increased';
        } else {
            $product = Product::findOrFail($productId);
            $cart[$productId] = [
                'product_id' => $request->product_id,
                "title" => $product->title,
                "price" => $request->price,
                "quantity" => $quantity,
                "size" => $request->size_variant ?? null,
            ];
            $message = 'Product added to cart';
        }

        session()->put('cart', $cart);
        
       $cartCount = count($cart);

       
        return response()->json([
            'success' => true, 
            'message' => $message,
            'cart_count' => $cartCount 
        ]);

    }

  public function update(Request $request)
    {
        $productId = $request->product_id;
        $action = $request->action;
        
        $cart = session()->get('cart', []);
        
        if (!isset($cart[$productId])) {
            return response()->json(['success' => false, 'message' => 'Product not found in cart']);
        }
        
        if ($action === 'increase') {
            $cart[$productId]['quantity'] += 1;
            $message = 'Quantity has been increased';
        } elseif ($action === 'decrease') {
            if ($cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity'] -= 1;
                $message = 'Quantity has been decreased';
            } else {
                return response()->json(['success' => false, 'message' => 'Minimum quantity is 1']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid action']);
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'quantity' => $cart[$productId]['quantity'],
        ]);
    }


    public function miniCart()
    {
        $carts = session('cart', []);
        $total = 0;

        foreach ($carts as $cartItem) {
            $total += $cartItem['price'] * $cartItem['quantity'];
        }

        return response()->json([
            'html' => view('partials.mini-cart', compact('carts', 'total'))->render()
        ]);
    }


    
  
    public function destroy($productId)    {
        try{
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
                
                return redirect()->back()->with('success', 'Item removed from cart');
            }
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return back()->with('error', 'Item not found in cart.');
        }
        
    }

    public function clear()
    {
        session()->forget('cart');
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }
}
