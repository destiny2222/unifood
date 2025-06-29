<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{

    protected $paymentController;

    public function __construct(PaymentController $paymentController)
    {
        $this->paymentController = $paymentController;
    }

    public function checkout(){
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $shipping = ShippingAddress::where('status', 1)->get();

        if (!$shipping) {
            return back()->with('error', 'No shipping method available.');
        }

        $shippingPrice = $shipping->price;
        $total = $cart->sum(function($item) use ($shippingPrice) {
            return $item->product->price * $item->quantity + $shippingPrice;
        });


        return view('frontend.checkout', [
            'cartItems' => $cart,
            'total' => $total,
            'user' => Auth::user(),
            'shipping' => $shipping
        ]);
    }
}
