<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartCount extends Component
{
    public $count = 0;

    protected $listeners = ['cartUpdated' => 'refreshCount'];

    public function mount()
    {
        $this->refreshCount();
    }

    public function refreshCount()
    {
        if (Auth::check()) {
            $this->count = Cart::where('user_id', Auth::user()->id)->count();
        } else {
            
            $this->count = count(session()->get('cart', []));
        }
    }

    public function render()
    {
        return view('livewire.cart-count');
    }
}