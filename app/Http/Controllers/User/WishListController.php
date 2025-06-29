<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function index(){

        $wishlist = Wishlist::orderBy('id', 'desc')->get();
        return view('frontend.wishlist', [
            'wishlists'=>$wishlist,
        ]);
    }

    public function addProduct(Request $request)
    {
        
        try{
            
            $existingWishlist = Wishlist::where('user_id', Auth::user()->id)->where('product_id', $request->product_id)->first();
           
            if($existingWishlist){
                return back()->with('error', 'Wishlist already exists');
            }
            $wishlist = new Wishlist();
            $wishlist->user_id = Auth::user()->id;
            $wishlist->product_id = $request->product_id;
            $wishlist->save();
            return redirect()->route('wishlist.index')->with('success', 'Product added to Wishlist Successful');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('error', 'An error occurred while adding the product');
        }
    }

    public function addProductToCart(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to add items to your cart.');
        }
    
        try {
            // Check for existing wishlist entry
            $existingWishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();
    
            // Check for existing cart item
            $existingCartItem = Cart::where('product_id', $request->product_id)
                ->where('user_id', Auth::id())
                ->first();
    
            if ($existingCartItem) {
                $existingCartItem->increment('quantity', $request->quantity);
            } else {
                Cart::create([
                    'product_id' => $request->product_id,
                    'user_id' => Auth::id(),
                    'quantity' => $request->quantity
                ]);
            }
    
            // Delete from wishlist if it exists
            if ($existingWishlist) {
                $existingWishlist->delete();
            }
            return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            Log::error('Add to Cart Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while adding to cart.');
        }
    }
    

    public function removeProduct($id)
    {
        try{
            $wishlist = Wishlist::findOrFail($id);
            $wishlist->delete();
            return back()->with('success', 'Wishlist Deleted Successful');;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return back()->with('error', 'Wishlist Deleted Error');
        }
    }
}
