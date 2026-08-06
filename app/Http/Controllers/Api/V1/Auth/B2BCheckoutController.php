<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\B2BCart;
use App\Models\B2BShippingAddress;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\RecurringSchedule; 
use App\Models\ShippingRate;
use App\Traits\ShippingCost;
use App\Traits\WeightConversion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Stripe;


class B2BCheckoutController extends Controller
{
    use WeightConversion, ShippingCost;

    /**
     * Get details needed for B2B Checkout.
     */
    public function getCheckoutDetails(Request $request)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json([
                'error' => 'Your trade account is pending approval or has not been approved. Checkout is currently disabled.'
            ], 403);
        }

        $cart = B2BCart::with(['product', 'variant'])
            ->where('user_id', $user->id)
            ->get();

        if ($cart->isEmpty()) {
            return response()->json([
                'error' => 'Please add items to your B2B cart first.'
            ], 400);
        }

        $shipping = B2BShippingAddress::where('user_id', $user->id)->get();

        $totalWeight = $this->getTotalWeightInKg($cart);
        $shippingRates = $this->getShippingRates($totalWeight);
        $deliveryFee = $shippingRates->first()->price ?? 0;

        $subtotal = 0;
        $cartItems = [];

        foreach ($cart as $item) {
            $baseVariantPrice = $item->variant?->price ?? null;
            $dynamicPrice = $item->product->getResolvedPrice($user, $item->quantity, $baseVariantPrice);
            $itemSubtotal = $item->quantity * $dynamicPrice;
            $subtotal += $itemSubtotal;

            $cartItems[] = [
                'id'            => $item->id,
                'product_id'    => $item->product_id,
                'product_title' => $item->product->title,
                'quantity'      => $item->quantity,
                'price'         => (float) $dynamicPrice,
                'subtotal'      => (float) $itemSubtotal,
                'size'          => $item->size ?? 'N/A',
                'variant_id'    => $item->product_variant_id,
            ];
        }

        $discountData = \App\Models\DiscountRule::calculateDiscount($subtotal);
        $discountAmount = $discountData['discount_amount'];
        $totalPrice = $subtotal + $deliveryFee - $discountAmount;

        // Credit info for frontend
        $kyc = $user->kyc;
        $unpaidTotal = PurchaseOrder::where('user_id', $user->id)
            ->where('payment_method', 'on_account')
            ->where('status', '!=', 'Invoiced')
            ->where('is_draft', false)
            ->sum('total_amount');

        return response()->json([
            'cart_items'         => $cartItems,
            'shipping_addresses' => $shipping,
            'shipping_rates'     => $shippingRates,
            'total_weight'       => $totalWeight,
            'subtotal'           => (float) $subtotal,
            'delivery_fee'       => (float) $deliveryFee,
            'discount_amount'    => (float) $discountAmount,
            'discount_percentage'=> (float) $discountData['discount_percentage'],
            'total_price'        => (float) $totalPrice,
            'credit_limit'       => (float) $kyc->credit_limit,
            'unpaid_balance'     => (float) $unpaidTotal,
            'available_credit'   => (float) max(0, $kyc->credit_limit - $unpaidTotal),
        ]);
    }

    /**
     * Process checkout → Create PurchaseOrder + PurchaseOrderItems
     */
    public function processCheckout(Request $request)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json([
                'error' => 'Your trade account is pending approval or has not been approved. Checkout is currently disabled.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'payment_method'     => 'required|in:card,on_account',
            'po_number'          => 'nullable|string|max:255',
            'ship-address'       => 'required',
            'address'            => 'nullable|string|max:255',
            'city'               => 'required|string|max:255',
            'state'              => 'required|string|max:255',
            'country'            => 'required|string|max:255',
            'postal_code'        => 'required|string|max:10',
            'shipping_rate_id'   => 'required|exists:shipping_rates,id',
            'schedule_frequency' => 'nullable|in:weekly,monthly',
            'success_url'        => 'nullable|url',
            'cancel_url'         => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cartItems = B2BCart::with(['product', 'variant'])
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Your B2B cart is empty.'], 400);
        }

        $kyc = $user->kyc;
        $shippingRate = ShippingRate::findOrFail($request->shipping_rate_id);
        $shippingPrice = $shippingRate->price;

        // Calculate totals with live trade pricing
        $subtotal = 0;
        $preparedItems = [];

        foreach ($cartItems as $item) {
            $baseVariantPrice = $item->variant?->price ?? null;
            $unitPrice = $item->product->getResolvedPrice($user, $item->quantity, $baseVariantPrice);
            $lineTotal = $item->quantity * $unitPrice;
            $subtotal += $lineTotal;

            $preparedItems[] = [
                'product_id'         => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'quantity'           => $item->quantity,
                'unit_price'         => $unitPrice,
                'size'               => $item->size,
            ];
        }

        $discountData = \App\Models\DiscountRule::calculateDiscount($subtotal);
        $discountAmount = $discountData['discount_amount'];
        $totalAmount = $subtotal + $shippingPrice - $discountAmount;

        // Credit limit check for on_account
        if ($request->payment_method === 'on_account') {
            $unpaidTotal = PurchaseOrder::where('user_id', $user->id)
                ->where('payment_method', 'on_account')
                ->where('status', '!=', 'Invoiced')
                ->where('is_draft', false)
                ->sum('total_amount');

            if (($unpaidTotal + $totalAmount) > $kyc->credit_limit) {
                return response()->json([
                    'message'        => 'Credit limit exceeded. Please use card payment or contact your account manager.',
                    'credit_limit'   => $kyc->credit_limit,
                    'unpaid_balance' => $unpaidTotal,
                    'order_total'    => $totalAmount,
                ], 400);
            }
        }

        // Get or Create shipping address
        if ($request->shipping_address_id) {
            $shippingAddress = B2BShippingAddress::where('user_id', $user->id)
                ->findOrFail($request->shipping_address_id);
        } else {
            $addressData = [
                'label'                => $request->label ?? 'Default',
                'company_name'         => $request->company_name,
                'contact_name'         => $request->contact_name ?? $user->name,
                'phone'                => $request->phone ?? $user->phone,
                'address_line_1'       => $request->input('ship-address') ?? $request->address ?? $request->address_line_1,
                'address_line_2'       => $request->address_line_2,
                'city'                 => $request->city,
                'state'                => $request->state,
                'postal_code'          => $request->postal_code,
                'country'              => $request->country,
                'is_default'           => true,
                'delivery_instructions'=> $request->delivery_instructions,
            ];

            // Make sure only one default exists
            B2BShippingAddress::where('user_id', $user->id)
                ->where('is_default', true)
                ->update(['is_default' => false]);

            $shippingAddress = B2BShippingAddress::create(array_merge([
                'user_id'    => $user->id,
            ], $addressData));
        }

        // Create Purchase Order
        $internalRef = 'PO-' . strtoupper(Str::random(8));

        $order = PurchaseOrder::create([
            'po_number'          => $request->po_number,
            'internal_reference' => $internalRef,
            'user_id'            => $user->id,
            'status'             => 'Submitted',
            'payment_method'     => $request->payment_method,
            'total_amount'       => $totalAmount,
            'shipping_amount'    => $shippingPrice,
            'discount_amount'    => $discountAmount,
            'is_draft'           => false,
            'is_recurring'       => !empty($request->schedule_frequency),
            // Optional: store shipping address reference if your table has the column
            'shipping_address_id' => $shippingAddress->id,
        ]);

        // Create Purchase Order Items
        foreach ($preparedItems as $item) {
            PurchaseOrderItem::create([
                'purchase_order_id'  => $order->id,
                'product_id'         => $item['product_id'],
                'product_variant_id' => $item['product_variant_id'],
                'quantity'           => $item['quantity'],
                'unit_price'         => $item['unit_price'],
                // 'size'            => $item['size'], // add if your table has this column
            ]);
        }

        // Recurring schedule
        if ($request->schedule_frequency) {
            $nextRun = $request->schedule_frequency === 'weekly'
                ? Carbon::now()->addWeek()
                : Carbon::now()->addMonth();

            RecurringSchedule::create([
                'purchase_order_id' => $order->id,
                'kyc_id'            => $kyc->id,
                'frequency'         => $request->schedule_frequency,
                'next_run_date'     => $nextRun,
                'is_active'         => true,
            ]);
        }

        $checkoutUrl = null;

        // Stripe for card payments
        if ($request->payment_method === 'card') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $lineItems = [];
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => $product ? $product->title : 'Product #' . $item->product_id,
                        ],
                        'unit_amount' => (int) round($item->unit_price * 100),
                    ],
                    'quantity' => $item->quantity,
                ];
            }

            // Add shipping as a line item
            if ($shippingPrice > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => 'Shipping',
                        ],
                        'unit_amount' => (int) round($shippingPrice * 100),
                    ],
                    'quantity' => 1,
                ];
            }

            $frontendUrl = env('NEXT_PUBLIC_APP_URL', 'http://localhost:3000');

            try {
                $stripeDiscounts = [];
                if ($order->discount_amount > 0) {
                    $coupon = \Stripe\Coupon::create([
                        'amount_off' => (int) round($order->discount_amount * 100),
                        'currency' => 'gbp',
                        'duration' => 'once',
                    ]);
                    $stripeDiscounts[] = [
                        'coupon' => $coupon->id,
                    ];
                }

                $session = Session::create([
                    'line_items'  => $lineItems,
                    'mode'        => 'payment',
                    'success_url' => $request->success_url ?? $frontendUrl . '/b2b/orders?success=1',
                    'cancel_url'  => $request->cancel_url ?? $frontendUrl . '/b2b/checkout',
                    'discounts'   => $stripeDiscounts,
                    'metadata'    => [
                        'purchase_order_id' => $order->id,
                        'user_id'           => $user->id,
                    ],
                ]);

                $checkoutUrl = $session->url;
            } catch (\Exception $e) {
                Log::error('B2B Stripe session failed: ' . $e->getMessage());

                // Optionally delete the order if Stripe fails
                // $order->items()->delete();
                // $order->delete();

                return response()->json([
                    'message' => 'Failed to initiate Stripe payment: ' . $e->getMessage()
                ], 500);
            }
        }

        // Clear B2B Cart
        B2BCart::where('user_id', $user->id)->delete();

        return response()->json([
            'message'      => 'Purchase Order submitted successfully.',
            'order'        => $order->load('items.product'),
            'checkout_url' => $checkoutUrl, // null when payment_method = on_account
        ], 201);
    }
}
