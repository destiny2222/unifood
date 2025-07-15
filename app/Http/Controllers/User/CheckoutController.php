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
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $shipping = ShippingAddress::where('user_id', Auth::user()->id)->get();
        $deliveryArea = DeliveryArea::orderBy('id', 'desc')->get();

        // Total price
        $totalPrice = $cart->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Total weight
        $totalWeight = $cart->sum(function ($item) {
            return $this->toGrams($item->product->weight, $item->product->weight_unit) * $item->quantity;
        });

        return view('frontend.checkout', [
            'cartItems' => $cart,
            'user' => Auth::user(),
            'shippingAddresses' => $shipping,
            'deliveryArea' => $deliveryArea,
            'totalPrice' => $totalPrice,
            'totalWeight' => $totalWeight, // send to view
        ]);
    }


    public function processPayment(Request $request){
        try {
            // Get the current user's cart items
            $cartItems = Cart::where('user_id', Auth::user()->id)->get();
             
            // Check if cart is empty
            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Your cart is empty.');
            }

            // if()

            
            // Generate a unique invoice number 
            $invoiceNumber = OrderItem::generateInvoiceNumber();
            $orderItemIds = [];

            // orderItems
            foreach ($cartItems as $cartItem) {
                $orderItem = OrderItem::create([
                    'user_id' => Auth::user()->id,
                    'shipping_addresses_id'=> $request->shipping_addresses_id,
                    'invoice_number' => $invoiceNumber,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
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
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }


}
