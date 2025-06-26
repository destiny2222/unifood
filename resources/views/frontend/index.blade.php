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
                <div class="col-12">
                    <div class="wsus__banner_slider">
                        <div class=" container">
                            <div class="row">
                                <div class="col-xl-5 col-md-5 col-lg-5">
                                    <div class="wsus__banner_img wow fadeInLeft" data-wow-duration="1s">
                                        <div class="img">
                                            <img src="{{ asset('website-images/slider-01.png') }}"
                                                alt="food item" class="img-fluid w-100">
                                            <span style="background: url(/user/images/offer_shapes.png);">
                                                35% off
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-5 col-md-7 col-lg-6">
                                    <div class="wsus__banner_text wow fadeInRight" data-wow-duration="1s">
                                        <h1>Special Deals Today</h1>
                                        <h3>Fast Food &amp; Restaurants</h3>
                                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsum fugit minima
                                            et debitis ut distinctio optio qui voluptate natus.</p>
                                        <ul class="d-flex flex-wrap">
                                            <li><a class="common_btn" href="product/fried-chicken.html">Shop now</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="wsus__banner_slider">
                        <div class=" container">
                            <div class="row">
                                <div class="col-xl-5 col-md-5 col-lg-5">
                                    <div class="wsus__banner_img wow fadeInLeft" data-wow-duration="1s">
                                        <div class="img">
                                            <img src="{{ asset('website-images/slider-02.png') }}"
                                                alt="food item" class="img-fluid w-100">
                                            <span style="background: url(/user/images/offer_shapes.png);">
                                                25% Off
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-5 col-md-7 col-lg-6">
                                    <div class="wsus__banner_text wow fadeInRight" data-wow-duration="1s">
                                        <h1>Delicious Food Options</h1>
                                        <h3>Satisfy Your Cravings</h3>
                                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsum fugit minima
                                            et debitis ut distinctio optio qui voluptate natus.</p>
                                        <ul class="d-flex flex-wrap">
                                            <li><a class="common_btn" href="product/daria-shevtsova.html">Shop now</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="wsus__banner_slider">
                        <div class=" container">
                            <div class="row">
                                <div class="col-xl-5 col-md-5 col-lg-5">
                                    <div class="wsus__banner_img wow fadeInLeft" data-wow-duration="1s">
                                        <div class="img">
                                            <img src="{{ asset('website-images/slider-03.png') }}"
                                                alt="food item" class="img-fluid w-100">
                                            <span style="background: url(/user/images/offer_shapes.png);">
                                                20% off
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-5 col-md-7 col-lg-6">
                                    <div class="wsus__banner_text wow fadeInRight" data-wow-duration="1s">
                                        <h1>Mouth-Watering Dishes</h1>
                                        <h3>Try Something New</h3>
                                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsum fugit minima
                                            et debitis ut distinctio optio qui voluptate natus.</p>
                                        <ul class="d-flex flex-wrap">
                                            <li><a class="common_btn" href="product/onion-rings.html">Shop now</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                <div class="col-xl-4 col-md-6 col-lg-4">
                    <div class="wsus__choose_single d-flex flex-wrap align-items-center justify-content-between">
                        <div class="icon icon_1">
                            <i class="fal fa-badge-percent"></i>
                        </div>
                        <div class="text">
                            <h3>Discount Voucher</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit est</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-4">
                    <div class="wsus__choose_single d-flex flex-wrap align-items-center justify-content-between">
                        <div class="icon icon_1">
                            <i class="fas fa-burger-soda"></i>
                        </div>
                        <div class="text">
                            <h3>Fresh Healthy Foods</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit est</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-4">
                    <div class="wsus__choose_single d-flex flex-wrap align-items-center justify-content-between">
                        <div class="icon icon_1">
                            <i class="far fa-hat-chef"></i>
                        </div>
                        <div class="text">
                            <h3>Fast Serve On Table</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit est</p>
                        </div>
                    </div>
                </div>
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
            <img src="{{ asset('images/shape/today_special_image.png') }}" alt="shape"
                class="img-fluid w-100">
        </span>
        <div class="container">
            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                    <div class="wsus__section_heading mb_50">
                        <h4>Daily Offer</h4>
                        <h2>Up To 75% Off For This Day</h2>
                        <span>
                            <img src="/user/images/heading_shapes.png" alt="shapes" class="img-fluid w-100">
                        </span>
                        <p>Objectively pontificate quality models before intuitive information. Dramatically
                            recaptiualize multifunctional.</p>
                    </div>
                </div>
            </div>
            <div class="row offer_item_slider wow fadeInUp" data-wow-duration="1s">
                <div class="col-xl-4">
                    <div class="wsus__offer_item_single"
                        style="background: url(/custom-images/dal-makhani-paneer-2023-03-05-01-25-44-9364.jpg);">

                        <span>17% off</span>

                        <a class="title" href="product/dal-makhani-paneer.html">Dal Makhani Paneer</a>
                        <p>Nec in rebum primis causae. Affert iisque ex pri, vis utinam vivendo definitionem ad, nostrum
                            omnesque per et. Omnium antiopam cotidieque cu sit.</p>
                        <ul class="d-flex flex-wrap">
                            <li><a href="javascript:;" onclick="load_product_model(2)"><i
                                        class="fas fa-shopping-basket"></i></a></li>

                            <li><a href="javascript:;" onclick="before_auth_wishlist(2)"><i
                                        class="fal fa-heart"></i></a></li>


                            <li><a href="product/dal-makhani-paneer.html"><i class="far fa-eye"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="wsus__offer_item_single"
                        style="background: url(/custom-images/indian-cuisine-pakora-2023-03-05-01-32-04-5856.jpg);">

                        <span>17% off</span>

                        <a class="title" href="product/indian-cuisine-pakora.html">Indian cuisine Pakora</a>
                        <p>Per ex vero nonumy. Ius eu doming nominavi mediocrem, aliquid efficiantur no vim, sanctus
                            admodum mnesarchum ad pro. No sea invidunt partiendo. No postea numquam ocurreret duo, unum
                            abhorreant cu nam, fugit fastidii percipitur nam id.</p>
                        <ul class="d-flex flex-wrap">
                            <li><a href="javascript:;" onclick="load_product_model(3)"><i
                                        class="fas fa-shopping-basket"></i></a></li>

                            <li><a href="javascript:;" onclick="before_auth_wishlist(3)"><i
                                        class="fal fa-heart"></i></a></li>


                            <li><a href="product/indian-cuisine-pakora.html"><i class="far fa-eye"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="wsus__offer_item_single"
                        style="background: url(/custom-images/beef-masala-salad-2023-03-05-01-42-23-6194.jpg);">

                        <span>13% off</span>

                        <a class="title" href="product/beef-masala-salad.html">Beef Masala Salad</a>
                        <p>In vim natum soleat nostro, pri in eloquentiam contentiones. Eu sit sapientem reprehendunt,
                            omnis aliquid eu eos. No quot illum veniam est, ne pro iudico saperet mnesarchum.</p>
                        <ul class="d-flex flex-wrap">
                            <li><a href="javascript:;" onclick="load_product_model(4)"><i
                                        class="fas fa-shopping-basket"></i></a></li>

                            <li><a href="javascript:;" onclick="before_auth_wishlist(4)"><i
                                        class="fal fa-heart"></i></a></li>


                            <li><a href="product/beef-masala-salad.html"><i class="far fa-eye"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="wsus__offer_item_single"
                        style="background: url(/custom-images/chicken-nuggets-2023-03-05-01-50-15-6100.jpg);">

                        <span>40% off</span>

                        <a class="title" href="product/chicken-nuggets.html">Chicken Nuggets</a>
                        <p>Sint dignissim consectetuer nec et, per ad probatus referrentur, vel cu consequat sententiae.
                            Ad duis fugit dictas mea, et cum stet oratio cetero. Ne pri omittam fastidii. No per harum
                            dicant neglegentur, sea ei esse volumus adolescens.</p>
                        <ul class="d-flex flex-wrap">
                            <li><a href="javascript:;" onclick="load_product_model(5)"><i
                                        class="fas fa-shopping-basket"></i></a></li>

                            <li><a href="javascript:;" onclick="before_auth_wishlist(5)"><i
                                        class="fal fa-heart"></i></a></li>


                            <li><a href="product/chicken-nuggets.html"><i class="far fa-eye"></i></a></li>
                        </ul>
                    </div>
                </div>

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
                        <p>Objectively pontificate quality models before intuitive information. Dramatically
                            recaptiualize multifunctional.</p>
                    </div>
                </div>
            </div>

            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-12">
                    <div class="menu_filter d-flex flex-wrap justify-content-center">
                        <button class="first_menu_product" data-filter=".category_1">Burger</button>
                        <button class="" data-filter=".category_2">Chicken</button>
                        <button class="" data-filter=".category_3">Pizza</button>
                        <button class="" data-filter=".category_4">Dresserts</button>
                        <button class="" data-filter=".category_5">Sandwich</button>
                    </div>
                </div>
            </div>

            <div class="row grid">
                <div class="col-xl-3 col-sm-6 col-lg-4 category_1 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/hyderabadi-biryani-2023-03-05-01-14-59-9689.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Burger</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>1</span>
                            </p>
                            <a class="title" href="product/hyderabadi-biryani.html">Hyderabadi Biryani</a>

                            <h5 class="price">$130 <del>$150</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(1)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(1)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/hyderabadi-biryani.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_1 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/daria-shevtsova-2023-03-05-02-47-26-3957.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Burger</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>0</span>
                            </p>
                            <a class="title" href="product/daria-shevtsova.html">Daria Shevtsova</a>

                            <h5 class="price">$120 <del>$200</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(6)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(6)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/daria-shevtsova.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_1 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/spicy-burger-2023-03-05-02-57-08-4535.png" alt="menu"
                                class="img-fluid w-100">
                            <a class="category" href="#">Burger</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>1</span>
                            </p>
                            <a class="title" href="product/spicy-burger.html">Spicy Burger</a>

                            <h5 class="price">$40 <del>$80</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(7)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(7)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/spicy-burger.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_1 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/fried-chicken-2023-03-05-02-59-51-6567.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Burger</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>0</span>
                            </p>
                            <a class="title" href="product/fried-chicken.html">Fried Chicken</a>

                            <h5 class="price">$50 <del>$60</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(8)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(8)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/fried-chicken.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_1 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/mozzarella-sticks-2023-03-05-03-05-46-3294.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Burger</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>0</span>
                            </p>
                            <a class="title" href="product/mozzarella-sticks.html">Mozzarella Sticks</a>

                            <h5 class="price">$70 <del>$110</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(9)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(9)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/mozzarella-sticks.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_1 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/popcorn-chicken-2023-03-05-03-10-01-2671.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Burger</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>0</span>
                            </p>
                            <a class="title" href="product/popcorn-chicken.html">Popcorn Chicken</a>

                            <h5 class="price">$60 <del>$90</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(10)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(10)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/popcorn-chicken.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_1 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/chicken-wings-2023-03-05-03-14-33-3228.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Burger</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>0</span>
                            </p>
                            <a class="title" href="product/chicken-wings.html">Chicken Wings</a>

                            <h5 class="price">$75 <del>$80</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(11)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(11)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/chicken-wings.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_1 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/onion-rings-2023-03-05-03-23-09-1753.png" alt="menu"
                                class="img-fluid w-100">
                            <a class="category" href="#">Burger</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>0</span>
                            </p>
                            <a class="title" href="product/onion-rings.html">Onion Rings</a>

                            <h5 class="price">$30 <del>$35</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(12)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(12)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/onion-rings.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_2 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/firecracker-shrimp-2023-03-06-12-25-11-9828.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Chicken</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>0</span>
                            </p>
                            <a class="title" href="product/firecracker-shrimp.html">Firecracker Shrimp</a>

                            <h5 class="price">$25 <del>$30</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(15)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(15)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/firecracker-shrimp.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_2 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/grilled-octopus-salad-2023-03-06-12-28-49-3466.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Chicken</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>0</span>
                            </p>
                            <a class="title" href="product/grilled-octopus-salad.html">Grilled Octopus Salad</a>

                            <h5 class="price">$70 <del>$75</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(16)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(16)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/grilled-octopus-salad.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_3 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/pesto-and-burrata-crostini-2023-03-06-12-35-05-9316.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Pizza</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>0</span>
                            </p>
                            <a class="title" href="product/pesto-and-burrata-crostini.html">Pesto and Burrata
                                Crostini</a>

                            <h5 class="price">$65 <del>$100</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(17)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(17)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/pesto-and-burrata-crostini.html"><i class="far fa-eye"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_3 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/lobster-bisque-2023-03-06-12-40-12-7186.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Pizza</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>0</span>
                            </p>
                            <a class="title" href="product/lobster-bisque.html">Lobster Bisque</a>

                            <h5 class="price">$60</h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(18)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(18)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/lobster-bisque.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_4 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/seared-ahi-tuna-2023-03-06-12-47-21-4113.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Dresserts</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>0</span>
                            </p>
                            <a class="title" href="product/seared-ahi-tuna.html">Seared Ahi Tuna</a>

                            <h5 class="price">$85 <del>$90</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(19)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(19)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/seared-ahi-tuna.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_4 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/quinoa-stuffed-peppers-2023-03-06-12-52-48-9661.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Dresserts</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>0</span>
                            </p>
                            <a class="title" href="product/quinoa-stuffed-peppers.html">Quinoa Stuffed Peppers</a>

                            <h5 class="price">$110</h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(20)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(20)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/quinoa-stuffed-peppers.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_5 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/pulled-pork-sliders-2023-03-06-01-02-22-7233.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Sandwich</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>1</span>
                            </p>
                            <a class="title" href="product/pulled-pork-sliders.html">Pulled Pork Sliders</a>

                            <h5 class="price">$130 <del>$150</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(21)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(21)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/pulled-pork-sliders.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 category_5 wow fadeInUp " data-wow-duration="1s">
                    <div class="wsus__menu_item">
                        <div class="wsus__menu_item_img">
                            <img src="/custom-images/truffle-fries-2023-03-06-01-06-09-8443.png"
                                alt="menu" class="img-fluid w-100">
                            <a class="category" href="#">Sandwich</a>
                        </div>
                        <div class="wsus__menu_item_text">
                            <p class="rating">

                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>1</span>
                            </p>
                            <a class="title" href="product/truffle-fries.html">Truffle Fries</a>

                            <h5 class="price">$150 <del>$200</del> </h5>

                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="javascript:;" onclick="load_product_model(22)"><i
                                            class="fas fa-shopping-basket"></i></a></li>


                                <li><a href="javascript:;" onclick="before_auth_wishlist(22)"><i
                                            class="fal fa-heart"></i></a></li>

                                <li><a href="product/truffle-fries.html"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

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
                <div class="col-xl-4">
                    <a href="product/onion-rings.html" class="wsus__add_slider_single"
                        style="background: url(custom-images/advertisement-2023-03-05-04-00-30-5264.png);">
                        <div class="text">
                            <h3>Fried Chicken</h3>
                            <p>Lorem ipsum dolor sit amet consectetur.</p>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4">
                    <a href="product/fried-chicken.html" class="wsus__add_slider_single"
                        style="background: url(custom-images/advertisement-2023-03-05-04-01-56-2034.png);">
                        <div class="text">
                            <h3>Spicy Burger</h3>
                            <p>Lorem ipsum dolor sit amet consectetur.</p>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4">
                    <a href="product/spicy-burger.html" class="wsus__add_slider_single"
                        style="background: url(custom-images/advertisement-2023-03-05-04-03-43-9191.png);">
                        <div class="text">
                            <h3>New Year</h3>
                            <p>Lorem ipsum dolor sit amet consectetur.</p>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4">
                    <a href="product/mozzarella-sticks.html" class="wsus__add_slider_single"
                        style="background: url(custom-images/advertisement-2023-03-05-04-06-17-9213.png);">
                        <div class="text">
                            <h3>Black Firday</h3>
                            <p>Lorem ipsum dolor sit amet consectetur.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        ADD SLIDER END
    ==============================-->


    <!--=============================
        TEAM START
    ==============================-->
    <section class="wsus__team pt_95 xs_pt_65 pb_150 xs_pb_120" style="background: url({{ asset('chefs_bg.jpg') }});">
        <span class="banner_shape_1">
            <img src="{{ asset('images/shape/chef_left_image.png') }}" alt="shape"
                class="img-fluid w-100">
        </span>
        <span class="banner_shape_2">
            <img src="{{ asset('images/shape/chef_right_image.png') }}" alt="shape"
                class="img-fluid w-100">
        </span>
        <div class="container">
            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                    <div class="wsus__section_heading mb_25">
                        <h4>Our Team</h4>
                        <h2>Meet Our Expert Chefs</h2>
                        <span>
                            <img src="/user/images/heading_shapes.png" alt="shapes" class="img-fluid w-100">
                        </span>
                        <p>Objectively pontificate quality models before intuitive information. Dramatically
                            recaptiualize multifunctional.</p>
                    </div>
                </div>
            </div>

            <div class="row team_slider">
                <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_team">
                        <div class="wsus__single_team_img">
                            <img src="/custom-images/olivia-ava-20230305042302.jpg" alt="team"
                                class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_team_text">
                            <h4>Olivia Ava</h4>
                            <p>Senior Chef</p>
                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a></li>

                                <li><a href="https://www.linkedin.com"><i class="fab fa-linkedin-in"></i></a></li>

                                <li><a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a></li>

                                <li><a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_team">
                        <div class="wsus__single_team_img">
                            <img src="/custom-images/john-doe-20230305042351.jpg" alt="team"
                                class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_team_text">
                            <h4>John Doe</h4>
                            <p>Senior Chef</p>
                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a></li>

                                <li><a href="https://www.linkedin.com"><i class="fab fa-linkedin-in"></i></a></li>

                                <li><a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a></li>

                                <li><a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_team">
                        <div class="wsus__single_team_img">
                            <img src="/custom-images/sophia-charle-20230305042513.jpg" alt="team"
                                class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_team_text">
                            <h4>Sophia Charle</h4>
                            <p>Intern Chef</p>
                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a></li>

                                <li><a href="https://www.linkedin.com"><i class="fab fa-linkedin-in"></i></a></li>

                                <li><a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a></li>

                                <li><a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_team">
                        <div class="wsus__single_team_img">
                            <img src="/custom-images/david-richard-20230305042547.jpg" alt="team"
                                class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_team_text">
                            <h4>David Richard</h4>
                            <p>Junior Chef</p>
                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a></li>

                                <li><a href="https://www.linkedin.com"><i class="fab fa-linkedin-in"></i></a></li>

                                <li><a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a></li>

                                <li><a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_team">
                        <div class="wsus__single_team_img">
                            <img src="/custom-images/flora-ocean-20230305042650.jpg" alt="team"
                                class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_team_text">
                            <h4>Flora Ocean</h4>
                            <p>Web Developer</p>
                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a></li>

                                <li><a href="https://www.linkedin.com"><i class="fab fa-linkedin-in"></i></a></li>

                                <li><a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a></li>

                                <li><a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_team">
                        <div class="wsus__single_team_img">
                            <img src="/custom-images/freyja-mylah-20230305042759.jpg" alt="team"
                                class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_team_text">
                            <h4>Freyja Mylah</h4>
                            <p>Graphic Designer</p>
                            <ul class="d-flex flex-wrap justify-content-center">
                                <li><a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a></li>

                                <li><a href="https://www.linkedin.com"><i class="fab fa-linkedin-in"></i></a></li>

                                <li><a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a></li>

                                <li><a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        TEAM END
    ==============================-->


    <!--=============================
        DOWNLOAD APP START
    ==============================-->

    <section class="wsus__download mt_100 xs_mt_70">
        <div class="container">
            <div class="wsus__download_bg"
                style="background: url({{ asset('app_background_one.jpg') }});">
                <div class="wsus__download_overlay">
                    <div class="row justify-content-between">
                        <div class="col-xl-5 col-lg-6 wow fadeInUp" data-wow-duration="1s">
                            <div class="wsus__download_text">
                                <div class="wsus__section_heading mb_25">
                                    <h2>Download Our Mobile Apps</h2>
                                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque assumenda
                                        tenetur, provident earum consequatur, ut voluptas laboriosam fuga error aut
                                        eaque architecto quo pariatur. Vel dolore omnis quisquam. Lorem ipsum dolor, sit
                                        amet consectetur adipisicing elit Cumque.</p>
                                </div>
                                <ul class="d-flex flex-wrap">
                                    <li>
                                        <a href="https://play.google.com/">
                                            <i class="fab fa-google-play"></i>
                                            <p> <span>download from</span> google play </p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.apple.com/app-store/">
                                            <i class="fab fa-apple"></i>
                                            <p> <span>download from</span> apple store </p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-duration="1s">
                            <div class="wsus__download_img">
                                <img src="/app-image.png"
                                    alt="download" class="img-fluid w-100">
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
        style="background: url( {{ asset('counter-bg.jpg') }} );">
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
                        <p>Objectively pontificate quality models before intuitive information. Dramatically
                            recaptiualize multifunctional.</p>
                    </div>
                </div>
            </div>

            <div class="row testi_slider">
                <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_testimonial">
                        <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                            <div class="img">
                                <img src="/custom-images/elia-navy-20230305045641.jpg" alt="clients"
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
                            <img src="/custom-images/testimonial-product-20230305045641.png" alt="product"
                                class="img-fluid w-100">
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_testimonial">
                        <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                            <div class="img">
                                <img src="/custom-images/john-abraham-20230305045819.jpg" alt="clients"
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
                            <img src="/custom-images/testimonial-product-20230305045819.png" alt="product"
                                class="img-fluid w-100">
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_testimonial">
                        <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                            <div class="img">
                                <img src="/custom-images/jose-larry-20230305050016.jpg" alt="clients"
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
                            <img src="/custom-images/testimonial-product-20230305050016.png" alt="product"
                                class="img-fluid w-100">
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_testimonial">
                        <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                            <div class="img">
                                <img src="/custom-images/david-richard-20230305050113.jpg" alt="clients"
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
                            <img src="/custom-images/testimonial-product-20230305050113.png" alt="product"
                                class="img-fluid w-100">
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_testimonial">
                        <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                            <div class="img">
                                <img src="/custom-images/david-simmons-20230305050400.jpg" alt="clients"
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
                            <img src="/custom-images/testimonial-product-20230305050400.png" alt="product"
                                class="img-fluid w-100">
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_testimonial">
                        <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                            <div class="img">
                                <img src="/custom-images/mary-patricia-20230305050436.jpg" alt="clients"
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
                            <img src="/custom-images/testimonial-product-20230305050436.png" alt="product"
                                class="img-fluid w-100">
                        </div>
                    </div>
                </div>
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
                            <p>Objectively pontificate quality models before intuitive information. Dramatically
                                recaptiualize multifunctional.</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__single_blog">
                            <a href="blog/the-secret-to-perfectly-cooked-steaks.html" class="wsus__single_blog_img">
                                <img src="{{ asset('images/blog/blog-02.jpg') }}" alt="blog"
                                    class="img-fluid w-100">
                            </a>
                            <div class="wsus__single_blog_text">
                                <a class="category" href="blogs-1.html?category=chicken">Chicken</a>
                                <ul class="d-flex flex-wrap mt_15">
                                    <li><i class="fas fa-user"></i>by admin</li>
                                    <li><i class="fas fa-calendar-alt"></i> 05 Mar 2023</li>
                                    <li><i class="fas fa-comments"></i> 0comment</li>
                                </ul>
                                <a class="title" href="blog/the-secret-to-perfectly-cooked-steaks.html">The Secret
                                    to Perfectly Cooked Steaks</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__single_blog">
                            <a href="blog/why-our-pasta-is-worth-the-visit.html" class="wsus__single_blog_img">
                                <img src="{{ asset('images/blog/blog-01.jpg') }}" alt="blog"
                                    class="img-fluid w-100">
                            </a>
                            <div class="wsus__single_blog_text">
                                <a class="category" href="blogs-1.html?category=chicken">Chicken</a>
                                <ul class="d-flex flex-wrap mt_15">
                                    <li><i class="fas fa-user"></i>by admin</li>
                                    <li><i class="fas fa-calendar-alt"></i> 05 Mar 2023</li>
                                    <li><i class="fas fa-comments"></i> 0comment</li>
                                </ul>
                                <a class="title" href="blog/why-our-pasta-is-worth-the-visit.html">Why Our Pasta is
                                    Worth the Visit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__single_blog">
                            <a href="blog/the-science-of-pairing-wine-and-cheese.html"
                                class="wsus__single_blog_img">
                                <img src="{{ asset('images/blog/blog-03.jpg') }}" alt="blog"
                                    class="img-fluid w-100">
                            </a>
                            <div class="wsus__single_blog_text">
                                <a class="category" href="blogs-2.html?category=fresh-food">Fresh Food</a>
                                <ul class="d-flex flex-wrap mt_15">
                                    <li><i class="fas fa-user"></i>by admin</li>
                                    <li><i class="fas fa-calendar-alt"></i> 05 Mar 2023</li>
                                    <li><i class="fas fa-comments"></i> 0comment</li>
                                </ul>
                                <a class="title" href="blog/the-science-of-pairing-wine-and-cheese.html">The
                                    Science of Pairing Wine and Cheese</a>
                            </div>
                        </div>
                    </div>
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
    <section class="wsus__brand"
        style="background: url({{ asset('counter-bg.jpg') }});">
        <div class="wsus__brand_overlay">
            <div class="container">
                <div class="row brand_slider wow fadeInUp" data-wow-duration="1s">
                    <div class="col-xl-2">
                        <a class="wsus__single_brand" href="javascript:;">
                            <img src="/custom-images/partner-2023-03-05-04-35-57-4275.png" alt="brand"
                                class="img-fluid w-100">
                        </a>

                    </div>
                    <div class="col-xl-2">
                        <a class="wsus__single_brand" href="javascript:;">
                            <img src="/custom-images/partner-2023-03-05-04-36-05-2512.png" alt="brand"
                                class="img-fluid w-100">
                        </a>

                    </div>
                    <div class="col-xl-2">
                        <a class="wsus__single_brand" href="javascript:;">
                            <img src="/custom-images/partner-2023-03-05-04-36-15-7213.png" alt="brand"
                                class="img-fluid w-100">
                        </a>

                    </div>
                    <div class="col-xl-2">
                        <a class="wsus__single_brand" href="javascript:;">
                            <img src="/custom-images/partner-2023-03-05-04-36-24-3552.png" alt="brand"
                                class="img-fluid w-100">
                        </a>

                    </div>
                    <div class="col-xl-2">
                        <a class="wsus__single_brand" href="javascript:;">
                            <img src="/custom-images/partner-2023-03-05-04-36-34-1671.png" alt="brand"
                                class="img-fluid w-100">
                        </a>

                    </div>
                    <div class="col-xl-2">
                        <a class="wsus__single_brand" href="javascript:;">
                            <img src="/custom-images/partner-2023-03-05-04-36-42-1713.png" alt="brand"
                                class="img-fluid w-100">
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BRAND END
    ==============================-->
@endsection   