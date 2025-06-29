@extends('layouts.main')
@section('content')
@section('title', 'Product Details')
<!--=============================
        BREADCRUMB START
    ==============================-->
@include('partials.breadcrumb')
<!--=============================
        BREADCRUMB END
    ==============================-->


<!--=============================
        MENU DETAILS START
    ==============================-->
<section class="wsus__menu_details mt_115 xs_mt_85 mb_95 xs_mb_65">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-9 wow fadeInUp" data-wow-duration="1s">
                <div class="exzoom hidden" id="exzoom">
                    <div class="exzoom_img_box wsus__menu_details_images">
                        <ul class='exzoom_img_ul'>
                            @foreach ($product->photos as $image)
                                <li>
                                    <img class="zoom img-fluid w-100"
                                         src="{{ asset('storage/upload/product/' . $image->image_path) }}"
                                         alt="product">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="exzoom_nav"></div>
                    <p class="exzoom_btn">
                        <a href="javascript:void(0);" class="exzoom_prev_btn">
                            <i class="far fa-chevron-left"></i>
                        </a>
                        <a href="javascript:void(0);" class="exzoom_next_btn">
                            <i class="far fa-chevron-right"></i>
                        </a>
                    </p>
                </div>
            </div>
            <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__menu_details_text">
                    <h2>{{ $product->title   }}</h2>
                    <h3 class="price">${{ $product->price }} <del>${{ $product->discount }}</del></h3>
                    <p class="short_description">
                        {!! \Str::limit($product->description, 200)  !!}
                    </p>

                    <form id="add_to_cart_form" action="" method="POST">
                        <input type="hidden" name="product_id" value="3">
                        <input type="hidden" name="price" value="0" id="price">
                        <input type="hidden" name="variant_price" value="0" id="variant_price">

                        <div class="details_quentity">
                            <h5>select quantity</h5>
                            <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                <div class="quentity_btn">
                                    <button type="button" class="btn btn-danger decrement_qty_detail_page"><i
                                            class="fal fa-minus"></i></button>
                                    <input type="text" value="1" name="qty" class="product_qty"
                                        readonly="">
                                    <button type="button" class="btn btn-success increment_qty_detail_page"><i
                                            class="fal fa-plus"></i></button>
                                </div>
                                <h3>$ <span class="grand_total">0.00</span></h3>
                            </div>
                        </div>
                        <ul class="details_button_area d-flex flex-wrap">
                            <li><a id="add_to_cart" class="common_btn" href="javascript:;">add to cart</a></li>
                            <li>
                                <a class="wishlist" href="{{ route('wishlist.add') }}" onclick="event.preventDefault(); document.getElementById('wish-{{ $product->id  }}').submit()" href="{{ route('wishlist.add') }}">
                                    <i class="fal fa-heart"></i>
                                </a>         
                                <form action="{{ route('wishlist.add') }}" id="wish-{{ $product->id  }}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </form>
                            </li>
                                        
                        </ul>

                    </form>
                </div>
            </div>
            <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__menu_description_area mt_100 xs_mt_70">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab"
                                aria-controls="pills-home" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <div class="menu_det_description">
                                {!! \Str::limit($product->description, 200)  !!}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab" tabindex="0">
                            <div class="wsus__review_area">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4>0 reviews</h4>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="wsus__post_review">
                                            <h4>write a Review</h4>
                                            <form id="review_form">
                                                <div class="row">
                                                    <input type="hidden" name="product_id" value="3">

                                                    <input type="hidden" name="rating" value="5"
                                                        id="product_rating">

                                                    <div class="col-xl-12">
                                                        <textarea name="review" rows="3" placeholder="Write your review"></textarea>
                                                    </div>


                                                    <div class="col-12">
                                                        <a href="../login.html" class="common_btn"
                                                            type="button">please login first</a>

                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wsus__related_menu mt_90 xs_mt_60">
            <h2>related item</h2>
            <div class="row related_product_slider">
                @foreach ($relatedProducts as $related)
                    <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__menu_item">
                            <div class="wsus__menu_item_img">
                                <img src="{{ asset('storage/upload/product/single/' . ($related->images ?? 'default.jpg')) }}"
                                    alt="{{ $related->title }}" class="img-fluid w-100">
                                <a class="category" href="{{ route('frontend.product.show', $related->slug) }}">
                                    {{ $related->category->title ?? '' }}
                                </a>
                            </div>
                            <div class="wsus__menu_item_text">
                                <a class="title" href="{{ route('frontend.product.show', $related->id) }}">{{ $related->title }}</a>
                                <h5 class="price">${{ $related->price }} <del>${{ $related->discount }}</del></h5>
                                <ul class="d-flex flex-wrap justify-content-center">
                                    <li>
                                        <a href="javascript:;" onclick="load_product_model({{ $related->id }})">
                                            <i class="fas fa-shopping-basket"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('wishlist.add') }}" onclick="event.preventDefault(); document.getElementById('wish-{{ $product->id  }}').submit()" href="{{ route('wishlist.add') }}">
                                            <i class="fal fa-heart"></i>
                                        </a>         
                                        <form action="{{ route('wishlist.add') }}" id="wish-{{ $product->id  }}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        </form>
                                    </li>
                                    <li>
                                        <a href="{{ route('frontend.product.show', $related->slug) }}">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
               
            </div>
        </div>
    </div>
