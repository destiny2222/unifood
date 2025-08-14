@props(['shippingRates', 'subtotal', 'deliveryFee'])

<div class="wsus__cart_list_footer_button_text">
    <input type="hidden" name="shipping_rate_id" required id="shipping_rate_id" value="">
    <input type="hidden" name="shipping_delivery_type" required id="shipping_delivery_type" value="">
    <p class="pt-3">Shipping</p>
    @if($shippingRates->count() > 0)
        @foreach ($shippingRates as $rate)
            <div class="card shipping-option" data-rate-id="{{ $rate->id }}">
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input" required hidden type="radio" name="shipping_rate" id="shipping_rate_{{ $rate->id }}" value="{{ $rate->price }}" data-rate-id="{{ $rate->id }}" data-delivery-type="{{ $rate->delivery_type }}">
                        <label class="form-check-label" for="shipping_rate_{{ $rate->id }}">
                            {{ ucwords(str_replace('_', ' ', $rate->delivery_type)) }} - €{{ number_format($rate->price, 2) }}
                            <small class="text-muted d-block">
                                (@if($rate->min_weight < 1)
                                    {{ $rate->min_weight * 1000 }}g
                                @else
                                    {{ $rate->min_weight }}kg
                                @endif
                                - 
                                @if($rate->max_weight < 1)
                                    {{ $rate->max_weight * 1000 }}g
                                @else
                                    {{ $rate->max_weight }}kg
                                @endif)
                            </small>
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-warning">
            <small>No shipping options available for your cart weight.</small>
        </div>
    @endif
</div>

@push('styles')
<style>
    .shipping-option {
        cursor: pointer;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        transition: border-color 0.3s ease;
    }
    .shipping-option:hover {
        border-color: #007bff;
    }
    .shipping-option.selected {
        border-color: #007bff;
        background-color: #f8f9fa;
    }
    .text-muted {
        font-size: 0.875em;
    }
</style>
@endpush

@push('scripts')
<script>
    (function($) {
        "use strict";
        $(document).ready(function () {
            let subtotal = {{ $subtotal }};
            let deliveryFee = {{ $deliveryFee }};

            // Auto-select the first (cheapest) shipping option if available
            if ($('.shipping-option').length > 0) {
                $('.shipping-option').first().click();
            }

            $('.shipping-option').on('click', function() {
                $('.shipping-option').removeClass('selected');
                $(this).addClass('selected');
                $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
            });

            $('input[name="shipping_rate"]').on('change', function() {
                let shippingCost = parseFloat($(this).val());
                let rateId = $(this).data('rate-id');
                let deliveryType = $(this).data('delivery-type');
                
                let newTotal = subtotal  + shippingCost;
                $('.delivery_charge').text('£' + shippingCost.toFixed(2));
                $('input[name="delivery_fee"]').val(shippingCost.toFixed(2));
                $('.grand_total').text('£' + newTotal.toFixed(2));
                $('#total_price_input').val(newTotal.toFixed(2));
                
                // Add hidden inputs for shipping details
                
                $('#shipping_rate_id').val(rateId);
                $('#shipping_delivery_type').val(deliveryType);
            });
        });
    })(jQuery);
</script>
@endpush
