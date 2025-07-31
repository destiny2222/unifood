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
                            {{-- Show the main product image first --}}
                            @if ($product->images)
                                <li>
                                    <img class="zoom img-fluid w-100"
                                        src="{{ $product->images }}"
                                        alt="Main product image">
                                </li>
                            @endif
                            {{-- Loop through additional photos --}}
                            @foreach ($product->photos as $image)
                                <li>
                                    <img class="zoom img-fluid w-100"
                                        src="{{ $image->image_path }}"
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
                    <h2>{{ $product->title }}</h2>
                    @if ($product->has_variants === 1)
                        <h3 class="price ">
                            £ {{ number_format($product->variants->first()->price ?? 0, 2) }}
                            @if ($product->discount)
                            <del>£{{ $product->discount }}</del> 
                            @endif
                        </h3>
                    @else
                        <h3 class="price ">
                            £ {{ number_format($product->price ?? 0, 2) }} / {{ $product->unit }}
                            @if ($product->discount)
                            <del>£{{ $product->discount }}</del> 
                            @endif
                        </h3>
                    @endif

                    <p class='mt-3 mb-3'><span style="color:#E6005C;font-weight:bolder;">Weight:</span> {{ $product->weight }}</p>
                   
                    <p class="short_description">
                        {!! \Str::limit($product->description, 200) !!}
                    </p>

                    
                    
                    <form id="add_to_cart_form"  method="POST" class="py-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" id="selected_price" name="price" value="{{ $product->has_variants === 1 ? ($product->variants->first()->price ?? 0) : $product->price }}">
                        <input type="hidden" id="selected_size" name="size_variant" value="{{ $product->has_variants === 1 ? '' : 'default' }}">
                        <input type="hidden" id="has_variants" value="{{ $product->has_variants }}">

                        @if($product->has_variants === 1 && $product->variants && $product->variants->count() > 0)
                        <div class="details_size">
                            <h5>select size</h5>
                            @foreach($product->variants as $index => $variant)
                            <div class="form-check">
                                <input name="size_variant" class="form-check-input" type="radio" id="size-{{ $index }}" value="{{ $variant->size }}"
                                    data-price="{{ $variant->price }}"
                                    data-size="{{ $variant->size }}"
                                    {{ $index === 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="size-{{ $index }}">
                                    {{ $variant->size }} - {{ $variant->weight }} {{ $variant->unit }} - £{{ $variant->price }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        
                        <div class="details_quentity">
                            <h5>select quantity</h5>
                            <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                <div class="quentity_btn">
                                    <button type="button" class="btn btn-danger decrement_qty_detail_page"><i
                                            class="fal fa-minus"></i></button>
                                    <input type="text" value="1" name="quantity" class="product_qty"
                                        readonly="">
                                    <button type="button" class="btn btn-success increment_qty_detail_page"><i
                                            class="fal fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <ul class="details_button_area d-flex flex-wrap">
                            <li class="me-2">
                                <button type="submit" id="add_to_cart" class="common_btn"  href="javascript:;">add to cart</button>
                            </li>
                            <li>
                                <a class="wishlist" href="{{ route('wishlist.add') }}"
                                   onclick="event.preventDefault(); document.getElementById('wish-{{ $product->id }}').submit()" href="{{ route('wishlist.add') }}">
                                    <i class="fal fa-heart"></i>
                                </a>
                                <form action="{{ route('wishlist.add') }}" id="wish-{{ $product->id }}"
                                    method="post">
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
                                {!! \Str::limit($product->description, 200) !!}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab" tabindex="0">
                            <div class="wsus__review_area">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4>{{ $product->reviews->where('status', 1)->count() }} reviews</h4>
                                        @foreach ($product->reviews as $review)
                                            @if ($review->status == 1)
                                                <div class="wsus__comment pt-0 mt_20">
                                                    <div class="wsus__single_comment m-0 border-0">
                                                        <img src="{{ asset('images/profile/' . $review->user->profile_picture) }}"
                                                            alt="review" class="img-fluid">
                                                        <div class="wsus__single_comm_text">
                                                            <h3>{{ $review->user->name }}
                                                                <span>{{ $review->created_at->format('d M Y') }}
                                                                </span></h3>
                                                            <p>{{ $review->review }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="wsus__post_review">
                                            <h4>write a Review</h4>
                                            <form id="review_form" action="{{ route('review.store') }}"
                                                method="POST">
                                                @csrf
                                                <div class="row">
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $product->id }}">

                                                    <div class="col-xl-12">
                                                        <textarea name="review" rows="3" placeholder="Write your review"></textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="common_btn">Submit</button>
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
                                <img src="{{ $related->images }}"
                                    alt="{{ $related->title }}" class="img-fluid w-100">
                                <a class="category" href="{{ route('frontend.product.show', $related->slug) }}">
                                    {{ $related->category->title ?? '' }}
                                </a>
                            </div>
                            <div class="wsus__menu_item_text">
                                <a class="title"
                                    href="{{ route('frontend.product.show', $related->slug) }}">{{ $related->title }}</a>
                                <h5 class="price">
                                    @if ($related->has_variants === 1)
                                        £{{ optional($related->variants->first())->price ?? '0.00' }}
                                        <del>
                                            @if ($related->discount)
                                                £{{ $related->discount }}
                                            @endif
                                        </del>
                                    @else
                                        £{{ $related->price ?? '0.00' }}
                                        <del>
                                            @if ($related->discount)
                                                £{{ $related->discount }}
                                            @endif
                                        </del>
                                    @endif
                                </h5>
                                <ul class="d-flex flex-wrap justify-content-center">
                                    <li>
                                        <a href="javascript:;" onclick="event.preventDefault(); load_product_model({{ json_encode($related->slug) }})">
                                            <i class="fas fa-shopping-basket"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('wishlist.add') }}"
                                            onclick="event.preventDefault(); document.getElementById('wish-{{ $product->id }}').submit()"
                                            href="{{ route('wishlist.add') }}">
                                            <i class="fal fa-heart"></i>
                                        </a>
                                        <form action="{{ route('wishlist.add') }}" id="wish-{{ $product->id }}"
                                            method="post">
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