</section>

<!--=============================
        MENU DETAILS END
    ==============================-->

<script>
    (function($) {
        "use strict";
        $(document).ready(function() {

            $("#review_form").on("submit", function(e) {
                e.preventDefault();

                var isDemo = "0"
                if (isDemo == 0) {
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }

                $.ajax({
                    type: 'post',
                    data: $('#review_form').serialize(),
                    url: "https://unifood.websolutionus.com/submit-review",
                    success: function(response) {
                        toastr.success("Review added successfully")
                        $("#review_form").trigger("reset");
                    },
                    error: function(response) {

                        if (response.status == 422) {
                            if (response.responseJSON.errors.rating) toastr.error(
                                response.responseJSON.errors.rating[0])
                            if (response.responseJSON.errors.review) toastr.error(
                                response.responseJSON.errors.review[0])
                            if (response.responseJSON.errors.product_id) toastr.error(
                                response.responseJSON.errors.product_id[0])

                            if (!response.responseJSON.errors.rating || !response
                                .responseJSON.errors.review || !response.responseJSON
                                .errors.product_id) {
                                toastr.error(
                                    "Please complete the recaptcha to submit the form"
                                    )
                            }
                        }

                        if (response.status == 500) {
                            toastr.error("Server error occured")
                        }

                        if (response.status == 403) {
                            toastr.error(response.responseJSON.message)
                        }
                    }
                });

            })

            $("#add_to_cart").on("click", function(e) {
                e.preventDefault();
                if ($("input[name='size_variant']").is(":checked")) {

                    $.ajax({
                        type: 'get',
                        data: $('#add_to_cart_form').serialize(),
                        url: "https://unifood.websolutionus.com/add-to-cart",
                        success: function(response) {
                            let html_response = `    <div>
                                    <div class="wsus__menu_cart_header">
                                        <h5 class="mini_cart_body_item">Total Item(0)</h5>
                                        <span class="close_cart"><i class="fal fa-times"></i></span>
                                    </div>
                                    <ul class="mini_cart_list">

                                    </ul>

                                    <p class="subtotal">Sub Total <span class="mini_sub_total">$0.00</span></p>
                                    <a class="cart_view" href="https://unifood.websolutionus.com/cart"> view cart</a>
                                    <a class="checkout" href="https://unifood.websolutionus.com/checkout">checkout</a>
                                </div>`;


                            $(".wsus__menu_cart_boody").html(html_response);

                            $(".mini_cart_list").html(response);
                            toastr.success("Item added successfully")
                            calculate_mini_total();
                        },
                        error: function(response) {
                            if (response.status == 500) {
                                toastr.error("Server error occured")
                            }

                            if (response.status == 403) {
                                toastr.error(response.responseJSON.message)
                            }
                        }
                    });

                } else {
                    toastr.error("Please select a size")
                }
            });

            $("input[name='size_variant']").on("change", function() {
                $("#variant_price").val($(this).data('variant-price'))
                calculatePrice()
            })

            $("input[name='optional_items[]']").change(function() {
                calculatePrice()
            });

            $(".increment_qty_detail_page").on("click", function() {
                let product_qty = $(".product_qty").val();
                let new_qty = parseInt(product_qty) + parseInt(1);
                $(".product_qty").val(new_qty);
                calculatePrice();
            })

            $(".decrement_qty_detail_page").on("click", function() {
                let product_qty = $(".product_qty").val();
                if (product_qty == 1) return;
                let new_qty = parseInt(product_qty) - parseInt(1);
                $(".product_qty").val(new_qty);
                calculatePrice();
            })

        });
    })(jQuery);

    function calculatePrice() {
        let optional_price = 0;
        let product_qty = $(".product_qty").val();
        $("input[name='optional_items[]']:checked").each(function() {
            let checked_value = $(this).data('optional-item');
            optional_price = parseInt(optional_price) + parseInt(checked_value);
        });

        let variant_price = $("#variant_price").val();
        let main_price = parseInt(variant_price) * parseInt(product_qty);

        let total = parseInt(main_price) + parseInt(optional_price);
        $(".grand_total").html(total)
        $("#price").val(total);
    }


</script>

@endsection
