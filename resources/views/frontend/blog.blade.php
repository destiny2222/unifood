@extends('layouts.main')
@section('content')
@section('title', 'Our Blogs')
<!--=============================
            BREADCRUMB START
        ==============================-->
@include('partials.breadcrumb')
<!--=============================
        BREADCRUMB END
    ==============================-->
    <!--=============================
            BLOG PAGE START
        ==============================-->
    <section class="wsus__blog_page mt_120 xs_mt_65 mb_100 xs_mb_70">
        <div class="container">
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
            <div class="wsus__pagination mt_35">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="...">
                            <ul class="pagination">





                            </ul>
                        </nav>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <!--=============================
            BLOG PAGE END
        ==============================-->
@endsection
