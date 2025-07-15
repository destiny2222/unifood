@extends('layouts.main')
@section('content')
@section('title', 'About Us')
<!--=============================
            BREADCRUMB START
        ==============================-->
@include('partials.breadcrumb')
<!--=============================
        BREADCRUMB END
    ==============================-->


<!--=============================
        ABOUT PAGE START
    ==============================-->
<section class="wsus__about_us mt_120 xs_mt_90">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-5 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__about_us_img">
                    <img src="{{ asset('upload/about-us/'. optional($about)->image ?? '') }}" alt="about us"  class="img-fluid w-100">
                </div>
            </div>
            <div class="col-xl-6 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__section_heading mb_40">
                    <h4>{{ $about->short_title ?? '' }}</h4>
                    <h2>{{ $about->long_title ?? '' }}</h2>
                    <span>
                        <img src="{{ asset('/images/shape/heading_shapes.png') }}" alt="shapes" class="img-fluid w-100">
                    </span>
                </div>
                <div class="wsus__about_us_text">
                    {!! $about->description ?? '' !!}
                </div>
            </div>
        </div>
    </div>
</section>


<section class="wsus__about_choose mt_95 xs_mt_65">
    <div class="container">
        <div class="wsus__about_choose_bg_area">
            <div class="row">
                <div class="col-xl-6 col-lg-5 col-md-10 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__about_choose_img">
                        <span class="img_1">
                            <img src="{{ asset('upload/whychoose/background/'. optional($whyChooseUs)->background_image ?? '') }}"  alt="about us" class="img-fluid w-100">
                        </span>
                        <span class="img_2">
                            <img src="{{ asset('upload/whychoose/image/'. optional($whyChooseUs)->image_one ?? '') }}"  alt="about us" class="img-fluid w-100">
                        </span>
                        <span class="img_3">n
                            <img src="{{ asset('upload/whychoose/'. optional($whyChooseUs)->image_two ?? '') }}" alt="about us" class="img-fluid w-100">
                        </span>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__section_heading mt_25 mb_10">
                        <h4>{{ $whyChooseUs->short_title ?? ''   }}</h4>
                        <h2>{{ $whyChooseUs->long_title ?? '' }}</h2>
                        <span>
                            <img src="{{ asset('/images/shape/heading_shapes.png') }}" alt="shapes" class="img-fluid w-100">
                        </span>
                        <p>{!! optional($whyChooseUs)->description !!}</p>
                    </div>
                    <div class="wsus__about_choose_text">
                        <ul>
                            <li><span><i class="{{ $whyChooseUs->icon_one ?? '' }}"></i></span> {{ $whyChooseUs->title_one ?? '' }}</li>
                            <li><span><i class="{{ $whyChooseUs->icon_two ?? '' }}"></i></span> {{ $whyChooseUs->title_two ?? ''}}</li>
                            <li><span><i class="{{ $whyChooseUs->icon_three ?? '' }}"></i></span> {{ $whyChooseUs->title_three ?? ''}}</li>
                            <li><span><i class="{{ $whyChooseUs->icon_four ?? ''}}"></i></span> {{ $whyChooseUs->title_four ?? ''}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="wsus__counter mt_100 xs_mt_70"
    style="background: url({{ asset('images/breadcrumb_image.jpg') }});">
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

<section class="wsus__testimonial pt_90 xs_pt_60 mb_150 xs_mb_120">
    <div class="container">

        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                <div class="wsus__section_heading mb_40">
                    <h4>Testimonial</h4>
                    <h2>Our Customar Feedbacks</h2>
                    <span>
                        <img src="{{ asset('/images/shape/heading_shapes.png') }}" alt="shapes" class="img-fluid w-100">
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
        ABOUT PAGE END
    ==============================-->


    <!--=============================
        BRAND START
    ==============================-->
     @include('partials.brand')
    <!--=============================
        BRAND END
    ==============================-->

@endsection
