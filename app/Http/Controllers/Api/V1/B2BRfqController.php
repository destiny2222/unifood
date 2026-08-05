<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rfq;
use App\Models\RfqItem;
use Illuminate\Support\Str;

class B2BRfqController extends Controller
{
    /**
     * Submit a new Request for Quotation (RFQ).
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Unauthorized. Approved Business Account required.'], 403);
        }

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.product_variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
            'delivery_frequency' => 'nullable|string|in:one-off,weekly,monthly',
            'notes' => 'nullable|string',
        ]);

        $referenceNumber = 'RFQ-' . strtoupper(Str::random(8));

        $rfq = Rfq::create([
            'reference_number' => $referenceNumber,
            'kyc_id' => $user->kyc_id,
            'user_id' => $user->id,
            'status' => 'Pending',
            'delivery_frequency' => $request->delivery_frequency,
            'notes' => $request->notes,
        ]);

        foreach ($request->items as $item) {
            RfqItem::create([
                'rfq_id' => $rfq->id,
                'product_id' => $item['product_id'],
                'product_variant_id' => $item['product_variant_id'] ?? null,
                'quantity' => $item['quantity'],
            ]);
        }

        return response()->json([
            'message' => 'RFQ submitted successfully.',
            'rfq' => $rfq->load('items')
        ], 201);
    }

    /**
     * Get a list of RFQs for the current B2B account.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $rfqs = Rfq::where('kyc_id', $user->kyc_id)
            ->with(['items.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['rfqs' => $rfqs], 200);
    }

    /**
     * View a specific RFQ.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $rfq = Rfq::where('id', $id)
            ->where('kyc_id', $user->kyc_id)
            ->with(['items.product', 'user'])
            ->firstOrFail();

        return response()->json(['rfq' => $rfq], 200);
    }

    /**
     * Update the status of an RFQ (Accept, Decline, Request Changes).
     */
    public function updateStatus(Request $request, $id)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'action' => 'required|in:accept,decline,request_changes',
            'comment' => 'nullable|string'
        ]);

        $rfq = Rfq::where('id', $id)
            ->where('kyc_id', $user->kyc_id)
            ->firstOrFail();

        if ($rfq->status !== 'Quoted') {
            return response()->json(['message' => 'Only Quoted RFQs can be updated by the customer.'], 400);
        }

        if ($request->action === 'accept') {
            $rfq->status = 'Accepted';
            // Here, we would trigger order generation or PO creation.
        } elseif ($request->action === 'decline') {
            $rfq->status = 'Declined';
        } elseif ($request->action === 'request_changes') {
            $rfq->status = 'Pending';
            // Append the comment to notes or a separate comment thread.
            $rfq->notes = $rfq->notes . "\n\nChanges requested: " . $request->comment;
        }

        $rfq->save();

        return response()->json([
            'message' => 'RFQ status updated successfully.',
            'rfq' => $rfq
        ], 200);
    }
}
