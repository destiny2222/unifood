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
                <div class="col-lg-8 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__cart_list">
                        <div class="table-responsive">
                            <table>
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
                                        <tr class="main-cart-item" data-id="{{ $cart->id }}">
                                            <td class="wsus__pro_img">
                                                <img src="{{ $cart->product->images }}" alt="product" class="img-fluid w-100" />
                                            </td>

                                            <td class="wsus__pro_name">
                                                <a href=" ">{{ $cart->product->title }}</a>
                                            </td>

                                            <td class="wsus__pro_status">
                                                <h6>${{ number_format($cart->product->price, 2) }}</h6>
                                            </td>

                                            <td class="wsus__pro_select" data-item-price="{{ $cart->product->price }}" data-optional-price="0" data-rowid="{{ $cart->id }}">
                                                <div class="quentity_btn">
                                                    <button class="btn btn-danger decrement_product" data-cart-id="{{ $cart->id }}">
                                                        <i class="fal fa-minus"></i>
                                                    </button>
                                                    <input class="quantity" type="text" readonly value="{{ $cart->quantity }}" />
                                                    <button class="btn btn-success increment_product" data-cart-id="{{ $cart->id }}">
                                                        <i class="fal fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>

                                            <td class="wsus__pro_tk">
                                                <h6 class="item-total">${{ number_format($cart->quantity * $cart->product->price, 2) }}</h6>
                                                <input type="hidden" class="product_total" value="{{ $cart->quantity * $cart->product->price }}" />
                                            </td>

                                            <td class="wsus__pro_icon">
                                                <a  class="remove_item" href="{{ route('cart.destroy', $cart->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $cart->id }}').submit();"><i class="far fa-times"></i></a>
                                                <form action="{{ route('cart.destroy', $cart->id) }}"  method="post" id="delete-form-{{ $cart->id }}">
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
{{-- 
                <input type="hidden" id="couon_price" value="0.00" />
                <input type="hidden" id="couon_offer_type" value="0" /> --}}

                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__cart_list_footer_button">
                        <div class="grand_total">
                            <h6>total price</h6>
                            <p>subtotal: <span id="subtotal">$120</span></p>
                            <p>discount (-): <span id="discount">$0</span></p>
                            <p>delivery (+): <span id="delivery">$0.00</span></p>
                            <p class="total"><span>Total:</span> <span id="grand-total">$120</span></p>
                        </div>
                        {{-- <form id="coupon_form">
                            <input name="coupon" type="text" placeholder="Coupon Code" />
                            <button type="submit">apply</button>
                        </form> --}}
                        <a class="common_btn" href="{{ route('checkout') }}">checkout</a>
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
                id: cartId,
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
                id: cartId,
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

    

    // Initialize totals on page load
    $(document).ready(function() {
        updateGrandTotal();
    });
</script>
@endpush