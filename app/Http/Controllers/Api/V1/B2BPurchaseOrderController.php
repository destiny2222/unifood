<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\RecurringSchedule;
use App\Models\Product;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class B2BPurchaseOrderController extends Controller
{
    /**
     * Store a newly created Purchase Order.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Unauthorized. Approved Business Account required.'], 403);
        }

        $request->validate([
            'po_number' => 'nullable|string|max:255',
            'payment_method' => 'required|in:card,on_account',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.product_variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0', // In a real app, calculate on server to prevent spoofing
            'schedule_frequency' => 'nullable|in:weekly,monthly',
        ]);

        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }

        $discountData = \App\Models\DiscountRule::calculateDiscount($subtotal);
        $discountAmount = $discountData['discount_amount'];
        $finalTotalAmount = $subtotal - $discountAmount;

        // Credit Limit Check
        $kyc = $user->kyc;
        if ($request->payment_method === 'on_account') {
            // Check total unpaid non-draft orders
            $unpaidTotal = PurchaseOrder::where('user_id', $user->id)
                ->where('payment_method', 'on_account')
                ->where('status', '!=', 'Invoiced') // Or Paid
                ->where('is_draft', false)
                ->sum('total_amount');
            
            if (($unpaidTotal + $finalTotalAmount) > $kyc->credit_limit) {
                return response()->json([
                    'message' => 'Credit limit exceeded. Please use card payment or contact your account manager.',
                    'credit_limit' => $kyc->credit_limit,
                    'unpaid_balance' => $unpaidTotal,
                ], 400);
            }
        }

        $internalRef = 'PO-' . strtoupper(Str::random(8));

        $order = PurchaseOrder::create([
            'po_number' => $request->po_number,
            'internal_reference' => $internalRef,
            'user_id' => $user->id,
            'status' => 'Submitted',
            'payment_method' => $request->payment_method,
            'total_amount' => $finalTotalAmount,
            'discount_amount' => $discountAmount,
            'is_draft' => false,
            'is_recurring' => $request->has('schedule_frequency') && $request->schedule_frequency,
        ]);

        foreach ($request->items as $item) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_variant_id' => $item['product_variant_id'] ?? null,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);
        }

        // Create recurring schedule if frequency provided
        if ($request->schedule_frequency) {
            $nextRun = $request->schedule_frequency === 'weekly' ? Carbon::now()->addWeek() : Carbon::now()->addMonth();
            RecurringSchedule::create([
                'purchase_order_id' => $order->id,
                'kyc_id' => $kyc->id,
                'frequency' => $request->schedule_frequency,
                'next_run_date' => $nextRun,
                'is_active' => true,
            ]);
        }
        
        $checkoutUrl = null;
        
        if ($request->payment_method === 'card') {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            $lineItems = [];
            foreach ($order->items as $item) {
                // Ensure the related product is loaded
                $product = Product::find($item->product_id);
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product ? $product->name : 'Product #' . $item->product_id,
                        ],
                        'unit_amount' => (int) round($item->unit_price * 100),
                    ],
                    'quantity' => $item->quantity,
                ];
            }
            
            $frontendUrl = env('NEXT_PUBLIC_APP_URL', 'http://localhost:3000');
            
            try {
                $stripeDiscounts = [];
                if ($order->discount_amount > 0) {
                    $coupon = \Stripe\Coupon::create([
                        'amount_off' => (int) round($order->discount_amount * 100),
                        'currency' => 'usd',
                        'duration' => 'once',
                    ]);
                    $stripeDiscounts[] = [
                        'coupon' => $coupon->id,
                    ];
                }

                $checkout_session = Session::create([
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'success_url' => $frontendUrl . '/b2b/orders',
                    'cancel_url' => $frontendUrl . '/checkout',
                    'discounts' => $stripeDiscounts,
                    'metadata' => [
                        'purchase_order_id' => $order->id,
                    ],
                ]);
                $checkoutUrl = $checkout_session->url;
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to initiate Stripe payment: ' . $e->getMessage()], 500);
            }
        }

        return response()->json([
            'message' => 'Purchase Order submitted successfully.',
            'order' => $order->load('items'),
            'checkout_url' => $checkoutUrl
        ], 201);
    }

    /**
     * Get list of orders for the account.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user->isB2B()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        // Exclude drafts from standard index
        $orders = PurchaseOrder::where('user_id', $user->id)
            ->where('is_draft', false)
            ->with(['items.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['orders' => $orders], 200);
    }

    /**
     * Show single order.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        if (!$user->isB2B()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $order = PurchaseOrder::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['items.product', 'user'])
            ->firstOrFail();

        return response()->json(['order' => $order], 200);
    }

    /**
     * Setup recurring schedule on an existing order.
     */
    public function scheduleRecurring(Request $request, $id)
    {
        $user = $request->user();
        if (!$user->isB2B()) return response()->json(['message' => 'Unauthorized.'], 403);

        $request->validate(['frequency' => 'required|in:weekly,monthly']);

        $order = PurchaseOrder::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $order->is_recurring = true;
        $order->save();

        $nextRun = $request->frequency === 'weekly' ? Carbon::now()->addWeek() : Carbon::now()->addMonth();

        RecurringSchedule::updateOrCreate(
            ['purchase_order_id' => $order->id],
            [
                'kyc_id' => $user->kyc->id,
                'frequency' => $request->frequency,
                'next_run_date' => $nextRun,
                'is_active' => true,
            ]
        );

        return response()->json(['message' => 'Recurring schedule updated.']);
    }

    /**
     * Get drafts (from recurring schedules).
     */
    public function drafts(Request $request)
    {
        $user = $request->user();
        if (!$user->isB2B()) return response()->json(['message' => 'Unauthorized.'], 403);

        $drafts = PurchaseOrder::where('user_id', $user->id)
            ->where('is_draft', true)
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['drafts' => $drafts], 200);
    }

    /**
     * Approve a draft.
     */
    public function approveDraft(Request $request, $id)
    {
        $user = $request->user();
        if (!$user->isB2B()) return response()->json(['message' => 'Unauthorized.'], 403);

        $order = PurchaseOrder::where('id', $id)->where('user_id', $user->id)->where('is_draft', true)->firstOrFail();
        
        $order->is_draft = false;
        $order->status = 'Submitted';
        $order->save();

        return response()->json(['message' => 'Draft approved and submitted.', 'order' => $order], 200);
    }
}
