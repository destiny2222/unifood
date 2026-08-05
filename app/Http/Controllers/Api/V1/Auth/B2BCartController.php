<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\B2BCart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class B2BCartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $items = B2BCart::with(['product.category', 'product.variants', 'variant'])
            ->where('user_id', $user->id)
            ->get();

        $cartItems = [];
        $totalPrice = 0;
        $totalQuantity = 0;

        foreach ($items as $item) {
            $baseVariantPrice = $item->variant?->price ?? null;

            $dynamicPrice = $item->product->getResolvedPrice($user, $item->quantity, $baseVariantPrice);
            $subtotal = $item->quantity * $dynamicPrice;

            $totalPrice += $subtotal;
            $totalQuantity += $item->quantity;

            $cartItems[] = [
                'id'            => $item->id,
                'product_id'    => $item->product_id,
                'product_title' => $item->product->title,
                'product_slug'  => $item->product->slug,
                'product_image' => $item->product->images,
                'quantity'      => $item->quantity,
                'price'         => (float) $dynamicPrice,
                'subtotal'      => (float) $subtotal,
                'size'          => $item->size ?? 'N/A',
                'category_name' => $item->product->category->title ?? 'N/A',
                'variant_id'    => $item->product_variant_id,
            ];
        }

        return response()->json([
            'items'          => $cartItems,
            'total_price'    => (float) $totalPrice,
            'total_quantity' => $totalQuantity,
        ]);
    }

    public function add(Request $request)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'product_id'         => 'required|integer|exists:products,id',
            'quantity'           => 'nullable|integer|min:1',
            'size_variant'       => 'nullable|string',
            'product_variant_id' => 'nullable|integer|exists:product_variants,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::with('variants')->findOrFail($request->product_id);

        if (!$product->is_b2b) {
            return response()->json(['error' => 'This product is not available for B2B.'], 400);
        }

        $quantity = (int) ($request->quantity ?? 1);
        $size = $request->size_variant;
        $variantId = $request->product_variant_id;

        // Resolve variant
        $variant = null;
        if ($variantId) {
            $variant = $product->variants->firstWhere('id', $variantId);
        } elseif ($size) {
            $variant = $product->variants->firstWhere('size', $size);
        }

        $baseVariantPrice = $variant?->price;
        $size = $variant?->size ?? $size;

        $cartItem = B2BCart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->when($variant, fn ($q) => $q->where('product_variant_id', $variant->id))
            ->when(!$variant && $size, fn ($q) => $q->where('size', $size))
            ->when(!$variant && !$size, fn ($q) => $q->whereNull('product_variant_id')->whereNull('size'))
            ->first();

        $existingQty = $cartItem?->quantity ?? 0;
        $totalQty = $existingQty + $quantity;

        $minQty = $product->minimum_order_quantity ?? 1;
        if ($totalQty < $minQty) {
            return response()->json([
                'error' => "Minimum order quantity is {$minQty}."
            ], 400);
        }

        $resolvedPrice = $product->getResolvedPrice($user, $totalQty, $baseVariantPrice);

        if ($cartItem) {
            $cartItem->update([
                'quantity'   => $totalQty,
                'unit_price' => $resolvedPrice,
            ]);
            $message = 'Cart item quantity updated.';
        } else {
            $cartItem = B2BCart::create([
                'user_id'            => $user->id,
                'product_id'         => $product->id,
                'product_variant_id' => $variant?->id,
                'quantity'           => $quantity,
                'unit_price'         => $resolvedPrice,
                'size'               => $size,
            ]);
            $message = 'Product added to B2B cart.';
        }

        return response()->json([
            'message'   => $message,
            'cart_item' => $cartItem->load('product'),
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cartItem = B2BCart::with('product.variants')
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $newQty = (int) $request->quantity;
        $minQty = $cartItem->product->minimum_order_quantity ?? 1;

        if ($newQty < $minQty) {
            return response()->json([
                'error' => "Quantity cannot be less than the minimum order quantity of {$minQty}."
            ], 400);
        }

        $baseVariantPrice = $cartItem->variant?->price
            ?? $cartItem->product->variants->firstWhere('size', $cartItem->size)?->price;

        $resolvedPrice = $cartItem->product->getResolvedPrice($user, $newQty, $baseVariantPrice);

        $cartItem->update([
            'quantity'   => $newQty,
            'unit_price' => $resolvedPrice,
        ]);

        return response()->json([
            'message'   => 'Cart updated successfully.',
            'cart_item' => $cartItem,
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $cartItem = B2BCart::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $cartItem->delete();

        return response()->json(['message' => 'Cart item removed successfully.']);
    }

    public function clear(Request $request)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        B2BCart::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'B2B cart cleared successfully.']);
    }
}
