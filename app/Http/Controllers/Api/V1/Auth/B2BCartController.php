<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class B2BCartController extends Controller
{
    /**
     * Get the authenticated user's B2B cart items.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // Fetch B2B cart items (where product's is_b2b is true)
        $dbItems = Cart::with(['product.category'])
            ->where('user_id', $userId)
            ->whereHas('product', function ($query) {
                $query->where('is_b2b', true);
            })
            ->get();

        $cartItems = [];
        $totalPrice = 0;
        $totalQuantity = 0;

        foreach ($dbItems as $item) {
            // Determine base variant price if applicable
            $baseVariantPrice = null;
            if ($item->size) {
                $variant = $item->product->variants->where('size', $item->size)->first();
                if ($variant) {
                    $baseVariantPrice = $variant->price;
                }
            }
            if (!$baseVariantPrice && $item->product->has_variants && $item->product->variants->first()) {
                $baseVariantPrice = $item->product->variants->first()->price;
            }

            // Calculate dynamic price based on current quantity
            $dynamicPrice = $item->product->getResolvedPrice($request->user(), $item->quantity, $baseVariantPrice);
            $itemSubtotal = $item->quantity * $dynamicPrice;
            
            $totalPrice += $itemSubtotal;
            $totalQuantity += $item->quantity;

            $cartItems[] = [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_title' => $item->product->title,
                'product_slug' => $item->product->slug,
                'product_image' => $item->product->images,
                'quantity' => $item->quantity,
                'price' => (float) $dynamicPrice,
                'subtotal' => (float) $itemSubtotal,
                'size' => $item->size ?? 'N/A',
                'category_name' => $item->product->category->title ?? 'N/A',
            ];
        }

        return response()->json([
            'items' => $cartItems,
            'total_price' => (float) $totalPrice,
            'total_quantity' => $totalQuantity,
        ]);
    }

    /**
     * Add a B2B product/variant to the cart.
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'size_variant' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $productId = (int) $request->product_id;
        $quantity = (int) ($request->quantity ?? 1);
        $size = $request->size_variant ?? null;
        $user = $request->user();

        $product = Product::with('variants')->findOrFail($productId);

        if (!$product->is_b2b) {
            return response()->json([
                'error' => 'This product is not a B2B product.'
            ], 400);
        }

        // Determine correct base price
        $baseVariantPrice = null;
        if ($size) {
            $variant = $product->variants->where('size', $size)->first();
            if ($variant) {
                $baseVariantPrice = $variant->price;
            }
        }

        if (!$baseVariantPrice) {
            if ($product->has_variants && $product->variants->first()) {
                $baseVariantPrice = $product->variants->first()->price;
                $size = $product->variants->first()->size;
            }
        }

        // Fetch or create B2B cart item
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->when($size, fn ($q) => $q->where('size', $size),
                        fn ($q) => $q->whereNull('size'))
            ->first();

        $existingQuantity = $cartItem ? $cartItem->quantity : 0;
        $totalQuantity = $existingQuantity + $quantity;

        // Get resolved price for the new total quantity
        $resolvedPrice = $product->getResolvedPrice($user, $totalQuantity, $baseVariantPrice);

        if ($cartItem) {
            $cartItem->quantity = $totalQuantity;
            $cartItem->price = $resolvedPrice; // update stored price too
            $message = 'Cart item quantity has been increased.';
        } else {
            $cartItem = new Cart();
            $cartItem->user_id = $user->id;
            $cartItem->product_id = $productId;
            $cartItem->quantity = $quantity;
            $cartItem->size = $size;
            $cartItem->price = $resolvedPrice;
            $message = 'Product added to B2B cart.';
        }

        $cartItem->save();

        return response()->json([
            'message' => $message,
            'cart_item' => $cartItem,
        ], 201);
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = $request->user()->id;
        $cartItem = Cart::with('product')->where('user_id', $userId)
            ->where('id', $id)
            ->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }

        $minQty = $cartItem->product->minimum_order_quantity ?? 1;
        $newQuantity = (int) $request->quantity;
        if ($newQuantity < $minQty) {
            return response()->json([
                'error' => "Quantity cannot be less than the minimum order quantity of {$minQty}."
            ], 400);
        }

        // Determine base variant price if applicable
        $baseVariantPrice = null;
        if ($cartItem->size) {
            $variant = $cartItem->product->variants->where('size', $cartItem->size)->first();
            if ($variant) {
                $baseVariantPrice = $variant->price;
            }
        }
        if (!$baseVariantPrice && $cartItem->product->has_variants && $cartItem->product->variants->first()) {
            $baseVariantPrice = $cartItem->product->variants->first()->price;
        }

        // Get resolved price for the new quantity
        $resolvedPrice = $cartItem->product->getResolvedPrice($request->user(), $newQuantity, $baseVariantPrice);

        $cartItem->update([
            'quantity' => $newQuantity,
            'price' => $resolvedPrice, // update stored price
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully.',
            'cart_item' => $cartItem,
        ]);
    }

    /**
     * Remove a specific B2B cart item.
     */
    public function destroy(Request $request, $id)
    {
        $userId = $request->user()->id;
        $cartItem = Cart::where('user_id', $userId)
            ->where('id', $id)
            ->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }

        $cartItem->delete();

        return response()->json([
            'message' => 'Cart item removed successfully.'
        ]);
    }

    /**
     * Clear all B2B cart items.
     */
    public function clear(Request $request)
    {
        $userId = $request->user()->id;

        Cart::where('user_id', $userId)
            ->whereHas('product', function ($query) {
                $query->where('is_b2b', true);
            })
            ->delete();

        return response()->json([
            'message' => 'B2B cart cleared successfully.'
        ]);
    }
}
