<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DeliveryArea;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\ShippingRate;
use App\Traits\ShippingCost;
use App\Traits\WeightConversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    use WeightConversion, ShippingCost;


    protected $paymentController;

    public function __construct(PaymentController $paymentController)
    {
        $this->paymentController = $paymentController;
    }

    public function checkout()
    {
        $cart = session('cart');
        if (!$cart || Auth::guest()) {
            return redirect()->route('cart.index')->with('error', 'Please add items to your cart first.');
        }

        // Cart::where('user_id', Auth::user()->id)->delete();

        foreach ($cart as $productId => $item) {
             Cart::updateOrCreate([
                'user_id' => Auth::user()->id,
                'product_id' => $productId,
                'size' => $item['size'] ?? null,
            ], [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $shipping = ShippingAddress::where('user_id', Auth::user()->id)->get();
        $delivery = DeliveryArea::orderBy('id', 'asc')->get();

        // Total weight convert to kg
        $totalWeight = $this->getTotalWeightInKg($cart);
        // Get shipping rates that match the total weight
        // $shippingRates = ShippingRate::where(function($query) use ($totalWeight) {
        //     $query->where('min_weight', '<=', $totalWeight)
        //           ->where('max_weight', '>=', $totalWeight);
        // })->orderBy('price', 'asc')->get();
        $shippingRates = $this->getShippingRates($totalWeight);

        // Get the delivery fee by checking the total weight
        $deliveryFee = 0;
        foreach ($delivery as $area) {
            if ($totalWeight < $area->minimum_delivery || $totalWeight > $area->maximum_delivery) {
                $deliveryFee = $area->delivery_fee;
                break;
            }
        }
        
        
        

        $totalProductPrice = $cart->sum(function ($item) {
            return $item->price;
        });
        
        $totalPrice = $totalProductPrice + $deliveryFee;

        // dd($totalPrice);

        return view('frontend.checkout', [
            'cartItems' => $cart,
            'user' => Auth::user(),
            'shippingAddresses' => $shipping,
            'totalPrice' => $totalPrice,
            'totalWeight' => $totalWeight, 
            'subtotal' => $totalProductPrice,
            'deliveryFee' => $deliveryFee,
            'shippingRates' => $shippingRates,
        ]);
    }


    public function processPayment(Request $request)
    {
        try {
            $user = Auth::user();
            // Get the current user's cart items
            $cartItems = Cart::where('user_id', Auth::user()->id)->get();

            // Check if cart is empty
            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Your cart is empty.');
            }

            $validate = Validator::make($request->all(), [
                'ship-address' => 'required',
                'address' => 'required',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'postal_code' => 'required|string|max:10',
                'size'=> 'nullable',
                'delivery_fee'=> 'nullable',
            ], [
                'ship-address.required' => 'Shipping address is required',
                'address.required' => 'Address is required',
                'city.required' => 'City is required',
                'state.required' => 'State is required',
                'country.required' => 'Country is required',
                'postal_code.required' => 'Postal code is required', 
            ]);

            if ($validate->fails()) {
                return back()->with('error', $validate->errors()->first());
            }


            // create shipping address or use existing one ( default address if exists)
            // if ($request->has('is_default')) {
            //     $user->shippingAddresses()->update(['is_default' => false]);
            // }

            // Get shipping rate details if selected
            $shippingRate = null;
            $shippingDeliveryType = null;
            $shippingPrice = 0;

            if ($request->filled('shipping_rate_id')) {
                $shippingRate = ShippingRate::find($request->shipping_rate_id);
                if ($shippingRate) {
                    $shippingDeliveryType = $shippingRate->delivery_type;
                    $shippingPrice = $shippingRate->price;
                }
            }

            $shippingAddress = ShippingAddress::updateOrCreate(
                ['user_id' => $user->id, 'is_default' => true],
                $request->only(['city', 'state', 'country', 'postal_code', 'address','ship-address', 'is_default'])
            );


            // Generate a unique invoice number 
            $invoiceNumber = OrderItem::generateInvoiceNumber();
            $orderItemIds = [];

            // orderItems
            foreach ($cartItems as $cartItem) {
                $orderItem = OrderItem::create([
                    'user_id' => Auth::user()->id,
                    'shipping_addresses_id' => $shippingAddress->id,
                    'invoice_number' => $invoiceNumber,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'size'=> $cartItem->size,
                    'delivery_fee'=> $request->delivery_fee,
                    'shipping_delivery_type' => $shippingDeliveryType,
                    'shipping_price' => $shippingPrice,
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
