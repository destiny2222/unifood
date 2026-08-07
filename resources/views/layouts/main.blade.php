@php
    // $carts = session('cart', []);
    $wishlist = \App\Models\Wishlist::where('user_id', optional(Auth::user())->id)->get();
    $categories = \App\Models\Category::orderBy('id', 'DESC')->get();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ config('app.name') }} - Your Premier Online Grocery Store </title>
    <meta name="description" content="MightyOlu Grocery offers a wide range of fresh groceries, produce, and household essentials. Shop online for fast delivery, secure payment, and excellent customer support.">
    <meta name="author" content="Dexnovate" />
    <meta name="keywords" content="online grocery store, grocery delivery service, buy groceries online, fresh food delivery, organic produce online, supermarket online, food shopping online, best online grocery, affordable groceries, MightyOlu grocery, grocery store near me, online food shopping, ecommerce, online shopping, fast delivery, secure payment, customer support, household essentials, fresh vegetables, fresh fruits, online meat delivery, dairy products online, pantry staples, snack delivery, beverage delivery">
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="https://mightyolu.com/images/logo/logo.png">
    <meta name="og:image" content="https://mightyolu.com/images/logo/logo.png">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">

    {{-- <meta property="fb:app_id" content="123456789"> --}}
    <meta property="og:url" content="https://mightyolu.com/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ config('app.name') }}">
    <meta property="og:image" content="https://mightyolu.com/images/logo/logo.png">
    <meta property="og:image:alt" content="MightyOlu Grocery - Your Premier Online Grocery Store">
    <meta property="og:description" content="MightyOlu Grocery offers a wide range of fresh groceries, produce, and household essentials. Shop online for fast delivery, secure payment, and excellent customer support.">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:locale" content="en_US">
    <meta property="article:author" content="dexnovate">

    <link rel="icon" type="image/png" href="https://mightyolu.com/images/logo/logo.png">
    <link rel="stylesheet" href="/user/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/user/css/spacing.css">
    <link rel="stylesheet" href="/user/css/slick.css">
    <link rel="stylesheet" href="/user/css/nice-select.css">
    <link rel="stylesheet" href="/user/css/venobox.min.css">
    <link rel="stylesheet" href="/user/css/animate.css">
    <link rel="stylesheet" href="/user/css/jquery.exzoom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.css">
    <link rel="stylesheet" href="/user/css/style.css">
    <link rel="stylesheet" href="/user/css/responsive.css">
    <link rel="stylesheet" href="/backend/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
   @stack('styles')
   <style>
    .mobile_cart_icon{
        padding-right:20px;
    }
   </style>
   @livewireStyles
</head>

