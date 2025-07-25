<?php

namespace App\Livewire;

use App\Models\Product;
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
        $this->cart = session()->get('cart', []);
    }

    public function removeItem($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        $this->refreshCart();
    }

    public function render()
    {
        $productIds = array_keys($this->cart);
        $products = \App\Models\Product::whereIn('id', $productIds)->get()->keyBy('id');

        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        
        }

        return view('livewire.mini-cart', [
            'products' => $products,
            'carts' => $this->cart,
            'total' => $total,
        ]);
    }
}
