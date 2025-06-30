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
        <div class="row">
            <div class="col-lg-8 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__checkout_form">
                    <div class="wsus__check_form">
                        <h5>
                            select address
                            <a href="#" data-bs-toggle="modal" data-bs-target="#address_modal"><i class="far fa-plus"></i> New Address</a>
                        </h5>

                        <div class="wsus__address_modal">
                            <div class="modal fade" id="address_modal" data-bs-backdrop="static"
                                data-bs-keyboard="false" aria-labelledby="address_modalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="address_modalLabel">
                                                add new address
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('shipping.address.store') }}"  method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="wsus__check_single_form">
                                                            <select name="delivery_area_id" class="modal_select2" required>
                                                                <option value="">   Select Delivery Area </option>
                                                                @foreach ($deliveryArea as $delivery)
                                                                 <option value="{{ $delivery->id }}"> {{ $delivery->delivery_area_name }}  </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input type="text" placeholder="First Name*" name="first_name" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input type="text" placeholder="Last Name *"    name="last_name" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input type="text" placeholder="Phone" name="phone_number" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input type="email" placeholder="Email" name="email" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                                        <div class="wsus__check_single_form">
                                                            <textarea name="address" cols="3" rows="4" placeholder="Address *"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="wsus__check_single_form check_area">
                                                            <div class="form-check">
                                                                <input value="home" class="form-check-input"  type="radio" name="address_type" id="flexRadioDefault1" />
                                                                <label class="form-check-label" for="flexRadioDefault1">  home </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input value="office" class="form-check-input" type="radio" name="address_type" id="flexRadioDefault2" />
                                                                <label class="form-check-label" for="flexRadioDefault2"> office </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="wsus__check_single_form m-0">
                                                            <button type="submit" class="common_btn">
                                                                Save Address
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @forelse ($shippingAddresses as $shipping)
                                <div class="col-md-6">
                                    <div class="wsus__checkout_single_address">
                                        <div class="form-check">
                                            <input value="{{ $shipping->id }}"  data-delivery-charge="{{ $shipping->deliveryArea->delivery_fee }}"   class="form-check-input address_id" type="radio" name="address_id"   id="home-{{ $shipping->id }}" />
                                            <label class="form-check-label" for="home-{{ $shipping->id }}">
                                                @if ($shipping->address_type == 'Home')
                                                    <span class="icon"><i class="fas fa-home"></i>{{ $shipping->address_type }}</span>
                                                @else
                                                    <span class="icon"><i class="far fa-car-building"></i>{{ $shipping->address_type }}</span>
                                                @endif
                                                <span class="address">Name : {{ $shipping->first_name }}  {{ $shipping->last_name }}</span>
                                                <span class="address">Phone : {{ $shipping->phone_number }}</span>
                                                <span class="address">Delivery area : {{ $shipping->deliveryArea->delivery_area_name }}</span>
                                                <span class="address">Address : {{ $shipping->address }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-6">
                                    <div class="wsus__checkout_single_address">
                                        <div class="form-check">
                                            <p>Add Shipping Address </p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div id="sticky_sidebar" class="wsus__cart_list_footer_button">
                    <h6>total price</h6>
                    <p>subtotal: <span>${{ $totalPrice }}</span></p>
                    <p>discount (-): <span>$0</span></p>
                    <p>delivery (+): <span class="delivery_charge">$0.00</span></p>
                    <p class="total">
                        <span>Total:</span> <span class="grand_total">${{ $totalPrice }}</span>
                    </p>
                   
                    <form action="{{ route('stripe.checkout.process') }}" id="checkout_form" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="total_price" id="total_price_input" value="{{ $totalPrice }}"/>
                        <input type="hidden" class="shippingAddress_id" name="shipping_addresses_id">
                    </form>
                    <a class="common_btn" href="javascript:;" onclick="checkAddressAndSubmit(event)">Continue to pay</a>
                    <script>
                        function checkAddressAndSubmit(e) {
                            e.preventDefault();
                            if ($("input[name='address_id']").is(":checked")) {
                                document.getElementById('checkout_form').submit();
                            } else {
                                toastr.error("Please select an address");
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
        CHECK OUT PAGE END
    ==============================-->

@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function () {

                $("input[name='address_id']").on("change", function() {
                    var delivery_id = $("input[name='address_id']:checked").val();
                    var deliveryCharge = $("input[name='address_id']:checked").data('delivery-charge');
                    var subtotal = {{ $totalPrice }};

                    // Update delivery charge display
                    $(".delivery_charge").html(`$${deliveryCharge}`);
                    
                    // Calculate grand total
                    var grand_total = parseFloat(subtotal) + parseFloat(deliveryCharge);
                    
                    // Update grand total display
                    $(".grand_total").html(`$${grand_total.toFixed(2)}`);
                    
                    // Update the visible total price input
                    $("#total_price_input").val(grand_total.toFixed(2));
                    
                    // Update the hidden form input
                    $("#grand_total").val(grand_total.toFixed(2));
                    
                    // Update shipping address ID
                    $('.shippingAddress_id').val(delivery_id);
                });

                $("#continue_to_pay").on("click", function(e){
                    e.preventDefault();
                    if ($("input[name='address_id']").is(":checked")) {
                        window.location.href = "https://unifood.websolutionus.com/payment";
                    } else {
                        toastr.error("Please select an address")
                    }
                });

            });
        })(jQuery);
    </script>
@endpush