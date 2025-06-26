<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi">

    <title>UniFood - Welcome to Our Restaurant Management Project</title>
    <meta name="description" content="Unifood - Welcome to Our Restaurant Management">

    <link rel="icon" type="image/png" href="/images/logo/favicon.png">
    <link rel="stylesheet" href="/user/css/all.min.css">
    <link rel="stylesheet" href="/user/css/bootstrap.min.css">
    <link rel="stylesheet" href="/user/css/spacing.css">
    <link rel="stylesheet" href="/user/css/slick.css">
    <link rel="stylesheet" href="/user/css/nice-select.css">
    <link rel="stylesheet" href="/user/css/venobox.min.css">
    <link rel="stylesheet" href="/user/css/animate.css">
    <link rel="stylesheet" href="/user/css/jquery.exzoom.css">
    <link rel="stylesheet" href="/toastr/toastr.min.css">
    <link rel="stylesheet" href="/user/css/style.css">
    <link rel="stylesheet" href="/user/css/responsive.css">
    <link rel="stylesheet" href="/backend/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/backend/css/select2.min.css">


    <style>
        :root {
            --colorPrimary: #eb0029;
            --paraColor: #494949;
            --colorBlack: #010f1c;
            --colorWhite: #ffffff;
            --paraFont: 'Barlow', sans-serif;
            --headingFont: 'Jost', sans-serif;
            --cursiveFont: 'Lobster', cursive;
            --boxShadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            --gradiantBg: rgb(156, 3, 30)linear-gradient(0deg, rgba(156, 3, 30, 1) 0%, rgba(235, 0, 41, 1) 100%);
            --gradiantHoverBg: rgb(235, 0, 41)linear-gradient(0deg, rgba(235, 0, 41, 1) 0%, rgba(156, 3, 30, 1) 100%);
        }


        .footer_overlay {
            background: #b90424fa !important;
        }


        .topbar_icon li a {
            background: #ca0628 !important;
        }
    </style>

    
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
                            <form id="setLanguage" action="https://unifood.websolutionus.com/set-language">
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
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo/logo.png') }}" alt="UniFood" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="far fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav m-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Products</a>
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
                                class="topbar_cart_qty">0</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-user"></i></a>
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
                <h5>Your shopping cart is empty!</h5>
                <span class="close_cart"><i class="fal fa-times"></i></span>
            </div>

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
                                <img src="{{ asset('images/logo/footer_logo.png') }}"
                                    alt="UniFood" class="img-fluid w-100">
                            </a>
                            <span>There are many variations of Lorem Ipsum available, but the majority have
                                suffered.</span>
                            <p class="info"><i class="far fa-map-marker-alt"></i> 7232 Broadway 308, United States
                            </p>
                            <a class="info" href="callto:+1347-430-9510"><i class="fas fa-phone-alt"></i>
                                +1347-430-9510</a>
                            <a class="info" href="mailto:example@gmail.com"><i
                                    class="fas fa-envelope"></i>
                                example@gmail.com</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-md-6">
                        <div class="wsus__footer_content">
                            <h3>Important Link</h3>
                            <ul>
                                <li><a href="index.htm">Home</a></li>
                                <li><a href="about-us.html">About Us</a></li>
                                <li><a href="contact-us.html">Contact Us</a></li>
                                <li><a href="our-chef.html">Our Chef</a></li>
                                <li><a href="our-chef.html">Dashboard</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-md-6 order-sm-4 order-lg-3">
                        <div class="wsus__footer_content">
                            <h3>Help Link</h3>
                            <ul>
                                <li><a href="blogs.html">Our Blogs</a></li>
                                <li><a href="testimonial.html">Testimonial</a></li>
                                <li><a href="faq.html">FAQ</a></li>
                                <li><a href="privacy-policy.html">Privacy and Policy</a></li>
                                <li><a href="terms-and-condition.html">Terms anc Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-8 col-md-6 order-lg-4">
                        <div class="wsus__footer_content">
                            <h3>Subscribe to Newsletter</h3>
                            <form id="subscribe_form">
                                <input type="hidden" name="_token"
                                    value="bEl0FV3NGFotgbZzLm70xYzARsANzVbxSb6MiMoq" autocomplete="off"> <input
                                    type="email" placeholder="Email" name="email">
                                <button id="subscribe_btn" type="submit"><i
                                        class="fas fa-paper-plane"></i></button>
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
                                <li><a href="faq.html">FAQ</a></li>
                                <li><a href="login.html">Payment</a></li>
                                <li><a href="login.html">Checkout</a></li>
                                <li><a href="login.html">Dashboard</a></li>
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
    <script src="/user/js/jquery-3.6.3.min.js"></script>
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

    <script src="/toastr/toastr.min.js"></script>
    <script src="/backend/js/select2.min.js"></script>

</body>
</html>

