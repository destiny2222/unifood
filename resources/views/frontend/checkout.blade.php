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
        <form  action="{{ route('stripe.checkout.process') }}" id="checkout_form"   method="POST" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-8 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__checkout_form">
                        <div class="wsus__check_form">
                            <div class="row">
                                <div class="col-12">
                                    <div class="wsus__check_single_form">
                                        <label for="">Deliver to*</label>
                                        <input  id="ship-address" name="ship-address" required autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="wsus__check_single_form">
                                        <label for="">Apartment, unit, suite, or floor #</label>
                                        <input type="text" id="address2" placeholder="Apartment, unit, suite, or floor #" name="address" />
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
                                {{-- <div class="col-12 mb-3">
                                    <div class="form-check align-items-center">
                                        <input type="checkbox" class="form-check-input" style="padding: 5px;" id="setDefault" name="is_default" value="1">
                                        <label class="form-check-label" for="setDefault">Set as default address</label>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div id="sticky_sidebar" class="wsus__cart_list_footer_button">
                        <h6>Order Summery</h6>
                        <p>subtotal: <span>£{{ number_format($totalPrice, 2) }}</span></p>
                        <p>discount (-): <span>£0</span></p>
                        <p>delivery (+): <span class="delivery_charge">£0.00</span></p>
                        <p class="total">
                            <span>Total:</span> <span class="grand_total">£{{ number_format($totalPrice, 2) }}</span>
                        </p>
                        <input type="hidden" name="total_price" id="total_price_input" value="{{ $totalPrice }}"/>
                        
                        <a class="common_btn" href="javascript:;" onclick="checkAddressAndSubmit(event)">Continue to pay</a>
                        <script>
                            function checkAddressAndSubmit(e) {
                                e.preventDefault();
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
    <script>
        (function($) {
            "use strict";
            $(document).ready(function () {

                $("input[name='address_id']").on("change", function() {
                    // var delivery_id = $("input[name='address_id']:checked").val();
                    // var deliveryCharge = $("input[name='address_id']:checked").data('delivery-charge');
                    var subtotal = {{ $totalPrice }};
                    

                    // Update delivery charge display
                    // $(".delivery_charge").html(`$${deliveryCharge}`);
                    
                    // Calculate grand total
                    // var grand_total = parseFloat(subtotal) + parseFloat(deliveryCharge);
                    
                    // Update grand total display
                    $(".grand_total").html(`$${grand_total.toFixed(2)}`);
                    
                    // Update the visible total price input
                    $("#total_price_input").val(grand_total.toFixed(2));
                    
                    // Update the hidden form input
                    $("#grand_total").val(grand_total.toFixed(2));
                    
                    // Update shipping address ID
                    // $('.shippingAddress_id').val(delivery_id);
                });

               

            });
        })(jQuery);
    </script>
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
        // Create the autocomplete object, restricting the search predictions to
        // addresses in the US and Canada.
        autocomplete = new google.maps.places.Autocomplete(address1Field, {
            // componentRestrictions: { country: ["us", "ca"] },
            fields: ["address_components", "geometry"],
            types: ["address"],
        });
        address1Field.focus();
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener("place_changed", fillInAddress);
        }

        function fillInAddress() {
        // Get the place details from the autocomplete object.
        const place = autocomplete.getPlace();
        let address1 = "";
        let postcode = "";

  
        for (const component of place.address_components) {
            // @ts-ignore remove once typings fixed
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
        // After filling the form with address components from the Autocomplete
        // prediction, set cursor focus on the second address line to encourage
        // entry of subpremise information such as apartment, unit, or floor number.
        address2Field.focus();
        }

        window.initAutocomplete = initAutocomplete;

    </script>
@endpush