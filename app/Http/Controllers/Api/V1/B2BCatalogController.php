<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class B2BCatalogController extends Controller
{
    /**
     * Display a listing of the B2B products.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $products = Product::where('is_b2b', true)
            ->with(['volumeDiscounts', 'photos'])
            ->paginate(15);

        // Map the products to include resolved trade pricing
        $products->getCollection()->transform(function ($product) use ($user) {
            $tradePrice = $product->getResolvedPrice($user, 1);
            
            return [
                'id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
                'image' => $product->images, // Main image as a string
                'product_images' => $product->photos->pluck('image_path'),
                
                'standard_price' => (float) $product->price,
                'trade_price' => $tradePrice,
                'is_b2b' => $product->is_b2b,
                'description' => $product->description,
                'minimum_order_quantity' => $product->minimum_order_quantity,
                'has_volume_discounts' => $product->volumeDiscounts->count() > 0,
            ];
        });

        return response()->json($products);
    }

    /**
     * Display the specified B2B product.
     */
    public function show(Request $request, $slug)
    {
        $user = $request->user();
        
        $product = Product::where('is_b2b', true)
            ->where('slug', $slug)
            ->with(['volumeDiscounts', 'category', 'photos'])
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found or not available for B2B'], 404);
        }

        $tradePrice = $product->getResolvedPrice($user, 1);

        $response = [
            'id' => $product->id,
            'title' => $product->title,
            'slug' => $product->slug,
            'description' => $product->description,
            'image' => $product->images, // Main image as a string
            'product_images' => $product->photos->pluck('image_path'), // Gallery images array
            'category' => $product->category ? $product->category->title : null,
            'standard_price' => (float) $product->price,
            'trade_price' => $tradePrice,
            'minimum_order_quantity' => $product->minimum_order_quantity,
            'volume_discounts' => $product->volumeDiscounts->map(function ($discount) {
                return [
                    'minimum_quantity' => $discount->minimum_quantity,
                    'discount_percentage' => (float) $discount->discount_percentage,
                ];
            }),
        ];

        return response()->json($response);
    }
}
