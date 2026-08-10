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
    $Product = Product::where('is_b2b', false)
                      ->orderBy('id', 'asc')
                      ->paginate(12);

    $category = Category::orderBy('id', 'asc')->get()->take(6);
    $blog = Post::where('show_homepage', 1)->get();
    $services = Service::orderBy('id', 'DESC')->get();
    $sliders = Slider::orderBy('id', 'DESC')->get();

    $dailyOffer = Product::where('today_special', 1)
                         ->where('is_b2b', false)
                         ->get();

    $advertisements = Advertisement::orderBy('id', 'DESC')->get();
    $counter = Counter::orderBy('id', 'DESC')->get();
    $appSection = AppSection::first();
    $testimonial = Testimonial::orderBy('id', 'DESC')->get();

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
    $categories = Category::withCount(['product' => function ($q) {
                        $q->where('is_b2b', false);
                    }])
                    ->orderBy('title', 'asc')
                    ->get();

    $query = Product::where('is_b2b', false);

    if ($request->has('category') && $request->category != '') {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }

    $products = $query->paginate(9);

    return view('frontend.product', [
        'categories' => $categories,
        'products' => $products,
    ]);
}

    
    // Add this method for category-specific products
    public function productsByCategory(Request $request, $categorySlug)
    {
        $categories = Category::withCount(['product' => function ($q) {
                            $q->where('is_b2b', false);
                        }])
                        ->orderBy('title', 'asc')
                        ->get();
        
        $products = Product::where('is_b2b', false)
            ->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug)
                  ->orWhere('id', $categorySlug);
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
    // Optional: prevent viewing a B2B product on the public frontend
    if ($product->is_b2b) {
        abort(404);
    }

    $relatedProducts = Product::where('category_id', $product->category_id)
                              ->where('is_b2b', false)
                              ->where('id', '!=', $product->id) // usually exclude current product
                              ->get();

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
        $products = Product::where('is_b2b', false)
            ->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('title', 'LIKE', "%{$search}%");
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

    public function chatbot(Request $request)
    {
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'GEMINI_API_KEY is not configured on the server.'], 500);
        }

        // Fetch B2C products to provide live catalog context to Gemini
        $products = \App\Models\Product::where('is_b2b', 0)->take(15)->get();
        $catalogContext = "\n\nAVAILABLE PRODUCT CATALOG:\n";
        foreach ($products as $item) {
            $catalogContext .= "- **{$item->title}**:\n" .
                "  * Standard Price: £{$item->price}" . ($item->discount > 0 ? " (Discount Price: £{$item->discount})" : "") . "\n" .
                "  * Availability: {$item->availability}\n" .
                "  * Link Slug: {$item->slug}\n" .
                "  * Description: " . strip_tags(\Illuminate\Support\Str::limit($item->description, 100)) . "\n";
        }

        // B2C System Prompt
        $systemPrompt = "You are the Mightyolu AI Assistant, a helpful and professional customer service agent for Mightyolu.com, a UK-based retailer of African food products, groceries, beverages, spices, household essentials and personal care products based in Edinburgh, Scotland, United Kingdom.

Behavioral Guidelines:
1. Direct Contact Info:
   - Location: 10/11 Westside Plaza, Edinburgh, Scotland, EH14 2SW.
   - Opening Hours: Monday – Friday: 9:00am – 6:00pm | Saturday: 10:00am – 5:00pm | Sunday: Closed.
   - Phone Support: 07867986338.
   - General Enquiries: inquiry@mightyolu.com.
2. How to Purchase:
   - B2C customers simply browse the catalog, add products to their cart, and complete checkout using credit card, debit card, Apple Pay, or Google Pay.
3. Formatting: Keep responses readable, well-spaced, and use bullet points for lists. Always be polite, professional, and clear.
4. Product Stock & Catalog Enquiries:
   - When a user asks about product stock, catalog items, pricing, or specifications, consult the catalog list below.
   - If the product exists in the catalog list, confirm it is available and provide its details and price.
   - Crucial Link Formatting: Always include a link to the product's details page using standard Markdown format exactly as follows: [Product Title](/products/link-slug) replacing link-slug with the actual Link Slug provided.
   - If the product is not in the catalog below, politely explain that we don't currently have it in stock.

KNOWLEDGE BASE & FREQUENTLY ASKED QUESTIONS (FAQS):
1. General Company Information:
   - What is MightyOlu?: MightyOlu is a UK-based retailer and wholesaler of African food products, groceries, beverages, spices, household essentials and personal care products.
   - Where are you located?: We are based in Edinburgh, Scotland, United Kingdom (10/11 Westside Plaza, Edinburgh, EH14 2SW).
   - Do you deliver across the UK?: Yes. We deliver throughout the United Kingdom.
2. Orders:
   - How do I place an order?: Add products to your basket and proceed to checkout.
   - Can I return products?: Eligible products may be returned in accordance with our Returns Policy.
" . $catalogContext;

        // Map messages history to Gemini API format
        $messages = $request->input('messages', []);
        $contents = [];
        
        foreach ($messages as $m) {
            if (isset($m['text'])) {
                $contents[] = [
                    'role' => (isset($m['sender']) && $m['sender'] === 'user') ? 'user' : 'model',
                    'parts' => [
                        ['text' => $m['text']]
                    ]
                ];
            }
        }

        if (empty($contents)) {
            $contents[] = [
                'role' => 'user',
                'parts' => [
                    ['text' => 'Hello']
                ]
            ];
        }

        // Post request directly to Gemini API
        $response = \Illuminate\Support\Facades\Http::post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash:generateContent?key={$apiKey}",
            [
                'contents' => $contents,
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $systemPrompt]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 800,
                ]
            ]
        );

        if (!$response->successful()) {
            return response()->json(['error' => 'Failed to connect to Gemini API.'], 502);
        }

        $data = $response->json();
        $candidateText = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Sorry, I am unable to generate a response right now.';

        return response()->json(['message' => $candidateText]);
    }
}
