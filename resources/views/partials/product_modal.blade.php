<div class="wsus__cart_popup_modal ">
    <!-- Image Section -->
    <div class="wsus__cart_popup_modal_image_section">
        <img src="{{ $product->images }}" alt="Product Image">
    </div>
    <!-- Details Section -->
    <div class="wsus__cart_popup_modal_details_section">
        <div class="reviews">
            <span class="in-stock">
                @if ($product->availability > 0)
                    In stock
                @else
                    Out of stock
                @endif
            </span>
        </div>
        <div class="product-title">{{ $product->title }}</div>
        <div class="variant-price price">£{{ $product->variants->first()->price }}</div>
        <div class="description">
            {!! $product->description !!}
        </div>

        <div class="label">Size:</div>
        <div class="sizes">
            @foreach ($product->variants as $variant)
                <div class="size-option" data-price="{{ $variant->price }}" data-size="{{ $variant->size }}">
                    {{ $variant->size }}
                </div>
            @endforeach
        </div>

        {{-- <input type="hidden" id="selected_size" name="size"> --}}
        <form id="add-to-cart-form">
            <input type="hidden" name="size_variant" id="selected_size">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" id="selected_quantity" value="1">
            <input type="hidden" id="selected_price" name="price">
        </form>

        <div class="quantity-wrapper">
            <button type="button" class="qty-btn minus">−</button>
            <div class="qty-display">1</div>
            <button type="button" class="qty-btn plus">+</button>
        </div>

        <div class="buttons">
            <button class="add-cart">Add To Cart</button>
            <button class="wishlist">♡</button>
        </div>
    </div>
</div>

<script>
    (function($) {
        "use strict";
        $(document).ready(function() {

            // Handle size selection
            $('.size-option').click(function() {
                $('.size-option').removeClass('active');
                $(this).addClass('active');
                $('#selected_size').val($(this).data('size'));

                // Optional: update price if sizes have different prices
                const price = $(this).data('price');
                $('.variant-price').text(`£${price}`);
                $('#selected_price').val(price);
            });

            // Handle quantity increment/decrement
            let quantity = 1;
            $('.plus').click(function() {
                quantity++;
                $('.qty-display').text(quantity);
                $('#selected_quantity').val(quantity);
            });
            $('.minus').click(function() {
                if (quantity > 1) {
                    quantity--;
                    $('.qty-display').text(quantity);
                    $('#selected_quantity').val(quantity);
                }
            });

            // Handle Add to Cart
            $('.add-cart').click(function(e) {
                e.preventDefault();

                const form = $('#add-to-cart-form');
                const size = $('#selected_size').val();
                const button = $(this);

                if (!size) {
                    toastr.error("Please select a size.");
                    return;
                }

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
                            Livewire.dispatch('cartUpdated');
                            // Update cart count
                            if (response.cart_count !== undefined) {
                                $('#cart-count').text(response.cart_count).addClass('animate__animated animate__pulse');
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
                        toastr.error("Something went wrong. Try again.");
                        console.log(xhr.responseText);
                    },
                    complete: function() {
                        button.prop('disabled', false).text('Add To Cart');
                    }
                });
            });

        });
    })(jQuery);
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