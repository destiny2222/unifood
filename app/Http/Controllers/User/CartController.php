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
    $cartItems = [];
    
    if (Auth::check()) {
        $dbItems = Cart::with('product')->where('user_id', Auth::user()->id)->get();
        
        foreach ($dbItems as $item) {
            $cartItems[] = [  
                'id' => $item->id,
                'product' => $item->product,
                'quantity' => $item->quantity,
                'total' => $item->quantity * $item->price,
                'price' => $item->price,
                'size' => $item->size ?? 'N/A', 
            ];
        }
    } else {
        $sessionCart = session()->get('cart', []);
        
        foreach ($sessionCart as $productId => $item) {
            $product = \App\Models\Product::find($productId);

            if ($product) {
                $cartItems[] = [
                    'id' => $productId,
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $item['quantity'] * $item['price'],
                    'price' => $item['price'],
                    'size' => $item['size'] ?? 'N/A',
                ];
            }
        }
    }

    return view('frontend.cart', [
        'carts' => $cartItems,
    ]);
}


public function addToCart(Request $request)
{
    $productId = (int) $request->product_id;
    $quantity  = (int) ($request->quantity ?? 1);
    $size      = $request->size_variant ?? null;

    $product = Product::with('variants')->findOrFail($productId);

    // Determine price if not provided
    $price = $request->price;
    if (!$price) {
        if ($product->has_variants && $product->variants->first()) {
            $price = $product->variants->first()->price;
        } else {
            $price = $product->price;
        }
    }

    if (Auth::check()) {
        $userId = Auth::id();
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->when($size, fn ($q) => $q->where('size', $size),
                        fn ($q) => $q->whereNull('size'))
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $message = 'Quantity has been increased';
        } else {
            $cartItem = new Cart();
            $cartItem->user_id    = $userId;
            $cartItem->product_id = $productId;
            $cartItem->quantity   = $quantity;
            $cartItem->size       = $size;
            $message = 'Product added to cart';
        }

        $cartItem->price = $price;
        $cartItem->save();

        return redirect()->route('cart.index')
            ->with('success', $message)
            ->with('dispatch_event', 'cartUpdated');


        // return redirect()->route('cart.index')->with('success', $message);
    }

    // ✅ Guest user -> use session
    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $quantity;
        $message = 'Quantity has been increased';
    } else {
        $cart[$productId] = [
            "product_id" => $productId,
            "title"      => $product->title,
            "price"      => $price,
            "quantity"   => $quantity,
            "size"       => $size,
        ];
        $message = 'Product added to cart';
    }

    session()->put('cart', $cart);

    return redirect()->route('cart.index')
            ->with('success', $message)
            ->with('dispatch_event', 'cartUpdated');

    // return redirect()->route('cart.index')->with('success', $message);
}


public function update(Request $request)
{
    $productId = $request->product_id;
    $action = $request->action;
    
    try {
        if (Auth::check()) {
            $cartItem = Cart::where('id', $productId)
                ->where('user_id', Auth::id())
                ->first();
            
            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in cart'
                ]);
            }
            
            if ($action === 'increase') {
                $cartItem->quantity += 1;
                $message = 'Quantity has been increased';
            } elseif ($action === 'decrease') {
                if ($cartItem->quantity > 1) {
                    $cartItem->quantity -= 1;
                    $message = 'Quantity has been decreased';
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Minimum quantity is 1'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid action'
                ]);
            }
            
            $cartItem->save();
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'quantity' => $cartItem->quantity,
            ]);
            
        } else {
            $cart = session()->get('cart', []);
            
            if (!isset($cart[$productId])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in cart'
                ]);
            }
            
            if ($action === 'increase') {
                $cart[$productId]['quantity'] += 1;
                $message = 'Quantity has been increased';
            } elseif ($action === 'decrease') {
                if ($cart[$productId]['quantity'] > 1) {
                    $cart[$productId]['quantity'] -= 1;
                    $message = 'Quantity has been decreased';
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Minimum quantity is 1'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid action'
                ]);
            }
            
            session()->put('cart', $cart);
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'quantity' => $cart[$productId]['quantity'],
            ]);
        }
        
    } catch (\Exception $e) {
        Log::error('Cart update error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to update cart'
        ], 500);
    }
}


public function destroy($id)
{
    try {
        if (Auth::check()) {
            // For authenticated users - delete from database
            $cartItem = Cart::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->first();
            
            if ($cartItem) {
                $cartItem->delete();
                
                // Return JSON response for AJAX requests
                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item removed from cart'
                    ]);
                }
                
                return redirect()->back()->with('success', 'Item removed from cart');
            }
            
            // Return JSON error for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ], 404);
            }
            
            return back()->with('error', 'Item not found in cart.');
            
        } else {
            // For guest users - delete from session
            $cart = session()->get('cart', []);
            
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
                
                // Return JSON response for AJAX requests
                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item removed from cart'
                    ]);
                }
                
                return redirect()->back()->with('success', 'Item removed from cart');
            }
            
            // Return JSON error for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ], 404);
            }
            
            return back()->with('error', 'Item not found in cart.');
        }
        
    } catch (\Exception $e) {
        Log::error('Cart destroy error: ' . $e->getMessage());
        
        // Return JSON error for AJAX requests
        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from cart'
            ], 500);
        }
        
        return back()->with('error', 'Failed to remove item from cart.');
    }
}
    

    public function clear()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::user()->id)->delete();
        } else {
            session()->forget('cart');
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }
}