@endsection
@push('scripts')
{{-- <script>
    (function($) {
        "use strict";
        $(document).ready(function() {
            
            // Initialize the first variant as selected if product has variants
            const hasVariants = parseInt($('#has_variants').val());
            if (hasVariants === 1) {
                const firstVariant = $('input[name="size_variant"]:first');
                if (firstVariant.length > 0) {
                    firstVariant.prop('checked', true);
                    const size = firstVariant.data('size');
                    const price = firstVariant.data('price');
                    $('#selected_size').val(size);
                    $('#selected_price').val(price);
                    $('.variant-price').text(`£${parseFloat(price).toFixed(2)}`);
                }
            }

            // Handle size variant selection
            $('input[name="size_variant"]').on('click', function () {
                const size = $(this).data('size');
                const price = $(this).data('price');

                $('#selected_size').val(size);
                $('#selected_price').val(price);

                $('.variant-price').text(`£${parseFloat(price).toFixed(2)}`);
            });

            // Handle add to cart
            $("#add_to_cart").on("click", function(e) {
                e.preventDefault();

                const button = $(this);
                button.prop('disabled', true).text('Adding...');

                const hasVariants = parseInt($('#has_variants').val());

                // Check if product has variants
                if (hasVariants === 1) {
                    // Product has variants - check if one is selected
                    if (!$("input[name='size_variant']:checked").val()) {
                        toastr.error('Please select a size before adding to cart.');
                        button.prop('disabled', false).text('Add To Cart');
                        return;
                    }
                    
                    // Get the selected variant data
                    const selectedVariant = $("input[name='size_variant']:checked");
                    const selectedSize = selectedVariant.data('size');
                    const selectedPrice = selectedVariant.data('price');
                    
                    // Update hidden fields with selected values
                    $('#selected_size').val(selectedSize);
                    $('#selected_price').val(selectedPrice);
                    
                } else {
                   $('#selected_price').val({{ $product->price }});
                }

                const form = $('#add_to_cart_form');

                // Validate that we have the required data
                const finalSize = $('#selected_size').val();
                const finalPrice = $('#selected_price').val();
                
                if (!finalPrice || finalPrice === '0') {
                    toastr.error("Product price is not available.");
                    button.prop('disabled', false).text('Add To Cart');
                    return;
                }


                $.ajax({
                    type: 'POST',
                    url: "{{ route('cart.add') }}",
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            Livewire.dispatch('cartUpdated');
                            if (response.cart_count !== undefined) {
                                $('#cart-count').text(response.cart_count).addClass('animate__animated animate__pulse');
                                $('#cart-counts').text(response.cart_count);
                                setTimeout(() => {
                                    $('#cart-count').removeClass('animate__animated animate__pulse');
                                }, 1000);
                            }
                            updateMiniCart();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                        let errorMessage = "Something went wrong. Try again.";
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        button.prop('disabled', false).text('Add To Cart');
                    }
                });
            });

            $(".increment_qty_detail_page").on("click", function() {
                let product_qty = $(".product_qty").val();
                let new_qty = parseInt(product_qty) + 1;
                $(".product_qty").val(new_qty);
                updateQtyButtons();
            })

            $(".decrement_qty_detail_page").on("click", function() {
                let product_qty = $(".product_qty").val();
                if (product_qty == 1) return;
                let new_qty = parseInt(product_qty) - 1;
                $(".product_qty").val(new_qty);
                updateQtyButtons();
            })

            function updateQtyButtons() {
                let qty = parseInt($(".product_qty").val());
                $(".decrement_qty_detail_page").prop('disabled', qty <= 1);
            }

            updateQtyButtons(); // call on page load

        });

    })(jQuery);
</script> --}}
<script>
    function load_product_model(product_slug){

        $("#preloader").addClass('preloader')
        $(".img").removeClass('d-none')

        $.ajax({
            type: 'get',
            url: "{{ url('product') }}/" + product_slug,
            success: function (response) {
                $("#preloader").removeClass('preloader')
                $(".img").addClass('d-none')
                $(".load_product_modal_response").html(response)
                $("#cartModal").modal('show');
            },
            error: function(response) {
                toastr.error("Server error occured")
                // reload the web page
                window.location.reload();
                $(".img").addClass('d-none')
                
            }
        });
    }
</script>
<script>
function updateMiniCart() {
    $.ajax({
        url: '/cart/mini',
        type: 'GET',
        success: function (response) {
            $('.wsus__menu_cart_area').html(response.html);
        }
    });
}
</script>
@endpush