@php
    $carts = \App\Models\Cart::where('user_id', optional(Auth::user())->id)->get();
    $wishlist = \App\Models\Wishlist::where('user_id', optional(Auth::user())->id)->get();
    $categories = \App\Models\Category::orderBy('id', 'DESC')->get();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi">

    <title> {{ config('app.name') }} - Welcome to Our Restaurant Management </title>
    <meta name="description" content="MightyOlu Grocery - Welcome to Our Restaurant Management">

    <link rel="icon" type="image/png" href="/images/logo/favicon.png">
    <link rel="stylesheet" href="/user/css/all.min.css">
    <link rel="stylesheet" href="/user/css/bootstrap.min.css">
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
    <link rel="stylesheet" href="/backend/css/select2.min.css">



</head>

<body>

    <div class="" id="preloader">
        <div class="img d-none">
            <img src="/uploads/website-images/Spinner.gif" alt="UniFood" class="img-fluid">
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
                        <li><a href="mailto:example@gmail.com"><i class="fas fa-envelope"></i>
                                example@gmail.com</a>
                        </li>
                        <li><a href="callto:+1347-430-9510"><i class="fas fa-phone-alt"></i> +1347-430-9510</a></li>
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
                            <li><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
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
                        <a class="nav-link" href="#">About Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/product">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">contact us</a>
                    </li>
                </ul>
                <ul class="menu_icon d-flex flex-wrap">
                    <li>
                        <a href="javascript:;" class="menu_search"><i class="far fa-search"></i></a>
                        <div class="wsus__search_form">
                            <form action="https://unifood.websolutionus.com/products">
                                <span class="close_search"><i class="far fa-times"></i></span>
                                <input name="search" type="text" placeholder="Type your keyword">
                                <button type="submit">search</button>
                            </form>
                        </div>
                    </li>
                    <li>
                        <a class="cart_icon"><i class="fas fa-shopping-basket"></i> <span
                                class="topbar_cart_qty">{{ count($carts) }}</span></a>
                    </li>
                    <li>
                        <a href="/login"><i class="fas fa-user"></i></a>
                    </li>
                    <li>
                        <a class="common_btn" href="#">reservation</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="wsus__menu_cart_area">
        <div class="wsus__menu_cart_boody">
            <div class="wsus__menu_cart_header">
                <h5 class="mini_cart_body_item">Total Item(1)</h5>
                <span class="close_cart"><i class="fal fa-times" aria-hidden="true"></i></span>
            </div>
            @forelse ($carts as $cart)
                <ul class="mini_cart_list">
                    <li class="min-item mb-5">
                        <div class="menu_cart_img">
                            <img src="https://unifood.websolutionus.com/public/uploads/custom-images/hyderabadi-biryani-2023-03-05-01-14-59-9689.png"
                                alt="menu" class="img-fluid w-100">
                        </div>
                        <div class="menu_cart_text">
                            <a class="title"
                                href="https://unifood.websolutionus.com/product/hyderabadi-biryani">Hyderabadi Biryani
                            </a>
                            <p class="size">Small</p>


                            <p class="price mini-price">$130</p>
                        </div>
                        <input type="hidden"
                            class="mini-input-price set-mini-input-price"
                            value="130">
                        <span class="del_icon mini-item-remove"><i class="fal fa-times"
                                aria-hidden="true"></i></span>
                    </li>
                </ul>
            @empty
                <div class="wsus__menu_cart_header">
                    <h5>Your shopping cart is empty!</h5>
                    <span class="close_cart"><i class="fal fa-times"></i></span>
                </div>
            @endforelse
            <p class="subtotal">Sub Total <span class="mini_sub_total">$130</span></p>
            <a class="cart_view" href="{{ route('cart.index') }}"> view cart</a>
            <a class="checkout" href="https://unifood.websolutionus.com/">checkout</a>
        </div>
    </div>

    <!--=============================
        MENU END
    ==============================-->


    <!-- CART POPUT START -->
    <div class="wsus__cart_popup">
        <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                class="fal fa-times"></i></button>
                        <div class="load_product_modal_response">
                            <img src="/uploads/website-images/Spinner-1s-200px.gif" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CART POPUT END -->
    <!--=============================
        OFFER ITEM END
    ==============================-->


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
                            <span>There are many variations of Lorem Ipsum available, but the majority have
                                suffered.</span>
                            <p class="info"><i class="far fa-map-marker-alt"></i> 7232 Broadway 308, United States
                            </p>
                            <a class="info" href="callto:+1347-430-9510"><i class="fas fa-phone-alt"></i>
                                +1347-430-9510</a>
                            <a class="info" href="mailto:example@gmail.com"><i class="fas fa-envelope"></i>
                                example@gmail.com</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-md-6">
                        <div class="wsus__footer_content">
                            <h3>Important Link</h3>
                            <ul>
                                <li><a href="/">Home</a></li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Our Chef</a></li>
                                <li><a href="#">Dashboard</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-md-6 order-sm-4 order-lg-3">
                        <div class="wsus__footer_content">
                            <h3>Help Link</h3>
                            <ul>
                                <li><a href="#">Our Blogs</a></li>
                                <li><a href="#">Testimonial</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Privacy and Policy</a></li>
                                <li><a href="#">Terms anc Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-8 col-md-6 order-lg-4">
                        <div class="wsus__footer_content">
                            <h3>Subscribe to Newsletter</h3>
                            <form id="subscribe_form">
                                <input type="email" placeholder="Email" name="email">
                                <button id="subscribe_btn" type="submit"><i class="fas fa-paper-plane"></i></button>
                            </form>
                            <div class="wsus__footer_social_link">
                                <h5>Follow us:</h5>
                                <ul class="d-flex flex-wrap">
                                    <li><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li><a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                    <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                                    </li>
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
                            <p>©2024 websolutionus All rights reserved</p>
                            <ul class="d-flex flex-wrap">
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Payment</a></li>
                                <li><a href="#">Checkout</a></li>
                                <li><a href="#">Dashboard</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--=============================
        FOOTER END
    ==============================-->


    <!--jquery library js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!--bootstrap js-->
    <script src="/user/js/bootstrap.bundle.min.js"></script>
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

    <script src="/backend/js/bootstrap-datepicker.min.js"></script>

    <!--main/custom js-->
    <script src="/user/js/main.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"></script>
    <script src="/backend/js/select2.min.js"></script>
    <script src="{{ asset('show-password.min.js') }}"></script>
    @include('partials.message')
    @stack('scripts')
    <script>
            function calculate_mini_total(){
        let mini_sub_total = 0;
        let mini_total_item = 0;
        $(".mini-input-price").each(function () {
            let current_val = $(this).val();
            mini_sub_total = parseInt(mini_sub_total) + parseInt(current_val);
            mini_total_item = parseInt(mini_total_item) + parseInt(1);
        });

        $(".mini_sub_total").html(`$${mini_sub_total}`);
        $(".topbar_cart_qty").html(mini_total_item);
        $(".mini_cart_body_item").html(`Total Item(${mini_total_item})`);

        let mini_empty_cart = `<div class="wsus__menu_cart_header">
                <h5>Your shopping cart is empty!</h5>
                <span class="close_cart"><i class="fal fa-times"></i></span>
            </div>
            `;

        if(mini_total_item == 0){
            $(".wsus__menu_cart_boody").html(mini_empty_cart)
        }
    }
    </script>
</body>

</html>
