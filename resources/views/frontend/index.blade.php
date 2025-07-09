@extends('layouts.main')
@section('content')
        <!--=============================
        BANNER START  
    ==============================-->
    <section class="wsus__banner"  style="background: url({{ asset('website-images/slider-bg.jpg') }});">
        <div class="wsus__banner_overlay">
            <span class="banner_shape_1">
                <img src="{{ asset('images/shape/slider-foreground1.png') }}" alt="shape"  class="img-fluid w-100">
            </span>
            <span class="banner_shape_2">
                <img src="{{ asset('images/shape/slider-foreground2.png') }}" alt="shape"   class="img-fluid w-100">
            </span>
            <div class="row banner_slider">
                @foreach ($sliders as $slider)
                    <div class="col-12">
                    <div class="wsus__banner_slider">
                        <div class=" container">
                            <div class="row">
                                <div class="col-xl-5 col-md-5 col-lg-5">
                                    <div class="wsus__banner_img wow fadeInLeft" data-wow-duration="1s">
                                        <div class="img">
                                            <img src="{{ asset('upload/slider/'.$slider->image) }}" alt="food item" class="img-fluid w-100">
                                            <span style="background: url(/user/images/offer_shapes.png);">
                                                {{ $slider->offer_text }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-5 col-md-7 col-lg-6">
                                    <div class="wsus__banner_text wow fadeInRight" data-wow-duration="1s">
                                        <h1>{{ $slider->title_one }}</h1>
                                        <h3>{{ $slider->title_two }}</h3>
                                        <p>{!! $slider->description !!}</p>
                                        <ul class="d-flex flex-wrap">
                                            <li><a class="common_btn" href="{{ $slider->link }}">Shop now</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--=============================
        BANNER END
    ==============================-->


    <!--=============================
        WHY CHOOSE START
    ==============================-->
    <section class="wsus__why_choose">
        <div class="container">
            <div class="row">
                @foreach ($services as $service)
                    <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="wsus__choose_single d-flex flex-wrap align-items-center justify-content-between">
                            <div class="icon icon_1">
                               <i class=" {{ $service->icon }}"></i>
                            </div>
                            <div class="text">
                                <h3>{{ $service->title }}</h3>
                                <p>{!! $service->description !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--=============================
        WHY CHOOSE END
    ==============================-->


    <!--=============================
        OFFER ITEM START
    ==============================-->
    <section class="wsus__offer_item mt_95 xs_mt_65">
        <span class="banner_shape_3">
            <img src="{{ asset('images/shape/today_special_image.png') }}" alt="shape" class="img-fluid w-100">
        </span>
        <div class="container">
            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                    <div class="wsus__section_heading mb_50">
                        <h4>What's Cooking Today?</h4>
                        <h2>Discover fresh ingredients</h2>
                        <span>
                            <img src="/user/images/heading_shapes.png" alt="shapes" class="img-fluid w-100">
                        </span>
                        <p>Prefect for your next meal - whether it's a quick bite or a family feast.</p>
                    </div>
                </div>
            </div>
            <div class="row offer_item_slider wow fadeInUp" data-wow-duration="1s">
                @foreach ($dailyOffers as $dailyOffer)
                    @php
                        // Calculate percentage off
                        $original = $dailyOffer->price;
                        $discount = $dailyOffer->discount;
                        $percentageOff = $original > 0 ? round((($original - $discount) / $original) * 100) : 0;
                    @endphp

                    <div class="col-xl-4">
                        <div class="wsus__offer_item_single"
                            style="background: url({{ asset('images/dal-makhani.jpg') }});">

                            <span>{{ $percentageOff }}% off</span>

                            <a class="title" href="product/dal-makhani-paneer.html">
                                {{ \Str::limit($dailyOffer->title,  50, '...') }}
                            </a>
                            <p>{!! \Str::limit($dailyOffer->description, 50, '...') !!}</p>
                            <ul class="d-flex flex-wrap">
                                <li><a href="javascript:;"><i class="fas fa-shopping-basket"></i></a></li>
                                <li><a href="javascript:;"><i class="fal fa-heart"></i></a></li>
                                <li><a href="product/dal-makhani-paneer.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                @endforeach

                
            </div>
        </div>
    </section>

    <!--=============================
        MENU ITEM START
    ==============================-->
    <section class="wsus__menu mt_95 xs_mt_65">
        <span class="banner_shape_1">
            <img src="{{ asset('images/shape/menu_left_image.png') }}" alt="shape"
                class="img-fluid w-100">
        </span>
        <span class="banner_shape_2">
            <img src="{{ asset('images/shape/menu_right_image.png') }}" alt="shape"
                class="img-fluid w-100">
        </span>
        <div class="container">

            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                    <div class="wsus__section_heading mb_45">
                        <h4>Food Menu</h4>
                        <h2>Our Popular Delicious Foods</h2>
                        <span>
                            <img src="/user/images/heading_shapes.png" alt="shapes" class="img-fluid w-100">
                        </span>
                        <p>Explore Our Best-Selling Food Items Chosen by food lovers, made to satisfy every craving.</p>
                    </div>
                </div>
            </div>

            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-12">
                    <div class="menu_filter d-flex flex-wrap justify-content-center">
                        {{-- <button class="first_menu_product " data-filter="*">All</button> --}}
                        @foreach ($categories as $index => $category)
                            <button class="{{ $index == 0 ? 'first_menu_product active' : '' }}" data-filter=".category_{{ $category->id }}">
                                {{ $category->title }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row grid">
                @forelse ($products as $product)
                    <div class="col-6 col-xl-3 col-sm-6 col-lg-4 category_{{ $product->category_id }} wow fadeInUp " data-wow-duration="1s">
                        <div class="wsus__menu_item">
                            <div class="wsus__menu_item_img">
                                <a href="{{ route('frontend.product.show', $product->slug) }}">
                                    <img src="{{ asset('storage/upload/product/single/'.$product->images ?? 'images/hyderabadi-biryani.png') }}"
                                    alt="menu" class="img-fluid w-100">
                                </a>
                                <a class="category" href="{{ route('frontend.product.show', $product->slug) }}">{{ $product->category->title ?? 'Category' }}</a>
                            </div>
                            <div class="wsus__menu_item_text">
                                <a class="title" href="{{ route('frontend.product.show', $product->slug) }}">{{ $product->title ?? 'Hyderabadi Biryani' }}</a>
                                <h5 class="price">${{ $product->price ?? 0 }} @if($product->discount)<del>${{ $product->discount }}</del>@endif </h5>
                                <ul class="d-flex flex-wrap justify-content-center">
                                    <li><a href="{{ route('cart.add') }}" onclick="event.preventDefault(); document.getElementById('cart-{{ $product->id  }}').submit()"><i class="fas fa-shopping-basket"></i></a></li>
                                    <form action="{{ route('cart.add') }}" method="post" id="cart-{{ $product->id  }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="slug" value="{{ $product->slug }}">
                                        <input type="hidden" name="quantity" value="1">
                                    </form>
                                    <li><a href="javascript:;" href="{{ route('wishlist.add') }}" onclick="event.preventDefault(); document.getElementById('wish-{{ $product->id  }}').submit()"><i class="fal fa-heart"></i></a></li>
                                    <form action="{{ route('wishlist.add') }}" id="wish-{{ $product->id  }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    </form>
                                    <li><a href="{{ route('frontend.product.show', $product->slug) }}"><i class="far fa-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    
                @endforelse
                
                
            </div>
        </div>
    </section>
    <!--=============================
        MENU ITEM END
    ==============================-->


    <!--=============================
        ADD SLIDER START
    ==============================-->
    <section class="wsus__add_slider mt_100 xs_mt_70">
        <div class="container">
            <div class="row add_slider wow fadeInUp" data-wow-duration="1s">
                @foreach ($advertisements as $advertisement)
                    <div class="col-xl-4">
                        <a href="#!" class="wsus__add_slider_single"  style="background: url({{ asset('upload/advertisement/'.$advertisement->image) }});">
                            <div class="text">
                                <h3>{{ $advertisement->title }}</h3>
                                <p>{!! $advertisement->description !!}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--=============================
        ADD SLIDER END
    ==============================-->




    <!--=============================
        DOWNLOAD APP START
    ==============================-->

    <section class="wsus__download mt_100 xs_mt_70">
        <div class="container">
            <div class="wsus__download_bg"
                style="background: url({{ asset('upload/appsection/'.$appSection->background_image ?? '' ) }});">
                <div class="wsus__download_overlay">
                    <div class="row justify-content-between">
                        <div class="col-xl-5 col-lg-6 wow fadeInUp" data-wow-duration="1s">
                            <div class="wsus__download_text">
                                <div class="wsus__section_heading mb_25">
                                    <h2>{{ $appSection->title ?? '' }}</h2>
                                    <p>{!! $appSection->description ?? '' !!}</p>
                                </div>
                                <ul class="d-flex flex-wrap">
                                    <li>
                                        <a href="{{ $appSection->play_store_link ?? '' }}">
                                            <i class="fab fa-google-play"></i>
                                            <p> <span>download from</span> google play </p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $appSection->app_store_link ?? '' }}">
                                            <i class="fab fa-apple"></i>
                                            <p> <span>download from</span> apple store </p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-duration="1s">
                            <div class="wsus__download_img">
                                <img src="{{ asset('upload/appsection/image/'.$appSection->app_image ?? '') }}"  alt="download" class="img-fluid w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        DOWNLOAD APP END
    ==============================-->


    <!--=============================
        COUNTER START
    ==============================-->
    <section class="wsus__counter mt_100 xs_mt_70"
        style="background: url( {{ asset('images/breadcrumb_image.jpg') }} );">
        <div class="wsus__counter_overlay pt_100 xs_pt_70 pb_100 xs_pb_70">
            <div class="container">
                <div class="row">
                    @foreach ($counters as $counter)
                        <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                            <div class="wsus__single_counter">
                                <i class="fas fa-burger-soda"></i>
                                <div class="text">
                                    <h2 class="counter">{{ $counter->quantity }}</h2>
                                    <p>{{ $counter->title }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        COUNTER END
    ==============================-->


    <!--=============================
       TESTIMONIAL  START
    ==============================-->
    <section class="wsus__testimonial pt_90 xs_pt_60 mb_150 xs_mb_120">
        <div class="container">

            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                    <div class="wsus__section_heading mb_40">
                        <h4>Testimonial</h4>
                        <h2>Our Customar Feedbacks</h2>
                        <span>
                            <img src="/user/images/heading_shapes.png" alt="shapes" class="img-fluid w-100">
                        </span>
                        <p>see what people love about shopping with us.</p>
                    </div>
                </div>
            </div>

            <div class="row testi_slider">
                @foreach ($testimonials as $testimonial)
                    <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__single_testimonial">
                            <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                                <div class="img">
                                    <img src="{{ asset('upload/testimonial/'.$testimonial->existing_image ) }}" alt="clients"
                                        class="img-fluid w-100">
                                </div>
                                <div class="text">
                                    <h4>{{ $testimonial->name }}</h4>
                                    <p>{{ $testimonial->designation }}</p>
                                </div>
                            </div>
                            <div class="wsus__single_testimonial_body">
                                <p class="feedback">{!! $testimonial->description !!}</p>
                                <span class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </span>
                            </div>
                            <div class="wsus__testimonial_product">
                                <img src="{{ asset('upload/testimonial/product/'.$testimonial->product_image) }}" alt="product" class="img-fluid w-100">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--=============================
        TESTIMONIAL END
    ==============================-->

    <!--=============================
        BLOG START
    ==============================-->

    <section class="wsus__blog"
        style="background: url({{ asset('footer_background.jpg') }});">
        <div class="wsus__blog_overlay pt_95 xs_pt_65 pb_100 xs_pb_70">
            <div class="container">

                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                        <div class="wsus__section_heading mb_25">
                            <h4>Our Blogs</h4>
                            <h2>Our Latest Foods Blog</h2>
                            <span>
                                <img src="/user/images/heading_shapes.png" alt="shapes" class="img-fluid w-100">
                            </span>
                            <p>Explore what's new in the world of food and flavor.</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($blogs as $blog)
                        <div class="col-xl-4 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                            <div class="wsus__single_blog">
                                <a href="{{ route('frontend.blog.show', $blog->slug) }}" class="wsus__single_blog_img">
                                    <img src="{{ asset('storage/upload/post/'.$blog->image ) }}" alt="blog" class="img-fluid w-100">
                                </a>
                                <div class="wsus__single_blog_text">
                                    <a class="category" href="{{ route('frontend.blog.show', $blog->slug) }}">{{ $blog->category->title }}</a>
                                    <ul class="d-flex flex-wrap mt_15">
                                        <li><i class="fas fa-user"></i>by admin</li>
                                        <li><i class="fas fa-calendar-alt"></i> {{ $blog->created_at->format('d M Y') }}</li>
                                        <li><i class="fas fa-comments"></i> {{ count($blog->comments) }} comment</li>
                                    </ul>
                                    <a class="title" href="{{ route('frontend.blog.show', $blog->slug) }}">{{  $blog->title }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BLOG END
    ==============================-->



    <!--=============================
        BRAND START
    ==============================-->
     @include('partials.brand')
    <!--=============================
        BRAND END
    ==============================-->
@endsection   