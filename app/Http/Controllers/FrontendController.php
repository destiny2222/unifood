<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
    public function index(){
        $Product = Product::orderBy('id', 'DESC')->get()->take(8);
        $category = Category::orderBy('id', 'DESC')->get()->take(5);
        $blog = Post::where('show_homepage' , 1)->get();
        return view('frontend.index', [
            'products' => $Product,
            'categories' => $category,
            'blogs'=> $blog,
        ]);
    }

    public function about(){
        return view('frontend.about');
    }

    public function contact(){
        return view('frontend.contact');
    }



    public function product(){
        $categories = Category::orderBy('id', 'desc')->get();
        $product = Product::orderBy('id', 'desc')->paginate(12);
        return view('frontend.product', [
            'categories' => $categories,
            'products' => $product,
        ]);
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
        $blog = Post::orderBy('id' , 'desc')->get();
        return view('frontend.blog', [
            'blogs'=>$blog,
        ]);
    }

    public function blogDetails(Post $post){
        $recentPost = Post::orderBy('id', 'desc')->latest()->take(3)->get();
        $categories = PostCategory::withCount('posts')->get();
        return view('frontend.blog_details', [
            'post'=>$post,
            'recentPosts'=>$recentPost,
            'categories'=>$categories
        ]);
    }

public function searchProduct(Request $request)
{
    $query = Product::query();


    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Filter by category 
    if ($request->filled('category')) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('title', $request->category);
        });
        
        // Option 2: If you store category title directly in products table
        // $query->where('category', $request->category);
        
        // Option 3: If you have category_id and want to search by ID
        // $query->where('category_id', $request->category);
    }

    // Execute the query and get results
    $products = $query->get(); // or ->paginate(12)
    dd($products);
    
    return view('frontend.product_search', compact('products'));
}

    public function searchBlog(Request $request) {
        $query = $request->input('query');

        $blogs = Post::where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->latest()
            ->paginate(9);

        return view('frontend.blog', compact('blogs', 'query'));
    }

    public function searchEngine(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('title', '!=', Null)
            ->where(function ($query) use ($search) {
            $query->where('title', 'LIKE', "%{$search}%")
                ->orWhereHas('category', function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%");
                });
            })
            ->paginate(6);
            if (!$search) {
                return redirect()->route('frontend.index')->with('error', 'Your request was not found.');
            }
        return view('frontend.search', compact('products'));
    }

    public function commentStore(Request $request, Post $post){
       try {
         $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'comment_body' => 'required|string',
        ]);

        
        $comment = new Comment([
            'name'=> $request->input('name'),
            'email' => $request->input('email'),
            'comment_body' => $request->input('comment_body'),
        ]);
        // $comment->user()->associate($request->user()); // $comment->post()->associate($post);
        $post->comments()->save($comment);

        return back()->with('success', 'Comment posted successfully!');
       } catch (\Exception $exception) {
          Log::error($exception->getMessage());
          return back()->with('error', 'Something went wrong, please try again later.');
       }
    }
}
