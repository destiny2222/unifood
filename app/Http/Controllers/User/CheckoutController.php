<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DeliveryArea;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
use App\Traits\WeightConversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    use WeightConversion;


    protected $paymentController;

    public function __construct(PaymentController $paymentController)
    {
        $this->paymentController = $paymentController;
    }

    public function checkout()
    {
        $cart = session('cart');
        if (!$cart || auth()->guest()) return;

        foreach ($cart as $productId => $item) {
            Cart::updateOrCreate([
                'user_id' => Auth::user()->id,
                'product_id' => $productId
            ], [
                'quantity' => $item['quantity'],
                'size' => $item['size'] ?? null,
                'price' => $item['price'],
            ]);
        }

        

        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $shipping = ShippingAddress::where('user_id', Auth::user()->id)->get();

        // Total price
        $totalPrice = $cart->sum(function ($item) {
            return $item->quantity * $item->price;
        });



        return view('frontend.checkout', [
            'cartItems' => $cart,
            'user' => Auth::user(),
            'shippingAddresses' => $shipping,
            'totalPrice' => $totalPrice,
            // 'totalWeight' => $totalWeight, // send to view
        ]);
    }


    public function processPayment(Request $request){
        try {
            $user = Auth::user();
            // Get the current user's cart items
            $cartItems = Cart::where('user_id', Auth::user()->id)->get();
             
            // Check if cart is empty
            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Your cart is empty.');
            }

            $validate = Validator::make($request->all(), [
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'postal_code' => 'required|string|max:10',
                'address' => 'required|string|max:500',
            ], [
                'city.required' => 'City is required',
                'state.required' => 'State is required',
                'country.required' => 'Country is required',
                'postal_code.required' => 'Postal code is required',
                'address.required' => 'Address is required',
            ]);

            if ($validate->fails()) {
                return back()->with('error', $validate->errors()->first());
            }


            // create shipping address or use existing one ( default address if exists)
            // if ($request->has('is_default')) {
            //     $user->shippingAddresses()->update(['is_default' => false]);
            // }

            $shippingAddress = ShippingAddress::updateOrCreate(
                ['user_id' => $user->id, 'is_default' => true],
                $request->only(['city', 'state', 'country', 'postal_code', 'address', 'is_default'])
            );

            
            // Generate a unique invoice number 
            $invoiceNumber = OrderItem::generateInvoiceNumber();
            $orderItemIds = [];

            // orderItems
            foreach ($cartItems as $cartItem) {
                $orderItem = OrderItem::create([
                    'user_id' => Auth::user()->id,
                    'shipping_addresses_id'=> $shippingAddress->id,
                    'invoice_number' => $invoiceNumber,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'payment_method' => 'Stripe',
                    'payment_status' => 0,
                ]);
                
                $orderItemIds[] = $orderItem->id;
            }

            // dd($orderItemIds);

            // Pass order item IDs to payment controller
            $request->merge(['order_item_ids' => $orderItemIds]);
            $request->merge(['invoice_number' => $invoiceNumber]);

            // Initiate Stripe Payment
            return $this->paymentController->stripeCheckout($request);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Checkout failed: please try again.');
        }
    }


}
