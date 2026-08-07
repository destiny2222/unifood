<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

        $query = Product::where('is_b2b', 1)
            ->with(['volumeDiscounts', 'photos', 'category']);

        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category)
                  ->orWhere('title', $category);
            });
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float)$request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float)$request->input('max_price'));
        }

        if ($request->filled('sort')) {
            $sort = (string)$request->input('sort');
            switch ($sort) {
                case '1':
                case 'price_low_to_high':
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case '2':
                case 'price_high_to_low':
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case '3':
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case '4':
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                case '0':
                case 'newest':
                default:
                    $query->orderBy('id', 'desc');
                    break;
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        if ($request->has('per_page') || $request->has('page')) {
            $perPage = (int) $request->input('per_page', 9);
            $products = $query->paginate($perPage);
        } else {
            $products = $query->get();
        }

        // Map the products to include resolved trade pricing
        $products->transform(function ($product) use ($user) {
            $tradePrice = $product->getResolvedPrice($user, 1);
            
            return [
                'id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
                'image' => $product->images, // Main image as a string
                'product_images' => $product->photos->pluck('image_path'),
                'standard_price' => (float) $product->price,
                'availability' => $product->availability,
                'trade_price' => $tradePrice,
                'is_b2b' => $product->is_b2b,
                'category' => $product->category ? $product->category->title : null,
                'description' => $product->description,
                'minimum_order_quantity' => $product->minimum_order_quantity,
                'has_volume_discounts' => $product->volumeDiscounts->count() > 0,
            ];
        });

        return response()->json($products);
    }

    /**
     * Display categories list with product counts.
     */
    public function categories()
    {
        $categories = Category::whereHas('product', function($q) {
            $q->where('is_b2b', 1);
        })->withCount(['product' => function($q) {
            $q->where('is_b2b', 1);
        }])->get()->map(function($cat) {
            return [
                'id' => $cat->id,
                'title' => $cat->title,
                'slug' => $cat->slug,
                'products_count' => $cat->product_count,
            ];
        });

        return response()->json($categories);
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
            'availability' => $product->availability,
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
