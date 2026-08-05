<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
use App\Models\ShippingRate;
use App\Traits\ShippingCost;
use App\Traits\WeightConversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class B2BCheckoutController extends Controller
{
    use WeightConversion, ShippingCost;

    /**
     * Get details needed for B2B Checkout.
     */
    public function getCheckoutDetails(Request $request)
    {
        $user = $request->user();

        // 1. Block if KYC is not approved
        if (!$user->isB2B()) {
            return response()->json([
                'error' => 'Your trade account is pending approval or has not been approved. Checkout is currently disabled.'
            ], 403);
        }

        // 2. Fetch B2B cart items
        $cart = Cart::with('product')
            ->where('user_id', $user->id)
            ->whereHas('product', function ($query) {
                $query->where('is_b2b', true);
            })
            ->get();

        if ($cart->isEmpty()) {
            return response()->json([
                'error' => 'Please add items to your B2B cart first.'
            ], 400);
        }

        // 3. Shipping addresses
        $shipping = ShippingAddress::where('user_id', $user->id)->get();

        // 4. Calculate total weight & shipping rates
        $totalWeight = $this->getTotalWeightInKg($cart);
        $shippingRates = $this->getShippingRates($totalWeight);
        $deliveryFee = $shippingRates->first()->price ?? 0;

        // 5. Calculate total prices
        $subtotal = $cart->sum(fn ($item) => $item->price * $item->quantity);
        $totalPrice = $subtotal + $deliveryFee;

        return response()->json([
            'cart_items' => $cart->map(fn ($item) => [
                'id' => $item->id,
                'product_title' => $item->product->title,
                'quantity' => $item->quantity,
                'price' => (float) $item->price,
                'subtotal' => (float) ($item->price * $item->quantity),
                'size' => $item->size,
            ]),
            'shipping_addresses' => $shipping,
            'shipping_rates' => $shippingRates,
            'total_weight' => $totalWeight,
            'subtotal' => (float) $subtotal,
            'delivery_fee' => (float) $deliveryFee,
            'total_price' => (float) $totalPrice,
        ]);
    }

    /**
     * Process checkout and return Stripe Session URL for B2B orders.
     */
    public function processCheckout(Request $request)
    {
        $user = $request->user();

        // 1. Block if KYC is not approved
        if (!$user->isB2B()) {
            return response()->json([
                'error' => 'Your trade account is pending approval or has not been approved. Checkout is currently disabled.'
            ], 403);
        }

        // 2. Validate input
        $validator = Validator::make($request->all(), [
            'ship-address' => 'required',
            'address' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'shipping_rate_id' => 'required|exists:shipping_rates,id',
            'success_url' => 'nullable|url',
            'cancel_url' => 'nullable|url',
        ], [
            'ship-address.required' => 'Shipping address selection is required.',
            'city.required' => 'City is required.',
            'state.required' => 'State is required.',
            'country.required' => 'Country is required.',
            'postal_code.required' => 'Postal code is required.',
            'shipping_rate_id.required' => 'Please select a shipping option.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 3. Get B2B cart items
        $cartItems = Cart::where('user_id', $user->id)
            ->whereHas('product', function ($query) {
                $query->where('is_b2b', true);
            })
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Your B2B cart is empty.'], 400);
        }

        // 4. Retrieve shipping rate
        $shippingRate = ShippingRate::find($request->shipping_rate_id);
        $shippingDeliveryType = $shippingRate->delivery_type;
        $shippingPrice = $shippingRate->price;

        // Calculate order details
        $subtotal = $cartItems->sum(fn ($item) => $item->price * $item->quantity);
        $totalPrice = $subtotal + $shippingPrice;

        // 5. Update or create shipping address
        $addressData = $request->only(['city', 'state', 'country', 'postal_code', 'is_default']);
        $addressData['address'] = $request->address ?? '';

        $shippingAddress = ShippingAddress::updateOrCreate(
            ['user_id' => $user->id, 'is_default' => true],
            $addressData
        );

        // 6. Generate Invoice
        $invoiceNumber = OrderItem::generateInvoiceNumber();
        $orderItemIds = [];

        // 7. Create OrderItems
        foreach ($cartItems as $cartItem) {
            $orderItem = OrderItem::create([
                'user_id' => $user->id,
                'shipping_addresses_id' => $shippingAddress->id,
                'invoice_number' => $invoiceNumber,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'size' => $cartItem->size,
                'delivery_fee' => $shippingPrice,
                'shipping_delivery_type' => $shippingDeliveryType,
                'shipping_price' => $shippingPrice,
                'price' => $cartItem->price,
                'payment_method' => 'Stripe',
                'payment_status' => 0, // Unpaid
            ]);

            $orderItemIds[] = $orderItem->id;
        }

        // 8. Generate Stripe Checkout Session
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $successUrl = $request->success_url ?? route('stripe.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}';
            $cancelUrl = $request->cancel_url ?? route('stripe.checkout.cancel');

            $session = Session::create([
                'success_url' => $successUrl,
                'payment_method_types' => ['link', 'card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => 'Mightyolu B2B Trade Order ' . $invoiceNumber,
                        ],
                        'unit_amount' => (int) round(100 * $totalPrice),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'allow_promotion_codes' => false,
                'cancel_url' => $cancelUrl,
                'metadata' => [
                    'order_item_ids' => implode(',', $orderItemIds),
                    'invoice_number' => $invoiceNumber,
                    'user_id' => $user->id,
                ],
            ]);

            // 9. Clear the B2B Cart
            Cart::where('user_id', $user->id)
                ->whereHas('product', function ($query) {
                    $query->where('is_b2b', true);
                })
                ->delete();

            return response()->json([
                'message' => 'Order initiated successfully.',
                'invoice_number' => $invoiceNumber,
                'stripe_checkout_url' => $session->url,
            ]);

        } catch (\Exception $e) {
            Log::error('B2B Stripe Payment Session generation failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to generate payment session: ' . $e->getMessage()
            ], 500);
        }
    }
}
