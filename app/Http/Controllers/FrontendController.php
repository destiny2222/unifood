<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Models\Admin;
use App\Models\Advertisement;
use App\Models\AppSection;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\ContactPage;
use App\Models\Counter;
use App\Models\Faq;
use App\Models\Newslatter;
use App\Models\Policy;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Terms;
use App\Models\Testimonial;
use App\Models\WhyChooseUS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FrontendController extends Controller
{
    public function index()
    {
        $Product = Product::orderBy('id', 'DESC')->paginate(12);
        $category = Category::orderBy('id', 'asc')->get()->take(6);
        $blog = Post::where('show_homepage', 1)->get();
        $services = Service::orderBy('id', 'DESC')->get();
        $sliders = Slider::orderBy('id', 'DESC')->get();
        $dailyOffer = Product::where('today_special', 1)->get();
        $advertisements = Advertisement::orderBy('id', 'DESC')->get();
        $counter = Counter::orderBy('id', 'DESC')->get();
        $appSection = AppSection::first();
        $testimonial = Testimonial::orderBy('id', 'DESC')->get();

        // $countCarts = session('cart', []);
        // dd($countCarts);
        // session()->forget('cart');

        return view('frontend.index', [
            'products' => $Product,
            'categories' => $category,
            'blogs' => $blog,
            'services' => $services,
            'sliders' => $sliders,
            'dailyOffers' => $dailyOffer,
            'advertisements' => $advertisements,
            'appSection' => $appSection,
            'counters' => $counter,
            'testimonials' => $testimonial
        ]);
    }

    public function about()
    {
        $about = AboutPage::first();
        $whyChooseUs = WhyChooseUS::first();
        $counter = Counter::orderBy('id', 'DESC')->get();
        $testimonial = Testimonial::orderBy('id', 'DESC')->get();
        return view('frontend.about', [
            'about' => $about,
            'whyChooseUs' => $whyChooseUs,
            'counters' => $counter,
            'testimonials' => $testimonial
        ]);
    }

    public function contact()
    {
        $contact = ContactPage::first();
        return view('frontend.contact', [
            'contact' => $contact
        ]);
    }

    // public function product()
    // {
    //     $categories = Category::orderBy('id', 'desc')->get();
    //     $product = Product::paginate(12);
    //     return view('frontend.product', [
    //         'categories' => $categories,
    //         'products' => $product,
    //     ]);
    // }


    public function product(Request $request)
    {
        // Get categories with product count
        $categories = Category::withCount('product')
                            ->orderBy('title', 'asc')
                            ->get();
        
        // Filter products by category if category parameter exists
        $query = Product::query();
        
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        $products = $query->paginate(9);
        
        return view('frontend.product', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    // public function product(Request $request)
    // {
    //     // Get categories with product count
    //     $categories = Category::withCount('product')->orderBy('title', 'asc')->get();
        
    //     $query = Product::with('category');
        
    //     // Filter by category if exists
    //     if ($request->has('category') && $request->category != '') {
    //         $query->whereHas('category', function($q) use ($request) {
    //             $q->where('slug', $request->category);
    //         });
    //     }
        
    //     // Filter by search term if exists
    //     if ($request->has('search') && $request->search != '') {
    //         $searchTerm = $request->search;
    //         $query->where(function($q) use ($searchTerm) {
    //             $q->where('title', 'LIKE', "%{$searchTerm}%")
    //             ->orWhere('description', 'LIKE', "%{$searchTerm}%")
    //             ->orWhereHas('category', function($categoryQuery) use ($searchTerm) {
    //                 $categoryQuery->where('title', 'LIKE', "%{$searchTerm}%");
    //             });
    //         });
    //     }
        
    //     // ordering
    //     $query->orderBy('created_at', 'desc');
        
    //     // Paginate 
    //     $products = $query->paginate(9);
        
    //     $products->appends($request->query());
        
    //     return view('frontend.product', [
    //         'categories' => $categories,
    //         'products' => $products,
    //         'searchTerm' => $request->get('search', ''),
    //         'selectedCategory' => $request->get('category', '')
    //     ]);
    // }

    // Add this method for category-specific products
    public function productsByCategory(Request $request, $categorySlug)
    {
        $categories = Category::withCount('product')
                            ->orderBy('title', 'asc')
                            ->get();
        
        $products = Product::whereHas('category', function($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        })->paginate(9);
        
        return view('frontend.product', [
            'categories' => $categories,
            'products' => $products,
            'selectedCategory' => $categorySlug
        ]);
    }

    public function product_show(Product $product){
        return view('partials.product_modal', [
            'product' => $product,
        ]);
    }

    

    public function productDetails(Product $product)
    {
        $relatedProducts = Product::where('category_id', $product->category_id)->get();

        // dd($relatedProducts);
        return view('frontend.product_details', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,

        ]);
    }

    public function blog()
    {
        $blog = Post::orderBy('id', 'desc')->get();
        return view('frontend.blog', [
            'blogs' => $blog,
        ]);
    }

    public function blogDetails(Post $post)
    {
        $recentPost = Post::orderBy('id', 'desc')->latest()->take(3)->get();
        $categories = PostCategory::withCount('posts')->get();
        return view('frontend.blog_details', [
            'post' => $post,
            'recentPosts' => $recentPost,
            'categories' => $categories
        ]);
    }

    

    public function searchBlog(Request $request)
    {
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
        
        if (!$search) {
            return redirect()->route('frontend.index')->with('error', 'Your request was not found.');
        }
        
        // Get categories for sidebar
        $categories = Category::withCount('product')
                            ->orderBy('title', 'asc')
                            ->get();
        
        // Search products
        $products = Product::where('title', '!=', null)
            ->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%") // Added description search
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('title', 'LIKE', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(9); // Changed to match your other pagination
        
        // Append search term to pagination links
        $products->appends(['search' => $search]);
        
        return view('frontend.product_search', [
            'products' => $products,
            'categories' => $categories,
            'searchTerm' => $search
        ]);
    }

    public function commentStore(Request $request, Post $post)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'comment_body' => 'required|string',
            ]);


            $comment = new Comment([
                'name' => $request->input('name'),
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

    public function terms()
    {
        $terms = Terms::first();
        return view('frontend.terms', compact('terms'));
    }

    public function privacy()
    {
        $privacy = Policy::first();
        return view('frontend.privacy', compact('privacy'));
    }

    public function faq()
    {
        $faqs = Faq::orderBy('id', 'desc')->get();
        return view('frontend.faq', compact('faqs'));
    }

    public function contactStore(Request $request)
    {
        $contact = new Contact([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);
        try{
            $contact->save();
            // mail administrator
            $admins = Admin::all();
            foreach ($admins as $admin) {
                Mail::raw(
                    "You have received a new contact message:\n\nName: {$contact->name}\nEmail: {$contact->email}\nPhone: {$contact->phone}\nSubject: {$contact->subject}\nMessage: {$contact->message}",
                    function ($message) use ($admin) {
                        $message->to($admin->email)
                                ->subject('New Contact Message');
                    }
                );
            }
            return back()->with('success', 'Message sent successfully!');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('error', 'An error occurred while sending the message. Please try again later.');
        }
    }


    public function subscribe(Request $request){
         $validator = Validator::make($request->all(), [
        'email' => 'required|email|unique:newslatters,email',
    ], [
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already subscribed.',
    ]);

    if ($validator->fails()) {
        return back()->with('error', $validator->errors()->first())->withInput();
    }

        Newslatter::create(['email' => $request->email]);

        return back()->with('success', 'You have successfully subscribed!');
    }
}