<body>

    <div class="" id="preloader">
        <div class="img d-none">
            <img src="/Spinner.gif" alt="UniFood" class="img-fluid">
        </div>
    </div>

    <!--=============================
        TOPBAR START
    ==============================-->
    <section class="wsus__topbar">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-6 d-none d-md-block">
                    <ul class="wsus__topbar_info d-flex flex-wrap">
                        <li><a href="mailto:inquiry@mightyolu.com "><i class="fas fa-envelope"></i>
                                inquiry@mightyolu.com </a>
                        </li>
                        <li><a href="callto:07867986338"><i class="fas fa-phone-alt"></i> 07867986338</a></li>
                    </ul>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="topbar_right">
                        <div class="topbar_language">
                            <form id="setLanguage" action="">
                                <select id="select_js3" name="code">
                                    <option value="en" selected="">English</option>
                                    <option value="bn">Bangla</option>
                                    <option value="ar">Arabic</option>
                                </select>
                            </form>
                        </div>
                        <ul class="topbar_icon d-flex flex-wrap">
                            <li><a href="https://www.facebook.com/profile.php?id=61572736592102"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="https://tiktok.com/@mightyolu_grocery"><i class="fab fa-tiktok"></i></a></li>
                            <li><a href="https://api.whatsapp.com/send?phone=447867986338"><i class="fab fa-whatsapp"></i></a></li>
                            <li><a href="https://instagram.com/mightyolu_grocery"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        TOPBAR END
    ==============================-->


    <!--=============================
        MENU START
    ==============================-->
    <nav class="navbar navbar-expand-lg main_menu">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo/logo.png') }}" width="50" height="50" alt="UniFood"
                    class="img-fluid">
            </a>
            <div class="mobile_search_icon">
                <a href="javascript:;" class="menu_search"><i class="far fa-search"></i></a>
            </div>
            <div class="mobile_cart_icon">
                <a class="cart_icon">
                    <i class="fas fa-shopping-basket"></i> 
                    <span class="topbar_cart_qty" id="">{{ cart_count() }}</span>
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="far fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav m-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/about">About Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/blog">Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">contact us</a>
                    </li>
                    <li class="nav-item my-2 my-lg-0 ms-lg-2 d-flex justify-content-center align-items-center">
                        <a class="btn btn-sm text-white fw-bold px-3 py-2 rounded-pill shadow-sm" href="{{ env('FRONTEND_URL') }}" target="_blank" style="background-color: #22AD5C; border: none; display: inline-block;">
                            <i class="fas fa-briefcase me-1"></i> Business to Business
                        </a>
                    </li>
                </ul>
                <ul class="menu_icon d-flex flex-wrap">
                    <li class="wsus__search_desktop">
                        <a href="javascript:;" class="menu_search"><i class="far fa-search"></i></a>
                    </li>
                    <li class="wsus__cart_desktop">
                        <a class="cart_icon">
                    <i class="fas fa-shopping-basket"></i> 
                    <span class="topbar_cart_qty" id="">{{ cart_count() }}</span>
                </a>
                    </li>
                    <li>
                        @auth
                            <a href="/dashboard"><i class="fas fa-user"></i></a>
                        @else
                            <a href="/login"><i class="fas fa-user"></i></a>
                        @endauth
                    </li>
                    <li>
                        @auth
                          <a class="common_btn" href="/dashboard">Dashboard</a>
                        @else
                            <a class="common_btn" href="/login">Login</a>
                        @endauth
                    </li>
                    {{-- <li>
                        <a class="common_btn" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">reservation</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>

    <div class="wsus__search_form">
        <form action="{{ route('search') }}" method="GET">
            <span class="close_search"><i class="far fa-times"></i></span>
            <input name="search" type="text" placeholder="Type your keyword">
            <button type="submit">search</button>
        </form>
    </div>




<div class="wsus__menu_cart_area">
    <livewire:mini-cart />
</div>



    @yield('content')


    <!--=============================
        FOOTER START
    ==============================-->
    <footer style="background: url({{ asset('footer_background.jpg') }});">
        <div class="footer_overlay pt_100 xs_pt_70 pb_100 xs_pb_70">
            <div class="container wow fadeInUp" data-wow-duration="1s">
                <div class="row justify-content-between">
                    <div class="col-lg-4 col-sm-8 col-md-6">
                        <div class="wsus__footer_content">
                            <a class="footer_logo" href="index.htm">
                                <img src="{{ asset('images/logo/footer_logo.png') }}" alt="UniFood"
                                    class="img-fluid w-100">
                            </a>
                            <p class="info"><i class="far fa-map-marker-alt"></i> 10/11 Westside Plaza, Edinburgh. Scotland. EH14 2SW. </p>
                            <a class="info" href="callto:07867986338"><i class="fas fa-phone-alt"></i>
                                07867986338</a>
                            <a class="info" href="mailto:inquiry@mightyolu.com "><i class="fas fa-envelope"></i>
                                inquiry@mightyolu.com </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-md-6">
                        <div class="wsus__footer_content">
                            <h3>Important Link</h3>
                            <ul>
                                <li><a href="/">Home</a></li>
                                <li><a href="/about">About Us</a></li>
                                <li><a href="/contact">Contact Us</a></li>
                                @auth
                                    <li><a href="/dashboard">Dashboard</a></li>
                                @else
                                    <li><a href="/login">Dashboard</a></li>
                                @endauth

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-md-6 order-sm-4 order-lg-3">
                        <div class="wsus__footer_content">
                            <h3>Help Link</h3>
                            <ul>
                                <li><a href="/blog">Our Blogs</a></li>
                                <li><a href="/faq">FAQ</a></li>
                                <li><a href="{{ route('frontend.privacy-policy') }}">Privacy and Policy</a></li>
                                <li><a href="{{ route('frontend.terms-and-condition') }}">Terms and Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-8 col-md-6 order-lg-4">
                        <div class="wsus__footer_content">
                            <h3>Subscribe to Newsletter</h3>
                            <form id="subscribe_form" action="{{ route('subscribe') }}" method="POST">
                                @csrf
                                <input type="email" name="email" required placeholder="Enter your email">
                                <button id="subscribe_btn" type="submit"><i class="fas fa-paper-plane"></i></button>
                            </form>
                            <div class="wsus__footer_social_link">
                                <h5>Follow us:</h5>
                                <ul class="d-flex flex-wrap">
                                    <li><a href="https://www.facebook.com/profile.php?id=61572736592102"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="https://tiktok.com/@mightyolu_grocery"><i class="fab fa-tiktok"></i></a></li>
                                    <li><a href="https://api.whatsapp.com/send?phone=447867986338"><i class="fab fa-whatsapp"></i></a></li>
                                    <li><a href="https://instagram.com/mightyolu_grocery"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wsus__footer_bottom d-flex flex-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="wsus__footer_bottom_text d-flex flex-wrap justify-content-between">
                            <p class="text-center"><script>document.write(new Date().getFullYear())</script> &copy; {{ config('app.name') }}. Crafted by <i" class="fa fa-heart fs-18 align-middle text-danger"></i>  <a href="https://dexnovate.com"  class="text-warning fs-5" target="_blank">Dexnovate</a></p>
                            {{-- <ul class="d-flex flex-wrap">
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Cart</a></li>
                                <li><a href="#">Checkout</a></li>
                                <li><a href="#">Dashboard</a></li>
                            </ul> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--=============================
        FOOTER END
    ==============================-->

 <!-- CART POPUT START -->
    <div class="wsus__cart_popup">
        <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                class="fal fa-times"></i></button>
                        <div class="load_product_modal_response"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- CART POPUT END -->
    <!--=============================
        OFFER ITEM END
    ==============================--> 
 




    <!--jquery library js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!--bootstrap js-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!--font-awesome js-->
    <script src="/user/js/Font-Awesome.js"></script>
    <!-- slick slider -->
    <script src="/user/js/slick.min.js"></script>
    <!-- isotop js -->
    <script src="/user/js/isotope.pkgd.min.js"></script>
    <!-- simplyCountdownjs -->
    <script src="/user/js/simplyCountdown.js"></script>
    <!-- counter up js -->
    <script src="/user/js/jquery.waypoints.min.js"></script>
    <script src="/user/js/jquery.countup.min.js"></script>
    <!-- nice select js -->
    <script src="/user/js/jquery.nice-select.min.js"></script>
    <!-- venobox js -->
    <script src="/user/js/venobox.min.js"></script>
    <!-- sticky sidebar js -->
    <script src="/user/js/sticky_sidebar.js"></script>
    <!-- wow js -->
    <script src="/user/js/wow.min.js"></script>
    <!-- ex zoom js -->
    <script src="/user/js/jquery.exzoom.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script> 
    <!--main/custom js-->
    <script src="/user/js/main.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('show-password.min.js') }}"></script>
    @include('partials.message')
    @stack('scripts')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function () {
                
                $("#setLanguage").on('change', function(e){
                    this.submit();
                });
                
                $(".first_menu_product").click();

                $('.select2').select2();
                $('.modal_select2').select2({
                    dropdownParent: $("#address_modal")
                });

                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '-Infinity'
                });
            });
        })(jQuery);
    </script>
    @livewireScripts
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>
