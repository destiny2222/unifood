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
        $Product = Product::orderBy('id', 'DESC')->get()->take(8);
        $category = Category::orderBy('id', 'asc')->get()->take(6);
        $blog = Post::where('show_homepage', 1)->get();
        $services = Service::orderBy('id', 'DESC')->get();
        $sliders = Slider::orderBy('id', 'DESC')->get();
        $dailyOffer = Product::where('today_special', 1)->get();
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

    public function product()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        $product = Product::paginate(12);
        return view('frontend.product', [
            'categories' => $categories,
            'products' => $product,
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

    public function searchProduct(Request $request)
    {
        $query = Product::query();


        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by category 
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('title', $request->category);
            });
        }

        // Execute the query and get results
        $products = $query->paginate(12); // or ->paginate(12)


        return view('frontend.product_search', compact('products'));
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
        return view('frontend.product_search', compact('products'));
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
            'email' => 'required|email|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages([
                'email' => 'The provided email is already subscribed or invalid.',
            ]);
        }

        Newslatter::create(['email' => $request->email]);

        return back()->with('success', 'You have successfully subscribed!');
    }
}
