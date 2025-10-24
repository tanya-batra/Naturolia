@extends('layout.main')

@section('content')
<section id="shopping-cart" class="py-5" style="min-height: 80vh;">
    <div class="container">
        <h1 class="common-header">My Shopping Cart</h1>
        <p class="lead text-muted mb-5">Review your order before checkout.</p>

        <div class="row">
            <!-- Left Side: Cart Items List -->
            <div class="col-lg-8">
                <div id="cart-items-container" class="cart-items-list shadow-sm p-3 mb-5 bg-white rounded">
                    @forelse ($items as $item)
             <!-- Cart Item -->
<div class="cart-item d-flex align-items-center border-bottom py-3" data-product-id="{{ $item->id }}" data-price="{{ $item->price }}">
    <div class="item-img me-3">
        <!-- Product Image -->
        @if ($item->product->images->isNotEmpty())
            <img src="{{ asset($item->product->images->first()->image_path) }}" alt="{{ $item->product->name }}" class="img-fluid" style="width: 80px; height: 80px; object-fit: cover;">
        @else
            <img src="{{ asset('images/default-placeholder.jpg') }}" alt="No Image Available" class="img-fluid" style="width: 80px; height: 80px; object-fit: cover;">
        @endif
    </div>
    <div class="item-details flex-grow-1">
        <h5 class="item-name mb-0">{{ $item->product->title }}</h5>
        <p class="item-price text-primary mb-1">₹{{ number_format($item->price, 2) }}</p>
        <div class="item-actions d-flex align-items-center">
            <!-- Quantity Control -->
            <div class="quantity-control me-3">
                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="cart-item-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="quantity" class="quantity-input" value="{{ $item->quantity }}">
                    <button type="button" class="btn btn-sm btn-outline-secondary minus-btn">-</button>
                    <input type="number" class="form-control form-control-sm item-quantity d-inline-block text-center" value="{{ $item->quantity }}" min="1" style="width: 50px;" readonly>
                    <button type="button" class="btn btn-sm btn-outline-secondary plus-btn">+</button>
                </form>
            </div>
            <!-- Remove Item -->
            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm text-danger remove-item-btn"><i class="fa-solid fa-trash-alt"></i> Remove</button>
            </form>
        </div>
    </div>

    <!-- Product Total Price (quantity * price) -->
    <div class="item-total fw-bold fs-5 text-end" style="width: 100px;">
        ₹<span class="product-subtotal">{{ number_format($item->price * $item->quantity, 2) }}</span>
    </div>
</div>

                    @empty
                    <!-- Empty Cart Message -->
                    <div class="text-center p-5 empty-cart-message">
                        <i class="fa-solid fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Your cart is empty!</h4>
                        <a href="{{ route('product') }}" class="btn custom-btn-primary mt-3">Start Shopping</a>
                    </div>
                    @endforelse
                </div>
                <a href="{{ route('product') }}" class="btn btn-outline-success"><i class="fa-solid fa-arrow-left me-2"></i>Continue Shopping</a>
            </div>

            <!-- Right Side: Cart Summary and Price Details -->
           <!-- Right Side: Cart Summary and Price Details -->
<div class="col-lg-4 mt-4 mt-lg-0">
    <div class="cart-summary p-4 shadow-sm bg-light rounded">
        <h4 class="mb-3 text-primary">Price Details</h4>
        <ul class="list-group list-group-flush">
            <!-- Subtotal Calculation -->
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                Subtotal (<span id="total-items">{{ $items->count() }}</span> items)
                <span id="cart-subtotal">
                    ₹{{ number_format($items->sum(function($item) {
                        return $item->price * $item->quantity; 
                    }), 2) }}
                </span>
            </li>

            <!-- Shipping (assumed free) -->
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                Shipping
                <span id="cart-shipping" class="text-success">FREE</span>
            </li>

            <!-- Tax Calculation (GST 18%) -->
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                Tax (GST)
                <span id="cart-tax">
                    ₹{{ number_format($items->sum(function($item) {
                        return ($item->price * $item->quantity) * 0.18; // Calculate tax based on price * quantity
                    }), 2) }}
                </span>
            </li>

            <!-- Order Total (Subtotal + Tax) -->
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light fw-bold fs-5">
                Order Total
                <span id="cart-total" class="text-primary">
                    ₹{{ number_format(
                        $items->sum(function($item) {
                            return $item->price * $item->quantity; // Sum total of price * quantity
                        }) + 
                        $items->sum(function($item) {
                            return ($item->price * $item->quantity) * 0.18; // Add tax
                        }),
                    2) }}
                </span>
            </li>
        </ul>

        <!-- Checkout Button -->
        <div class="d-grid mt-4">
            <a href="{{ route('checkout.show') }}" class="btn custom-btn-secondary btn-lg" id="checkout-btn">
                Proceed to Checkout
                <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>

        <!-- Savings Information -->
        <div class="text-center small mt-3">
            <p class="text-success fw-bold mb-0">You save <span id="cart-savings">
                ₹{{ number_format($items->sum(function($item) {
                    return ($item->price * $item->quantity) * 0.1; // Assuming 10% savings
                }), 2) }}
            </span> on this order!</p>
        </div>
    </div>
</div>

                </div>
        
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle the increment button click
        $('.plus-btn').on('click', function() {
            var quantityInput = $(this).closest('.cart-item').find('.item-quantity');
            var quantity = parseInt(quantityInput.val());
            var cartItemId = $(this).closest('.cart-item').data('product-id');
            
            // Increment the quantity
            quantity++;

            updateCartItemQuantity(cartItemId, quantity, quantityInput);
        });

        // Handle the decrement button click
        $('.minus-btn').on('click', function() {
            var quantityInput = $(this).closest('.cart-item').find('.item-quantity');
            var quantity = parseInt(quantityInput.val());
            var cartItemId = $(this).closest('.cart-item').data('product-id');
            
            // Decrement the quantity
            if (quantity > 1) {
                quantity--;
                updateCartItemQuantity(cartItemId, quantity, quantityInput);
            }
        });

        // Function to update the cart item quantity
        function updateCartItemQuantity(cartItemId, quantity, quantityInput) {
            $.ajax({
                url: '/cart/update/' + cartItemId, // URL to update item quantity
                method: 'PUT',
                data: {
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Update the displayed quantity
                        quantityInput.val(quantity);

                        // Update the item subtotal
                        var subtotalElement = $(quantityInput).closest('.cart-item').find('.product-subtotal');
                        subtotalElement.text( response.updated_subtotal);

                        // Update the cart total
                        $('#cart-total').text('₹' + response.updated_total);
                        $('#total-items').text('{{ $items->count() }}');
                    } else {
                        alert('Failed to update the cart item quantity.');
                    }
                },
                error: function() {
                    alert('Something went wrong.');
                }
            });
        }
    });
</script>

@endsection
