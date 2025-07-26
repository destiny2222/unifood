<div>
    <div class="wsus__menu_cart_boody">
        @if (count($carts) > 0)
            <div class="wsus__menu_cart_header">
                <h5 class="mini_cart_body_item">Total Item({{ count($carts) }})</h5>
                <span class="close_cart"><i class="fal fa-times" aria-hidden="true"></i></span>
            </div>
        @endif 
    
        <ul class="mini_cart_list">
            @forelse ($carts as $cartId => $cartItem)
                @php
                    $product = $products[$cartId] ?? null;
                    $subtotal = $cartItem['price'] * $cartItem['quantity'];
                @endphp

                @if($product)
                <li class="min-item mb-5">
                    <div class="menu_cart_img">
                        <img src="{{ $product->images }}" alt="menu" class="img-fluid w-100">
                    </div> 
                    <div class="menu_cart_text">
                        <a class="title" href="{{ route('frontend.product.show', $product->slug) }}">
                            {{ \Str::limit($product->title, 50) }}
                        </a>
                        <div class="d-flex align-items-center" style="column-gap: 10px;">
                            <span class="quantity">{{ $cartItem['quantity'] }} x</span>
                            <p class="price mini-price">£{{ number_format($cartItem['price'], 2) }}</p>
                        </div>
                    </div>
                    <button class="del_icon mini-item-remove" wire:click="removeItem('{{ $cartId }}')">
                        <i class="fal fa-times" aria-hidden="true"></i>
                    </button>
                </li>
                @endif
            @empty
                <div class="wsus__menu_cart_header">
                    <h5>Your shopping cart is empty!</h5>
                    <span class="close_cart"><i class="fal fa-times"></i></span>
                </div>
            @endforelse
        </ul>

        @if(count($carts) > 0)
            <p class="subtotal">Sub Total <span class="mini_sub_total">${{ number_format($total, 2) }}</span></p>
            <a class="cart_view" href="{{ route('cart.index') }}"> view cart</a>
            <a class="checkout" href="{{ route('checkout') }}">checkout</a>
        @endif
    </div>
</div>
