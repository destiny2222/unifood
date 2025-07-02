@extends('layouts.main')
@section('content')
@section('title', 'Blog Details')
<!--=============================
            BREADCRUMB START
        ==============================-->
@include('partials.breadcrumb')
<!--=============================
        BREADCRUMB END
    ==============================-->

    
        <!--=========================
        BLOG DETAILS START
    ==========================-->
    <section class="wsus__blog_details mt_120 xs_mt_90 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    <div class="wsus__blog_det_area">
                        <div class="wsus__blog_details_img wow fadeInUp" data-wow-duration="1s">
                            <img src="{{ asset('storage/upload/post/'.$post->image ) }}" alt="blog details" class="imf-fluid w-100">
                        </div>
                        <div class="wsus__blog_details_text wow fadeInUp" data-wow-duration="1s">
                            <ul class="details_bloger d-flex flex-wrap">
                                <li><i class="far fa-user"></i> By Admin</li>
                                <li><i class="far fa-comment-alt-lines"></i> {{ count($post->comments) }} Comments</li>
                                <li><i class="far fa-calendar-alt"></i> {{ $post->created_at->format('d M Y') }}</li>
                            </ul>
                            <h2>{{  $post->title }}</h2>
                            <p>{!! $post->description !!}</p>
                            <p></p>
                            <div class="blog_tags_share d-flex flex-wrap justify-content-between align-items-center">
                                <div class="share d-flex flex-wrap align-items-center">
                                    <span>share:</span>
                                    <ul class="d-flex flex-wrap">
                                        <li>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}&t={{ urlencode($post->title) }}" target="_blank">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/share?text={{ urlencode($post->title) }}&url={{ urlencode(request()->fullUrl()) }}" target="_blank">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}&title={{ urlencode($post->title) }}" target="_blank">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.pinterest.com/pin/create/button/?description={{ urlencode($post->title) }}&media={{ asset('storage/upload/post/'.$post->image) }}&url={{ urlencode(request()->fullUrl()) }}" target="_blank">
                                                <i class="fab fa-pinterest-p"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wsus__comment mt_100 xs_mt_70 wow fadeInUp" data-wow-duration="1s">
                        <h4>{{ $post->comments->where('is_approved', true)->count() }} Comments</h4>
                        @foreach ($post->comments->where('is_approved', true) as $comment)
                        <div class="wsus__single_comment m-0 border-0">
                            <img src="http://www.gravatar.com/avatar/75d23af433e0cea4c0e45a56dba18b30" alt="review" class="img-fluid">
                            <div class="wsus__single_comm_text">
                                <h3>{{ $comment->name }} <span>{{ $comment->created_at->format('d M Y') }} </span></h3>
                                <p>{{ $comment->comment_body }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="comment_input mt_100 xs_mt_70 wow fadeInUp" data-wow-duration="1s">
                        <h4>Write a comment</h4>
                        <p>Your email address will not be published. Required fields are marked *</p>
                        <form id="" action="{{ route('comments.store', $post->slug) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6 col-md-6">
                                    <label>name *</label>
                                    <div class="wsus__contact_form_input">
                                        <span><i class="fal fa-user-alt"></i></span>
                                        <input type="text" name="name" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <label>Email *</label>
                                    <div class="wsus__contact_form_input">
                                        <span><i class="fal fa-user-alt"></i></span>
                                        <input type="email" placeholder="Email" name="email">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <label>comment *</label>
                                    <div class="wsus__contact_form_input textarea">
                                        <span><i class="fal fa-user-alt"></i></span>
                                        <textarea rows="5" placeholder="Your Comment" name="comment_body"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <button type="submit" class="common_btn mt_20">Submit comment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div id="sticky_sidebar">
                        <div class="wsus__blog_search blog_sidebar m-0 wow fadeInUp" data-wow-duration="1s">
                            <h3>Search</h3>
                            <form action="{{ route('frontend.blog.search') }}" method="GET">
                                <input name="query" type="text" placeholder="Type your keyword" value="{{ request('query') }}">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                        <div class="wsus__related_blog blog_sidebar wow fadeInUp" data-wow-duration="1s">
                            <h3>Popular Post</h3>
                            <ul>
                                @foreach ($recentPosts as $recentPost)
                                    <li>
                                        <img src="{{ asset('storage/upload/post/'.$recentPost->image ) }}" alt="blog" class="img-fluid w-100">
                                        <div class="text">
                                            <a href="the-best-ways-to-cook-seafood-at-home.html">{{ \Str::limit($recentPost->title, 20) }}</a>
                                            <p><i class="far fa-calendar-alt"></i> {{ $recentPost->created_at->format('d M Y')}} </p>
                                        </div>
                                    </li>
                                @endforeach 
                            </ul>
                        </div>
                        <div class="wsus__blog_categori blog_sidebar wow fadeInUp" data-wow-duration="1s">
                            <h3>Categories</h3>
                            <ul>
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="#">
                                            {{ $category->title }} <span>{{ $category->posts_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========================
        BLOG DETAILS END
    ==========================-->


@endsection