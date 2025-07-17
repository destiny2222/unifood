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
        <form class="wsus__search_menu_form" action="{{ route('frontend.product.search') }}" method="GET">
            <div class="row">
                <div class="col-xl-6 col-md-5">
                      <input type="text" placeholder="Type your keyword" name="search" value="{{ request('search') }}">
                </div>
                <div class="col-xl-4 col-md-4">
                    <select id="select_js2" name="category">
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->title }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-2 col-md-3">
                    <button type="submit" class="common_btn">search</button>
                </div>
            </div>
        </form>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-6 col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__menu_item">
                            <div class="wsus__menu_item_img">
                                <img src="{{ $product->images  }}"  alt="menu" class="img-fluid w-100">
                                <a class="category" href="{{ route('frontend.product.show', $product->slug) }}">{{ $product->category->title }}</a>
                            </div>
                            <div class="wsus__menu_item_text">
                                <a class="title" href="{{ route('frontend.product.show', $product->slug) }}">{{ $product->title }}</a>
                                <h5 class="price">${{ $product->price ?? 0 }} @if($product->discount)<del>${{ $product->discount }}</del>@endif </h5>
                                <ul class="d-flex flex-wrap justify-content-center">
                                    <li><a href="{{ route('cart.add') }}" onclick="event.preventDefault(); document.getElementById('cart-{{ $product->id  }}').submit()"><i class="fas fa-shopping-basket"></i></a></li>
                                    <form action="{{ route('cart.add') }}" method="post" id="cart-{{ $product->id  }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="slug" value="{{ $product->slug }}">
                                        <input type="hidden" name="quantity" value="1">
                                    </form>
                                    <li><a href="javascript:;" href="{{ route('wishlist.add') }}" onclick="event.preventDefault(); document.getElementById('wish-{{ $product->id  }}').submit()"><i class="fal fa-heart"></i></a></li>
                                    <form action="{{ route('wishlist.add') }}" id="wish-{{ $product->id  }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    </form>
                                    <li><a href="{{ route('frontend.product.show', $product->slug) }}"><i class="far fa-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
            @endforeach
            
        </div>
        <div class="wsus__pagination mt_35">
            <div class="row">
                <div class="col-12">
                    @if ($products->hasPages())
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($products->links()->elements[0] as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li class="page-item active"><a class="page-link">{{ $page }}</a></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next" aria-label="Next"><i class="fas fa-chevron-right"></i></a>
                                    </li>
                                @else
                                    <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>


        </div>
    </div>
</section>

<!--=============================
        SEARCH MENU END
    ==============================-->
@endsection
