<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class B2BWishListController extends Controller
{
   public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $wishlists = B2BWishlist::with(['product.photos', 'product.category'])
            ->where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($item) use ($user) {
                $product = $item->product;
                $tradePrice = $product->getResolvedPrice($user, 1);

                return [
                    'id'                   => $item->id,
                    'product_id'           => $product->id,
                    'title'                => $product->title,
                    'slug'                 => $product->slug,
                    'image'                => $product->images,
                    'product_images'       => $product->photos->pluck('image_path'),
                    'standard_price'       => (float) $product->price,
                    'trade_price'          => $tradePrice,
                    'minimum_order_quantity' => $product->minimum_order_quantity,
                    'category'             => $product->category?->title,
                    'added_at'             => $item->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $wishlists,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
                Rule::unique('b2b_wishlists')->where(fn ($q) => $q->where('user_id', $user->id)),
            ],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (!$product->is_b2b) {
            return response()->json(['error' => 'This product is not available for B2B.'], 400);
        }

        $wishlist = B2BWishlist::create([
            'user_id'    => $user->id,
            'product_id' => $product->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to B2B wishlist.',
            'data'    => $wishlist->load('product'),
        ], 201);
    }

    public function destroy(Request $request, string $id)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $wishlist = B2BWishlist::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from B2B wishlist.',
        ]);
    }

    /**
     * Move item from wishlist to B2B cart
     */
    public function moveToCart(Request $request, string $id)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $wishlist = B2BWishlist::with('product.variants')
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'quantity'           => 'nullable|integer|min:1',
            'size_variant'       => 'nullable|string',
            'product_variant_id' => 'nullable|integer|exists:product_variants,id',
        ]);

        // Reuse the cart add logic
        $cartController = app(B2BCartController::class);
        $addRequest = new Request([
            'product_id'         => $wishlist->product_id,
            'quantity'           => $request->quantity ?? 1,
            'size_variant'       => $request->size_variant,
            'product_variant_id' => $request->product_variant_id,
        ]);
        $addRequest->setUserResolver(fn () => $user);

        $response = $cartController->add($addRequest);

        if ($response->getStatusCode() === 201) {
            $wishlist->delete();
        }

        return $response;
    }
}
