@extends('layouts.main')
@section('content')
@section('title', 'Shopping Cart')
<!--=============================
            BREADCRUMB START
        ==============================-->
@include('partials.breadcrumb')
<!--=============================
        BREADCRUMB END
    ==============================-->

    <section class="wsus__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container cart-main-body">
            <div class="row">
                <div class="col-lg-8  mb-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__cart_list">
                        <div class="table-responsive">
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <th class="wsus__pro_img">Image</th>
                                        <th class="wsus__pro_name">details</th>
                                        <th class="wsus__pro_status">price</th>
                                        <th class="wsus__pro_select">quantity</th>
                                        <th class="wsus__pro_tk">total</th>
                                        <th class="wsus__pro_icon">
                                            <a class="clear_all" href="javascript:;">clear all</a>
                                        </th>
                                    </tr>
                                    @forelse ($carts as $cart)
                                        <tr class="main-cart-item" data-id="{{ $cart['id'] }}">
                                            <td class="wsus__pro_img">
                                                <img src="{{ $cart['product']->images }}" alt="product" class="img-fluid w-100" />
                                            </td>

                                            <td class="wsus__pro_name">
                                                <a href="{{ route('frontend.product.show', $cart['product']->slug) }}">
                                                    {{ $cart['product']->title }}
                                                </a>
                                                <span>{{ $cart['size'] }}</span>
                                            </td>

                                            <td class="wsus__pro_status">
                                                <h6>£{{ number_format($cart['price'], 2) }}</h6>
                                            </td>

                                            <td class="wsus__pro_select" data-item-price="{{ number_format($cart['price'], 2) }}" data-rowid="{{ $cart['id'] }}">
                                                <div class="quentity_btn">
                                                    <button class="btn btn-danger decrement_product" data-cart-id="{{ $cart['id'] }}">
                                                        <i class="fal fa-minus"></i>
                                                    </button>
                                                    <input class="quantity" type="text" readonly value="{{ $cart['quantity'] }}" />
                                                    <button class="btn btn-success increment_product" data-cart-id="{{ $cart['id'] }}">
                                                        <i class="fal fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>

                                            <td class="wsus__pro_tk">
                                                <h6 class="item-total">€{{ number_format($cart['total'], 2) }}</h6>
                                                <input type="hidden" class="product_total" value="{{ $cart['total'] }}" />
                                            </td>

                                            <td class="wsus__pro_icon">
                                                <a class="remove_item" href="{{ route('cart.destroy', $cart['id']) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $cart['id'] }}').submit();">
                                                    <i class="far fa-times"></i>
                                                </a>
                                                <form action="{{ route('cart.destroy', $cart['id']) }}" method="post" id="delete-form-{{ $cart['id'] }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Your cart is empty</td>
                                        </tr>
                                        @endforelse
 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__cart_list_footer_button">
                        <div class="grand_total">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-medium">Subtotal</h5>
                                <h5 class="mb-0 text-end sub-total-price" id="subtotal">£0</h5>
                            </div>
                            <p>Shipping options will be updated during checkout.</p>
                        </div>
                        <div class="btns-group d-flex  gap-3">
                            <a href="/product" class="btn btn-outline-secondary cart-shop border-secondary btn-md rounded-1 w-50">Continue Shopping</a>
                            <a href="{{ route('checkout') }}" type="submit" class="common_btn w-50">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Loading state functions
    function showLoading($input) {
        $input.prop('disabled', true);
        $input.closest('.quentity_btn').find('button').prop('disabled', true);
    }

    function hideLoading($input) {
        $input.prop('disabled', false);
        $input.closest('.quentity_btn').find('button').prop('disabled', false);
    }

    // Update item total display
    function updateItemTotal($row, quantity, price) {
        var total = quantity * price;
        $row.find('.item-total').text('$' + total.toFixed(2));
        $row.find('.product_total').val(total);
    }

    // Update grand total
    function updateGrandTotal() {
        var subtotal = calculate_total();
        $('#subtotal').text('$' + subtotal.toFixed(2));
        $('#grand-total').text('$' + subtotal.toFixed(2));
    }

    // Cart Minus Event Handler
    $('.decrement_product').on('click', function() {
        var $button = $(this);
        var $quantityContainer = $button.parent();
        var $input = $quantityContainer.find('.quantity');
        var $row = $button.closest('tr');
        var cartId = $button.data('cart-id');
        var currentVal = parseInt($input.val());
        var price = parseFloat($quantityContainer.parent().data('item-price'));

        // Prevent decrease if quantity is already 1
        if (currentVal <= 1) {
            toastr.warning('Minimum quantity is 1', 'Warning');
            return;
        }

        // Show loading state
        showLoading($input);

        $.ajax({
            url: '{{ route('cart.update') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: cartId,
                action: 'decrease'
            },
            success: function(response) {
                // Hide loading state
                hideLoading($input);

                if (response.success) {
                    // Update input value
                    $input.val(response.quantity);
                    
                    // Update item total
                    updateItemTotal($row, response.quantity, price);
                    
                    // Update grand total
                    updateGrandTotal();
                    
                    // Show success toast
                    toastr.success(response.message);
                } else {
                    // Show error toast
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                // Hide loading state
                hideLoading($input);

                // Parse error message
                var errorMessage = 'An unexpected error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                // Show error toast
                toastr.error(errorMessage, 'Error');

                // Log error for debugging
                console.error('Cart Decrease Error:', xhr.responseText);
            }
        });
    });

    // Cart Plus Event Handler
    $('.increment_product').on('click', function() {
        var $button = $(this);
        var $quantityContainer = $button.parent();
        var $input = $quantityContainer.find('.quantity');
        var $row = $button.closest('tr');
        var cartId = $button.data('cart-id');
        var price = parseFloat($quantityContainer.parent().data('item-price'));

        // Show loading state
        showLoading($input);

        $.ajax({
            url: '{{ route('cart.update') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: cartId,
                action: 'increase'
            },
            success: function(response) {
                // Hide loading state
                hideLoading($input);

                if (response.success) {
                    // Update input value
                    $input.val(response.quantity);
                    
                    // Update item total
                    updateItemTotal($row, response.quantity, price);
                    
                    // Update grand total
                    updateGrandTotal();
                    
                    // Show success toast
                    toastr.success(response.message);

                    // Optionally reload page if you prefer
                    // location.reload();
                } else {
                    // Show error toast
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                // Hide loading state
                hideLoading($input);

                // Parse error message
                var errorMessage = 'An unexpected error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                // Show error toast
                toastr.error(errorMessage, 'Error');

                // Log error for debugging
                console.error('Cart Increase Error:', xhr.responseText);
            }
        });
    });

    function calculate_total() {
        var total = 0;
        $('.product_total').each(function() {
            var val = parseFloat($(this).val());
            if (!isNaN(val)) {
                total += val;
            }
        });
        return total;
    }


    // Clear all cart items
    $('.clear_all').on('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to clear all items from your cart?')) {
            $.ajax({
                url: '{{ route('cart.clear') }}', 
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('Failed to clear cart', 'Error');
                }
            });
        }
    });

    // function calculate_total() {
    //     var total = 0;
    //     $('.product_total').each(function() {
    //         var val = parseFloat($(this).val());
    //         if (!isNaN(val)) {
    //             total += val;
    //         }
    //     });
    //     return total;
    // }

    

    // Initialize totals on page load
    $(document).ready(function() {
        updateGrandTotal();
    });
</script>
@endpush