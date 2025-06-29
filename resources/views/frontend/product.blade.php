@extends('layouts.main')
@section('content')
@section('title', 'Product')
<!--=============================
            BREADCRUMB START
        ==============================-->
@include('partials.breadcrumb')
<!--=============================
        BREADCRUMB END
    ==============================-->


<!--=============================
        SEARCH MENU START
    ==============================-->
<section class="wsus__search_menu mt_120 xs_mt_90 mb_100 xs_mb_70">
    <div class="container">
        <form class="wsus__search_menu_form" action="">
            <div class="row">
                <div class="col-xl-6 col-md-5">
                    <input type="text" placeholder="Type your keyword" name="search">
                </div>
                <div class="col-xl-4 col-md-4">
                    <select id="select_js2" name="category">
                        <option value="">Select category</option>
                        <option value="burger">Burger</option>
                        <option value="chicken">Chicken</option>
                        <option value="pizza">Pizza</option>
                        <option value="dresserts">Dresserts</option>
                        <option value="sandwich">Sandwich</option>
                        <option value="burrito">Burrito</option>
                        <option value="cheeseburger">Cheeseburger</option>
                        <option value="muffin">Muffin</option>
                    </select>
                </div>
                <div class="col-xl-2 col-md-3">
                    <button type="submit" class="common_btn">search</button>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-6 col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__menu_item">
                    <div class="wsus__menu_item_img">
                        <img src="/images/truffle-fries.png"
                            alt="menu" class="img-fluid w-100">
                        <a class="category" href="products-1.html?category=sandwich">Sandwich</a>
                    </div>
                    <div class="wsus__menu_item_text">
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
            <div class="col-6 col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__menu_item">
                    <div class="wsus__menu_item_img">
                        <img src="/images/pulled-pork-sliders.png"
                            alt="menu" class="img-fluid w-100">
                        <a class="category" href="products-1.html?category=sandwich">Sandwich</a>
                    </div>
                    <div class="wsus__menu_item_text">
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
            <div class="col-6 col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__menu_item">
                    <div class="wsus__menu_item_img">
                        <img src="/images/quinoa-stuffed-peppers.png"
                            alt="menu" class="img-fluid w-100">
                        <a class="category" href="products-2.html?category=dresserts">Dresserts</a>
                    </div>
                    <div class="wsus__menu_item_text">
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
            <div class="col-6 col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__menu_item">
                    <div class="wsus__menu_item_img">
                        <img src="/images/seared-ahi-tuna.png"
                            alt="menu" class="img-fluid w-100">
                        <a class="category" href="products-2.html?category=dresserts">Dresserts</a>
                    </div>
                    <div class="wsus__menu_item_text">
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
            <div class="col-6 col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__menu_item">
                    <div class="wsus__menu_item_img">
                        <img src="/images/lobster-bisque.png"
                            alt="menu" class="img-fluid w-100">
                        <a class="category" href="products-3.html?category=pizza">Pizza</a>
                    </div>
                    <div class="wsus__menu_item_text">
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
            <div class="col-6 col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__menu_item">
                    <div class="wsus__menu_item_img">
                        <img src="/images/pesto-and-burrata-crostini.png"
                            alt="menu" class="img-fluid w-100">
                        <a class="category" href="products-3.html?category=pizza">Pizza</a>
                    </div>
                    <div class="wsus__menu_item_text">
                        <a class="title" href="product/pesto-and-burrata-crostini.html">Pesto and Burrata
                            Crostini</a>
                        <h5 class="price">$65 <del>$100</del> </h5>

                        <ul class="d-flex flex-wrap justify-content-center">
                            <li><a href="javascript:;" onclick="load_product_model(17)"><i
                                        class="fas fa-shopping-basket"></i></a></li>

                            <li><a href="javascript:;" onclick="before_auth_wishlist(17)"><i
                                        class="fal fa-heart"></i></a></li>

                            <li><a href="product/pesto-and-burrata-crostini.html"><i class="far fa-eye"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__menu_item">
                    <div class="wsus__menu_item_img">
                        <img src="/images/grilled-octopus-salad.png"
                            alt="menu" class="img-fluid w-100">
                        <a class="category" href="products-4.html?category=chicken">Chicken</a>
                    </div>
                    <div class="wsus__menu_item_text">
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
            <div class="col-6 col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__menu_item">
                    <div class="wsus__menu_item_img">
                        <img src="/images/firecracker-shrimp.png"
                            alt="menu" class="img-fluid w-100">
                        <a class="category" href="products-4.html?category=chicken">Chicken</a>
                    </div>
                    <div class="wsus__menu_item_text">
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
        </div>
        <div class="wsus__pagination mt_35">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="...">
                        <ul class="pagination">


                            <li class="page-item active"><a class="page-link " href="javascript::void()">1</a></li>
                            <li class="page-item"><a class="page-link" href="products-5.html?page=2">2</a></li>
                            <li class="page-item"><a class="page-link" href="products-6.html?page=3">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="products-5.html?page=2" aria-label="Next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>


                        </ul>
                    </nav>
                </div>
            </div>


        </div>
    </div>
</section>

<!--=============================
        SEARCH MENU END
    ==============================-->
@endsection
