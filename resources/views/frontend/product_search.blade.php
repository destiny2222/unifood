@extends('layouts.main')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('user/css/product.css') }}">
    @endpush
@section('title', 'Product')
<!--=============================
            BREADCRUMB START
        ==============================-->
@include('partials.breadcrumb')
<!--=============================
        BREADCRUMB END
    ==============================-->



<!--shop grid section start-->
<section class="gshop-gshop-grid mt_120 xs_mt_90 mb_100 xs_mb_70">
    <div class="container">
        <div class="row g-4">

            <div class="col-xl-3 order-xl-1 order-lg-1 order-md-1 order-sm-2 order-2">
                <div class="" id="desktop_version">
                    <div class="gshop-sidebar bg-white rounded-2 overflow-hidden">
                        <!--Filter by search-->
                        <div class="sidebar-widget search-widget bg-white py-5 px-4">
                            <div class="widget-title d-flex">
                                <h6 class="mb-0 flex-shrink-0">Search Now</h6>
                                <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
                            </div>
                            <form class="search-form d-flex align-items-center mt-4"  action="{{ route('search') }}" method="GET">
                                <input type="text" id="search" name="search" placeholder="Search">
                                <button type="submit" class="submit-icon-btn-secondary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <!--Filter by search-->
                        <!--Filter by Categories-->
                        <div class="sidebar-widget category-widget bg-white py-5 px-4 border-top mobile-menu-wrapper scrollbar h-400px">
                            <div class="widget-title d-flex">
                                <h6 class="mb-0 flex-shrink-0">Categories</h6>
                                <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
                            </div>
                            <ul class="widget-nav mt-4">
                                {{-- All Categories option --}}
                                <li>
                                    <a href="{{ route('frontend.product') }}" 
                                    class="d-flex justify-content-between align-items-center {{ !request()->has('category') ? 'active' : '' }}">
                                        All Categories
                                        <span class="fw-bold fs-xs total-count">{{ $categories->sum('product_count') }}</span>
                                    </a>
                                </li>
                                
                                @forelse ($categories as $category)
                                    <li>
                                        <a href="{{ route('products.by.category', $category->slug) }}" 
                                        class="d-flex justify-content-between align-items-center {{ request()->get('category') == $category->slug ? 'active' : '' }}">
                                            {{ $category->title }}
                                            <span class="fw-bold fs-xs total-count">{{ $category->product_count }}</span>
                                        </a>
                                    </li>
                                @empty
                                    <li>
                                        <span class="text-muted">No categories available</span>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                        <!--Filter by Categories-->

                        <!--Filter by Price-->
                        {{-- <div class="sidebar-widget price-filter-widget bg-white py-5 px-4 border-top">
                                <div class="widget-title d-flex">
                                    <h6 class="mb-0 flex-shrink-0">Filter by Price</h6>
                                    <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
                                </div>
                                <div class="at-pricing-range mt-4">
                                    
                                        <div class="price-filter-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                            <div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
                                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span>
                                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="right: 0%;"></span>
                                        </div>
                                        <div class="d-flex align-items-center mt-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='0');" class="min_price price-range-field price-input price-input-min" name="min_price" data-value="0" data-min-range="0">
                                            <span class="d-inline-block ms-2 me-2 fw-bold">-</span>

                                            <input type="number" max="3000" oninput="validity.valid||(value='3000');" class="max_price price-range-field price-input price-input-max" name="max_price" data-value="3000" data-max-range="3000">

                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm mt-3">Filter</button>
                                    
                                </div>
                            </div> --}}
                        <!--Filter by Price-->
                    </div>
                </div>
            </div>

            <!--rightbar-->
            <div class="col-xl-9 order-xl-2 order-lg-2 order-md-2 order-sm-1 order-1">
                <div class="shop-grid">
                    <!--products-->
                    <div class="row g-4">
                        @forelse ($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-10 mb-5">
                                <div class="vertical-product-card rounded-2 position-relative swiper-slide bg-white">
                                    <div class="thumbnail position-relative text-center p-4">
                                        <img src="{{ $product->images }}" alt="Badhakopi (Cabbage)" class="img-fluid">
                                        <div class="product-btns position-absolute d-flex gap-2 flex-column">
                                            <a href="{{ route('wishlist.add') }}"
                                                onclick="event.preventDefault(); document.getElementById('wish-{{ $product->id }}').submit()"
                                                class="rounded-btn">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                            <form action="{{ route('wishlist.add') }}" id="wish-{{ $product->id }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            </form>
                                            <a href="{{ route('frontend.product.show', $product->slug) }}"
                                                class="rounded-btn">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <!--product category start-->
                                        <div class="mb-2 tt-category tt-line-clamp tt-clamp-1">
                                            <a href="{{ route('frontend.product.show', $product->slug) }}"
                                                class="d-inline-block text-muted fs-xxs">
                                                {{ $product->category->title ?? 'Uncategorized' }}
                                            </a>
                                        </div>
                                        <!--product category end-->

                                        <a href="{{ route('frontend.product.show', $product->slug) }}"
                                            class="card-title fw-semibold mb-2 tt-line-clamp tt-clamp-1">
                                            {{ $product->title }}
                                        </a>

                                        <h6 class="price">
                                            <span class="fw-bold h4 text-success">£{{ $product->price ?? 0 }}
                                                @if ($product->discount)
                                                    <del>£{{ $product->discount }}</del>
                                                @endif
                                            </span>
                                            <small>/{{ $product->weight_unit ?? 'pcs' }}</small>
                                        </h6>
                                        <form class="cartForm">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit"
                                                class="btn btn_outline_secondary btn-md border-secondary d-block mt-4 w-100 direct-add-to-cart-btn add-to-cart-text">
                                                Add to Cart
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <p>No products found.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="d-sm-block d-lg-flex align-items-center justify-content-between mt-7 tt-custom-pagination">
                        <span>
                            Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} results
                        </span>
                        
                        @if ($products->hasPages())
                            <nav>
                                <ul class="pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($products->onFirstPage())
                                        <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                                            <span class="page-link" aria-hidden="true">‹</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev" aria-label="« Previous">‹</a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        @if ($page == $products->currentPage())
                                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($products->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next" aria-label="Next »">›</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled" aria-disabled="true" aria-label="Next »">
                                            <span class="page-link" aria-hidden="true">›</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
            <!--rightbar-->

        </div>
    </div>
</section>
<!--shop grid section end-->
@endsection
@push('scripts')
<script>
    (function($) {
        "use strict";
        $(document).ready(function() {
            $('.cartForm').submit(function(e) {
                e.preventDefault();
                const form = $(this);
                const button = form.find('button[type="submit"]');

                // Disable button during request to prevent double-clicks
                button.prop('disabled', true).text('Adding...');

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

                            // Update cart count badge
                            if (response.cart_count !== undefined) {
                                $('#cart-count').text(response.cart_count);

                                // Optional: Add a little animation to draw attention
                                $('#cart-count').addClass(
                                    'animate__animated animate__pulse');
                                setTimeout(function() {
                                    $('#cart-count').removeClass(
                                        'animate__animated animate__pulse');
                                }, 1000);
                            }
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error(
                            "An error occurred while processing your request. Please try again."
                            );
                        console.log(xhr.responseText); // For debugging
                    },
                    complete: function() {
                        // Re-enable button
                        button.prop('disabled', false).text('Add To Cart');
                    }
                });
            });
        });
    })(jQuery);
</script>
@endpush
