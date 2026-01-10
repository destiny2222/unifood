@extends('layouts.main')
@section('content')
@section('title', 'Checkout')
<!--=============================
            BREADCRUMB START
        ==============================-->
@include('partials.breadcrumb')
<!--=============================
        BREADCRUMB END
    ==============================-->
<!--============================
        CHECK OUT PAGE START
    ==============================-->
<section class="wsus__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
    <div class="container">
        <form action="{{ route('stripe.checkout.process') }}" id="checkout_form" method="POST" autocomplete="off">
            @csrf
            <input type="text" name="delivery_fee" hidden value="{{ $deliveryFee }}">
            <div class="row">
                <div class="col-lg-8 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__checkout_form">
                        <div class="wsus__check_form">
                            <div class="row">
                                <div class="col-12">
                                    <div class="wsus__check_single_form">
                                        <label for="">Deliver to*</label>
                                        <input id="ship-address" name="ship-address" required autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="wsus__check_single_form">
                                        <label for="">Apartment, unit, suite, or floor #</label>
                                        <input type="text" id="address2" placeholder="Apartment, unit, suite, or floor #" name="address" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="wsus__check_single_form">
                                        <label for="">City <span class="text-danger">*</span></label>
                                        <input type="text" id="locality" placeholder="City *" name="city" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="wsus__check_single_form">
                                        <label for="">State/Province<span class="text-danger">*</span></label>
                                        <input type="text" id="state" placeholder="State *" name="state" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="wsus__check_single_form">
                                        <label for="">Postal code<span class="text-danger">*</span></label>
                                        <input type="text" id="postcode" placeholder="Postcode *" name="postal_code" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="wsus__check_single_form">
                                        <label for="">Country/Region<span class="text-danger">*</span></label>
                                        <input type="text" id="country" placeholder="Country *" name="country" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div id="sticky_sidebar" class="wsus__cart_list_footer_button">
                        <h6>Order Summary</h6>
                        
                        <!-- Cart Items List -->
                        <div class="checkout_cart_items mb-3">
                            @foreach($cartItems as $item)
                                <div class="checkout_item d-flex align-items-center mb-2 pb-2 border-bottom" data-item-id="{{ $item->id }}">
                                    <div class="checkout_item_img me-2" style="width: 60px; height: 60px;">
                                        <img src="{{ $item->product->images }}" alt="{{ $item->product->title }}" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="checkout_item_details flex-grow-1">
                                        <h6 class="mb-0" style="font-size: 14px;">{{ \Str::limit($item->product->title, 30) }}</h6>
                                        <small class="text-muted">Qty: {{ $item->quantity }} × £{{ number_format($item->price, 2) }}</small>
                                    </div>
                                    <div class="checkout_item_price me-2">
                                        <strong class="item-subtotal">£{{ number_format($item->price * $item->quantity, 2) }}</strong>
                                    </div>
                                    <div class="checkout_item_delete">
                                        <a href="javascript:void(0);" class="delete-checkout-item text-danger" data-item-id="{{ $item->id }}" data-price="{{ $item->price * $item->quantity }}">
                                            <i class="far fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price Breakdown -->
                        <p>subtotal: <span class="checkout-subtotal">£{{ number_format($subtotal, 2) }}</span></p>
                        <p>discount (-): <span>£0</span></p>
                        <p>delivery (+): <span class="delivery_charge">£{{ number_format($deliveryFee, 2) }}</span></p>
                        
                        <x-shipping-options :shipping-rates="$shippingRates" :subtotal="$subtotal" :delivery-fee="$deliveryFee" />
                        
                        <p class="total">
                            <span>Total:</span> <span class="grand_total">£{{ number_format($totalPrice, 2) }}</span>
                        </p>
                        <input type="hidden" name="total_price" id="total_price_input" value="{{ $totalPrice }}"/>
                        <a class="common_btn" href="javascript:;" onclick="checkAddressAndSubmit(event)">Continue to pay</a>
                        <script>
                            function checkAddressAndSubmit(e) {
                                e.preventDefault();
                                
                                // Check if cart is empty
                                if ($('.checkout_item').length === 0) {
                                    toastr.error('Your cart is empty. Please add items before checkout.');
                                    return;
                                }
                                
                                document.getElementById('checkout_form').submit();
                            }
                        </script>
                    </div>
                </div>
            </div>
        </form>    
    </div>
