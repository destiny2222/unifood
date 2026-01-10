<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MiniCart extends Component
{
    public $cart = [];

    protected $listeners = ['cartUpdated' => 'refreshCart'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        if (Auth::check()) {
            // Get cart from database for authenticated users
            $dbCart = Cart::where('user_id', Auth::id())->get();
            
            // Convert to same format as session cart
            $this->cart = [];
            foreach ($dbCart as $item) {
                $this->cart[$item->product_id] = [
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            }
        } else {
            // Get cart from session for guests
            $this->cart = session()->get('cart', []);
        }
    }

    public function removeItem($id)
    {
        if (Auth::check()) {
            // Remove from database
            Cart::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->delete();
        } else {
            // Remove from session
            $cart = session()->get('cart', []);
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        $this->refreshCart();
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        $productIds = array_keys($this->cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $total = 0;
        foreach ($this->cart as $productId => $item) {
            $product = $products->get($productId);
            if ($product) {
                $price = $item['price'] ?? $product->price;
                $total += $price * ($item['quantity'] ?? 1);
            }
        }

        return view('livewire.mini-cart', [
            'products' => $products,
            'carts' => $this->cart,
            'total' => $total,
        ]);
    }
}