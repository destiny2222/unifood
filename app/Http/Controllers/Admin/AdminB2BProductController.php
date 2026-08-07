<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminB2BProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_b2b', 1)->with(['category', 'volumeDiscounts', 'photos']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $products = $query->orderBy('id', 'desc')->paginate(15);
        $categories = Category::orderBy('title', 'asc')->get();

        return view('admin.b2b_products.index', compact('products', 'categories'));
    }

    public function toggleB2b($id)
    {
        $product = Product::findOrFail($id);
        $product->is_b2b = !$product->is_b2b;
        $product->save();

        return back()->with('success', 'Product B2B status updated successfully.');
    }

    public function bulkDelete(Request $request)
    {
        if ($request->has('delete_all_category') && $request->filled('category_id')) {
            $count = Product::where('is_b2b', 1)->where('category_id', $request->input('category_id'))->delete();
            return back()->with('success', "Successfully deleted {$count} B2B products in the selected category.");
        }

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        $count = Product::whereIn('id', $request->input('ids'))->delete();

        return back()->with('success', "Successfully deleted {$count} selected products.");
    }
}