</section>
<!--============================
        CHECK OUT PAGE END
    ==============================-->

@endsection
@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARkCEFCZpUtHsK6w0gw-Bg7jk68ilhV6g&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
    <script>
        let autocomplete;
        let address1Field;
        let address2Field;
        let postalField;

        function initAutocomplete() {
            address1Field = document.querySelector("#ship-address");
            address2Field = document.querySelector("#address2");
            postalField = document.querySelector("#postcode");
            
            autocomplete = new google.maps.places.Autocomplete(address1Field, {
                fields: ["address_components", "geometry"],
                types: ["address"],
            });
            address1Field.focus();
            
            autocomplete.addListener("place_changed", fillInAddress);
        }

        function fillInAddress() {
            const place = autocomplete.getPlace();
            let address1 = "";
            let postcode = "";

            for (const component of place.address_components) {
                const componentType = component.types[0];

                switch (componentType) {
                    case "street_number": {
                        address1 = `${component.long_name} ${address1}`;
                        break;
                    }
                    case "route": {
                        address1 += component.short_name;
                        break;
                    }
                    case "postal_code": {
                        postcode = `${component.long_name}${postcode}`;
                        break;
                    }
                    case "postal_code_suffix": {
                        postcode = `${postcode}-${component.long_name}`;
                        break;
                    }
                    case "locality":
                        document.querySelector("#locality").value = component.long_name;
                        break;
                    case "administrative_area_level_1": {
                        document.querySelector("#state").value = component.short_name;
                        break;
                    }
                    case "country":
                        document.querySelector("#country").value = component.long_name;
                        break;
                }
            }

            address1Field.value = address1;
            postalField.value = postcode;
            address2Field.focus();
        }

        window.initAutocomplete = initAutocomplete;

        // Delete item from checkout
        $(document).ready(function() {
            $('.delete-checkout-item').on('click', function(e) {
                e.preventDefault();
                
                var itemId = $(this).data('item-id');
                var itemPrice = parseFloat($(this).data('price'));
                var $itemElement = $(this).closest('.checkout_item');
                
                if (confirm('Are you sure you want to remove this item?')) {
                    $.ajax({
                        url: '{{ url("cart") }}/' + itemId + '/destroy',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Remove item from DOM
                                $itemElement.fadeOut(300, function() {
                                    $(this).remove();
                                    
                                    // Update totals
                                    updateCheckoutTotals(itemPrice);
                                    
                                    // Dispatch custom event for Livewire components
                                    window.dispatchEvent(new CustomEvent('cart-updated'));
                                    
                                    // Alternative: Dispatch Livewire event if Livewire is available
                                    if (typeof Livewire !== 'undefined') {
                                        Livewire.dispatch('cartUpdated');
                                    }
                                    
                                    // Check if cart is empty
                                    if ($('.checkout_item').length === 0) {
                                        toastr.info('Your cart is empty. Redirecting...');
                                        setTimeout(function() {
                                            window.location.href = '{{ route("cart.index") }}';
                                        }, 1500);
                                    }
                                });
                                
                                toastr.success(response.message || 'Item removed from cart');
                            } else {
                                toastr.error(response.message || 'Failed to remove item');
                            }
                        },
                        error: function(xhr) {
                            var message = 'Failed to remove item';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            toastr.error(message, 'Error');
                        }
                    });
                }
            });
            
            function updateCheckoutTotals(removedPrice) {
                // Get current subtotal
                var currentSubtotal = parseFloat($('.checkout-subtotal').text().replace('£', '').replace(',', ''));
                var newSubtotal = currentSubtotal - removedPrice;
                
                // Update subtotal
                $('.checkout-subtotal').text('£' + newSubtotal.toFixed(2));
                
                // Get delivery fee
                var deliveryFee = parseFloat($('.delivery_charge').text().replace('£', '').replace(',', ''));
                
                // Calculate new total
                var newTotal = newSubtotal + deliveryFee;
                
                // Update grand total
                $('.grand_total').text('£' + newTotal.toFixed(2));
                $('#total_price_input').val(newTotal.toFixed(2));
            }
        });
    </script>
@endpush