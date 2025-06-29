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
        $cart = Cart::where('user_id', Auth::user()->id)->get(); 
        return view('frontend.cart', [
            'carts'=>$cart,
        ]);
    }
  
   
    public function addToCart(CartRequest $request)
    {
         // Check if user is not authenticated
         if (!Auth::check()) {
            Session::put('url.intended', route('product.details', ['product' => $request->slug]));
            return redirect()->route('login');
        }
        
        try {
            $existingCartItem = Cart::where('product_id', $request->product_id)
                ->where('user_id', Auth::user()->id)
                ->first();
    
            if ($existingCartItem) {
                // dd($existingCartItem);
                // Increment quantity instead of replacing
                $existingCartItem->increment('quantity', $request->quantity);
            } else {
                Cart::create([
                    'product_id' => $request->product_id,
                    'user_id' => Auth::user()->id,
                    'quantity' => $request->quantity
                ]);
            }
    
            return back()->with('success', 'Product added to cart successfully!');
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Something went wrong while adding to cart.');
        }
    }
  
    public function update(Request $request)
{
    try {
        $cartItem = Cart::findOrFail($request->id);
        
        if ($request->action == 'increase') {
            $cartItem->increment('quantity');
            $message = 'Quantity increased successfully';
        } elseif ($request->action == 'decrease') {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
                $message = 'Quantity decreased successfully';
            } else {
                $cartItem->delete();
                $message = 'Item removed from cart';
            }
        }

        return response()->json([
            'success' => true, 
            'message' => $message,
            'quantity' => $cartItem->quantity ?? 0
        ]);
    } catch(\Exception $e) {
        Log::error($e->getMessage());
        return response()->json([
            'success' => false, 
            'message' => 'Error updating cart'
        ], 500);
    }
}


    
  
    public function destroy($id)
    {
        try{
            $cart = Cart::findOrFail($id);
            $cart->delete();
            return back()->with('success', 'Cart removed successfully!');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return back()->with('error', 'Something went wrong, please try again later.');
        }
        
    }
}
