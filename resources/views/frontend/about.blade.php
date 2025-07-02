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
                    <img src="{{ asset('images/about-us.jpg') }}" alt="about us"  class="img-fluid w-100">
                </div>
            </div>
            <div class="col-xl-6 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__section_heading mb_40">
                    <h4>About Us</h4>
                    <h2>Helathy Foods Provider</h2>
                    <span>
                        <img src="{{ asset('images/shapes/heading_shapes.png') }}" alt="shapes" class="img-fluid w-100">
                    </span>
                </div>
                <div class="wsus__about_us_text">
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cupiditate aspernatur molestiae minima
                        pariatur consequatur voluptate sapiente deleniti soluta, animi ab necessitatibus optio similique
                        quasi fuga impedit corrupti obcaecati neque consequatur sequi.</p>
                    <ul>
                        <li>Delicious &amp; Healthy Foods</li>
                        <li>Spacific Family &amp; Kids Zone</li>
                        <li>Best Price &amp; Offers</li>
                        <li>Made By Fresh Ingredients</li>
                        <li>Music &amp; Other Facilities</li>
                        <li>Delicious &amp; Healthy Foods</li>
                        <li>Spacific Family &amp; Kids Zone</li>
                        <li>Best Price &amp; Offers</li>
                        <li>Made By Fresh Ingredients</li>
                        <li>Delicious &amp; Healthy Foods</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="wsus__about_video mt_100 xs_mt_70">
    <div class="container wow fadeInUp" data-wow-duration="1s">
        <div class="wsus__about_video_bg"
            style="background: url({{ asset('images/breadcrumb_image.jpg') }});">
            <div class="wsus__about_video_overlay">
                <div class="row">
                    <div class="col-12">
                        <div class="wsus__about_video_text">
                            <p>Watch Videos</p>
                            <a class="play_btn venobox" data-autoplay="true" data-vbtype="video"
                                href="https://youtu.be/lcU3pruVyUw">
                                <i class=" fas fa-play"></i>
                            </a>
                        </div>
                    </div>
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
                            <img src="{{ asset('images/why_choose_us_background.jpg') }}"
                                alt="about us" class="img-fluid w-100">
                        </span>
                        <span class="img_2">
                            <img src="{{ asset('images/why_choose_us_foreground_one.jpg') }}"
                                alt="about us" class="img-fluid w-100">
                        </span>
                        <span class="img_3">
                            <img src="{{ asset('images/why_choose_us_foreground_two.jpg') }}"
                                alt="about us" class="img-fluid w-100">
                        </span>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__section_heading mt_25 mb_10">
                        <h4>Why Choose Us</h4>
                        <h2>Why We Are The Best</h2>
                        <span>
                            <img src="{{ asset('images/shape/heading_shapes.png') }}" alt="shapes" class="img-fluid w-100">
                        </span>
                        <p>Objectively pontificate quality models before intuitive information. Dramatically
                            recaptiualize multifunctional materials.</p>
                    </div>
                    <div class="wsus__about_choose_text">
                        <ul>
                            <li><span><i class="fas fa-football-ball"></i></span> Fresh food</li>
                            <li><span><i class="fas fa-ambulance"></i></span> Fast Delivery</li>
                            <li><span><i class="fas fa-anchor"></i></span> Quality Maintain</li>
                            <li><span><i class="fas fa-bullseye"></i></span> 24/7 Service</li>
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
                <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_counter">
                        <i class="fas fa-burger-soda"></i>
                        <div class="text">
                            <h2 class="counter">1200</h2>
                            <p>Customer Serve</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_counter">
                        <i class="fal fa-hat-chef"></i>
                        <div class="text">
                            <h2 class="counter">1150</h2>
                            <p>Experience Chef</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_counter">
                        <i class="far fa-handshake"></i>
                        <div class="text">
                            <h2 class="counter">1250</h2>
                            <p>Happy Customer</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_counter">
                        <i class="far fa-trophy"></i>
                        <div class="text">
                            <h2 class="counter">1300</h2>
                            <p>Winning Award</p>
                        </div>
                    </div>
                </div>
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
                        <img src="{{ asset('images/shape/heading_shapes.png') }}" alt="shapes" class="img-fluid w-100">
                    </span>
                    <p>Objectively pontificate quality models before intuitive information. Dramatically recaptiualize
                        multifunctional.</p>
                </div>
            </div>
        </div>

        <div class="row testi_slider">
            <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__single_testimonial">
                    <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                        <div class="img">
                            <img src="{{ asset('images/elia-navy.jpg') }}" alt="clients"
                                class="img-fluid w-100">
                        </div>
                        <div class="text">
                            <h4>Elia Navy</h4>
                            <p>Web Developer</p>
                        </div>
                    </div>
                    <div class="wsus__single_testimonial_body">
                        <p class="feedback">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut accusamus
                            praesentium quaerat nihil magnam a porro eaque numquam</p>
                        <span class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </span>
                    </div>
                    <div class="wsus__testimonial_product">
                        <img src="{{ asset('images/testimonial-product.png') }}" alt="product"
                            class="img-fluid w-100">
                    </div>
                </div>
            </div>
            <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__single_testimonial">
                    <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                        <div class="img">
                            <img src="{{ asset('images/john-abraham.jpg') }}" alt="clients"
                                class="img-fluid w-100">
                        </div>
                        <div class="text">
                            <h4>John Abraham</h4>
                            <p>MBBS, FCPS, FRCS</p>
                        </div>
                    </div>
                    <div class="wsus__single_testimonial_body">
                        <p class="feedback">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut accusamus
                            praesentium quaerat nihil magnam a porro eaque numquam</p>
                        <span class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </span>
                    </div>
                    <div class="wsus__testimonial_product">
                        <img src="{{ asset('images/testimonial-product.png') }}" alt="product"
                            class="img-fluid w-100">
                    </div>
                </div>
            </div>
            <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__single_testimonial">
                    <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                        <div class="img">
                            <img src="{{ asset('images/jose-larry.jpg') }}" alt="clients"
                                class="img-fluid w-100">
                        </div>
                        <div class="text">
                            <h4>Jose Larry</h4>
                            <p>Web Designer</p>
                        </div>
                    </div>
                    <div class="wsus__single_testimonial_body">
                        <p class="feedback">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut accusamus
                            praesentium quaerat nihil magnam a porro eaque numquam</p>
                        <span class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </span>
                    </div>
                    <div class="wsus__testimonial_product">
                        <img src="{{ asset('images/testimonial-product.png') }}" alt="product"
                            class="img-fluid w-100">
                    </div>
                </div>
            </div>
            <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__single_testimonial">
                    <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                        <div class="img">
                            <img src="{{ asset('images/david-richard.jpg') }}" alt="clients"
                                class="img-fluid w-100">
                        </div>
                        <div class="text">
                            <h4>David Richard</h4>
                            <p>Graphic Designer</p>
                        </div>
                    </div>
                    <div class="wsus__single_testimonial_body">
                        <p class="feedback">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut accusamus
                            praesentium quaerat nihil magnam a porro eaque numquam</p>
                        <span class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                        </span>
                    </div>
                    <div class="wsus__testimonial_product">
                        <img src="{{ asset('images/testimonial-product.png') }}" alt="product"
                            class="img-fluid w-100">
                    </div>
                </div>
            </div>
            <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__single_testimonial">
                    <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                        <div class="img">
                            <img src="{{ asset('images/david-simmons.jpg') }}" alt="clients"
                                class="img-fluid w-100">
                        </div>
                        <div class="text">
                            <h4>David Simmons</h4>
                            <p>MBBS, FCPS, FRCS</p>
                        </div>
                    </div>
                    <div class="wsus__single_testimonial_body">
                        <p class="feedback">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut accusamus
                            praesentium quaerat nihil magnam a porro eaque numquam</p>
                        <span class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </span>
                    </div>
                    <div class="wsus__testimonial_product">
                        <img src="{{ asset('images/testimonial-product.png') }}" alt="product"
                            class="img-fluid w-100">
                    </div>
                </div>
            </div>
            <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__single_testimonial">
                    <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                        <div class="img">
                            <img src="{{ asset('images/mary-patricia.jpg') }}" alt="clients"
                                class="img-fluid w-100">
                        </div>
                        <div class="text">
                            <h4>Mary Patricia</h4>
                            <p>Senior Chef</p>
                        </div>
                    </div>
                    <div class="wsus__single_testimonial_body">
                        <p class="feedback">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut accusamus
                            praesentium quaerat nihil magnam a porro eaque numquam</p>
                        <span class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </span>
                    </div>
                    <div class="wsus__testimonial_product">
                        <img src="{{ asset('images/testimonial-product.png') }}" alt="product"
                            class="img-fluid w-100">
                    </div>
                </div>
            </div>
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
