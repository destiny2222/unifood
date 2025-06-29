<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){
        $Product = Product::orderBy('id', 'DESC')->get()->take(8);
        $category = Category::orderBy('id', 'DESC')->get()->take(5);
        return view('frontend.index', [
            'products' => $Product,
            'categories' => $category,
        ]);
    }

    public function about(){
        return view('frontend.about');
    }

    public function contact(){
        return view('frontend.contact');
    }


    public function product(){
        return view('frontend.product');
    }

    public function productDetails(Product $product){
        $relatedProducts = Product::where('category_id', $product->category_id)->get();
        // dd($relatedProducts);
        return view('frontend.product_details', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function blog(){
        return view('frontend.blog');
    }
}
