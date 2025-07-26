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
    <title> {{ config('app.name') }} - Welcome to Our Restaurant Management </title>
    <meta name="description" content="MightyOlu Grocery - Welcome to Our Restaurant Management">

    <link rel="icon" type="image/png" href="/images/logo/favicon.png">
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
            <div class="mobile_cart_icon">
                @php
                    $countCarts = session('cart', []);
                @endphp
                <a class="cart_icon"><i class="fas fa-shopping-basket"></i> <span  class="topbar_cart_qty">{{ count($countCarts) }}</span></a>
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
                </ul>
                <ul class="menu_icon d-flex flex-wrap">
                    <li>
                        <a href="javascript:;" class="menu_search"><i class="far fa-search"></i></a>
                        <div class="wsus__search_form">
                            <form action="{{ route('search') }}" method="GET">
                                <span class="close_search"><i class="far fa-times"></i></span>
                                <input name="search" type="text" placeholder="Type your keyword">
                                <button type="submit">search</button>
                            </form>
                        </div>
                    </li>
                    <li class="wsus__cart_desktop">
                        @php
                            $countCarts = session('cart', []);
                        @endphp
                        <a class="cart_icon">
                            <i class="fas fa-shopping-basket"></i> 
                            <span class="topbar_cart_qty" id="cart-count">{{ count($countCarts) }}</span>
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
                        <a class="common_btn" href="/login">Login</a>
                    </li>
                    {{-- <li>
                        <a class="common_btn" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">reservation</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>




<div class="wsus__menu_cart_area">
    <livewire:mini-cart />
    {{-- @include('partials.mini-cart') --}}
</div>



{{-- <div class="wsus__menu_cart_area">
    <div class="wsus__menu_cart_boody">
        @if (count($carts) > 0)
            <div class="wsus__menu_cart_header">
                <h5 class="mini_cart_body_item">Total Item({{ count($carts) }})</h5>
                <span class="close_cart"><i class="fal fa-times" aria-hidden="true"></i></span>
            </div>
        @endif 
       
        <ul class="mini_cart_list">
            @php $total = 0; @endphp
            @forelse ($carts as $cartId => $cartItem)
            
                @php
                    $subtotal = $cartItem['price'] * $cartItem['quantity'];
                    $total += $subtotal;

                    $product = App\Models\Product::findOrFail($cartItem['product_id'] ?? []);
                    // dd($product);
                @endphp
                <li class="min-item mb-5">
                    <div class="menu_cart_img">
                        <img src="{{ $product->images ?? $product->images ?? '/default-image.jpg' }}"  alt="menu" class="img-fluid w-100">
                    </div>
                    <div class="menu_cart_text">
                        <a class="title" href="{{ route('frontend.product.show', $cartItem['slug'] ?? $cartItem['product_id']) }}">
                            {{ \Str::limit($cartItem['title'], 50) }}
                        </a>
                        <div class="d-flex align-items-center" style="column-gap: 10px;">
                            <span class="quantity">{{ $cartItem['quantity'] }} x</span>
                            <p class="price mini-price">£{{ number_format($cartItem['price'], 2) }}</p>
                        </div>
                    </div>
                    <input type="hidden" class="mini-input-price set-mini-input-price" value="{{ $cartItem['price'] }}">
                    <a class="del_icon mini-item-remove" href="{{ route('cart.destroy', $cartId) }}"
                        onclick="event.preventDefault(); document.getElementById('delete-{{ $cartId }}').submit()" >
                        <i class="fal fa-times" aria-hidden="true"></i>
                    </a>
                    <form action="{{ route('cart.destroy', $cartId) }}" id="delete-{{ $cartId }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </li>
            @empty
                <div class="wsus__menu_cart_header">
                    <h5>Your shopping cart is empty!</h5>
                    <span class="close_cart"><i class="fal fa-times"></i></span>
                </div>
            @endforelse
        </ul>
   
        @if(count($carts) > 0)
            <p class="subtotal">Sub Total <span class="mini_sub_total">${{ number_format($total, 2) }}</span></p>
            <a class="cart_view" href="{{ route('cart.index') }}"> view cart</a>
            <a class="checkout" href="{{ route('checkout') }}">checkout</a>
        @endif
    </div>
</div> --}}
    {{-- <div class="wsus__reservation">
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Book a Table</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="wsus__reservation_form" method="POST" action="">
                                @csrf                                                                                               
                                <input class="reservation_input datepicker" type="text" autocomplete="off" name="reserve_date" required="" placeholder="Select date">
                                <select class="reservation_input" id="select_js" required="" name="reserve_time">
                                    <option value="">Select Time</option>
                                    <option value="12:00 AM - 01:00 AM">12:00 AM - 01:00 AM</option>
                                    <option value="01:00 AM - 02:00 AM">01:00 AM - 02:00 AM</option>
                                    <option value="02:00 AM - 03:00 AM">02:00 AM - 03:00 AM</option>
                                    <option value="03:00 AM - 04:00 AM">03:00 AM - 04:00 AM</option>
                                    <option value="04:00 AM - 05:00 AM">04:00 AM - 05:00 AM</option>
                                    <option value="05:00 AM - 06:00 AM">05:00 AM - 06:00 AM</option>
                                    <option value="06:00 AM - 07:00 AM">06:00 AM - 07:00 AM</option>
                                    <option value="07:00 AM - 08:00 AM">07:00 AM - 08:00 AM</option>
                                    <option value="08:00 AM - 09:00 AM">08:00 AM - 09:00 AM</option>
                                    <option value="09:00 AM - 10:00 AM">09:00 AM - 10:00 AM</option>
                                    <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                                    <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                                    <option value="12:00 PM - 01:00 PM">12:00 PM - 01:00 PM</option>
                                    <option value="01:00 PM - 02:00 PM">01:00 PM - 02:00 PM</option>
                                    <option value="02:00 PM - 03:00 PM">02:00 PM - 03:00 PM</option>
                                    <option value="03:00 PM - 04:00 PM">03:00 PM - 04:00 PM</option>
                                    <option value="04:00 PM - 05:00 PM">04:00 PM - 05:00 PM</option>
                                    <option value="05:00 PM - 06:00 PM">05:00 PM - 06:00 PM</option>
                                    <option value="06:00 PM - 07:00 PM">06:00 PM - 07:00 PM</option>
                                    <option value="07:00 PM - 08:00 PM">07:00 PM - 08:00 PM</option>
                                    <option value="08:00 PM - 09:00 PM">08:00 PM - 09:00 PM</option>
                                    <option value="09:00 PM - 10:00 PM">09:00 PM - 10:00 PM</option>
                                    <option value="10:00 PM - 11:00 PM">10:00 PM - 11:00 PM</option>
                                    <option value="11:00 PM - 12:00 AM">11:00 PM - 12:00 AM</option>
                                </select>
                                <input class="reservation_input" type="number" placeholder="Number of person" name="person" required="">
                                <button type="submit">Send Request</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    <!--=============================
        MENU END
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
                            <p class="info"><i class="far fa-map-marker-alt"></i> Unit 10 western Halls Plaza Edinburgh, EH14 1SW, Wester Hails. </p>
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
                            <p class="text-center">&copy;{{ date('Y') }} <a href="https://dexnovate.com" target="_blank">Dexnovate</a> All rights reserved</p>
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
</body>

</html>
