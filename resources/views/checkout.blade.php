@extends('layout.main')
@section('content')
<style>
    /* --- Color Variables (Included here for reference) --- */
    :root {
        --primary-color: #007300;
        /* Dark Green */
        --secondary-color: #38b000;
        /* Bright Green */
        --accent-color: #cddc39;
        /* Light Green/Lime */
        --black-header: #212529;
        /* Near black for header */
        --light-bg: #f8f9fa;
        --text-color: #333;
        --custom-font: "Roboto Slab", serif;
    }

    /* Override Bootstrap elements to use the Green Theme */
    .text-primary,
    .text-success {
        color: var(--secondary-color) !important;
    }

    .btn-primary {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }

    .btn-primary:hover {
        background-color: var(--secondary-color) !important;
        border-color: var(--secondary-color) !important;
    }

    .btn-outline-primary {
        color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color) !important;
        color: #fff !important;
    }


    /* Checkout Container Padding adjustment for fixed header */
    .checkout-section {
        padding-top: 100px !important;
    }

    /* Styling the Step Headers like major e-commerce platforms */
    .checkout-step .card-header {
        background-color: var(--light-bg);
        /* Light grey background from variable */
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--text-color);
        padding: 15px 20px;
    }

    /* Step number color */
    .checkout-step .card-header .text-success {
        color: var(--secondary-color) !important;
    }

    /* Styling the Place Order/Continue Button (Bright Green - Secondary Color) */
    .place-order-btn {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        color: #fff;
        font-weight: bold;
        padding: 12px 20px;
        transition: background-color 0.3s;
    }

    .place-order-btn:hover {
        background-color: var(--primary-color);
        /* Dark Green on hover */
        border-color: var(--primary-color);
        color: #fff;
    }

    /* Custom Heading Style */
    .page-checkout-heading {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
        /* Use Dark Green */
        border-bottom: 3px solid var(--accent-color);
        /* Light Green/Lime underline */
        padding-bottom: 10px;
        margin-bottom: 30px !important;
        display: inline-block;
    }

    /* Order Summary sticky effect for desktop (optional) */
    @media (min-width: 992px) {
        .summary-sticky {
            position: sticky;
            top: 80px;
            /* Adjust based on header height */
        }
    }
</style>

<section id="checkout" class="checkout-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="page-checkout-heading"><i class="fas fa-shopping-cart me-2"></i>CHECKOUT</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-4">

            <!-- Left Column -->
            <div class="col-lg-8">

                <!-- Step 1: Login/Contact -->
                <div class="card checkout-step mb-3 shadow-sm">
                    <div class="card-header">
                        <span class="text-success me-2"><i class="fas fa-check-circle"></i></span>
                        1. LOGIN / CONTACT
                    </div>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 fw-bold">{{ $user->name }}</p>
                            <p class="mb-0 text-muted small">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Main Checkout Form -->
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    <!-- Step 2: Delivery Address -->
                    <div class="card checkout-step mb-3 shadow-sm">
                        <div class="card-header">2. DELIVERY ADDRESS</div>
                        <div class="card-body">
                            <h5 class="mb-3">Select Address</h5>

                            @if($user->address)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="shipping_address_id" value="user_address" id="userAddress" {{ session('selected_address') ? '' : 'checked' }}>
                                    <label class="form-check-label fw-bold" for="userAddress">Default Profile Address</label>
                                    <p class="mb-0 ms-4 ps-2 small text-muted">
                                        {{ $user->address }}, {{ $user->city }}, {{ $user->state }} - {{ $user->pincode }}
                                    </p>
                                </div>
                            @endif

                            @if($user->addresses && $user->addresses->count() > 0)
                                @foreach($user->addresses as $address)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="shipping_address_id"
                                               value="{{ $address->id }}" id="address{{ $address->id }}"
                                               {{ session('selected_address') == $address->id ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="address{{ $address->id }}">{{ $address->receiver_name }}</label>
                                        <p class="mb-0 ms-4 ps-2 small text-muted">{{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}</p>
                                    </div>
                                @endforeach
                            @endif

                            {{-- Add New Address Button to trigger modal --}}
                            <button type="button" class="btn btn-sm btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                <i class="fas fa-plus me-1"></i> ADD NEW ADDRESS
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Order Summary -->
                    <div class="card checkout-step mb-3 shadow-sm">
                        <div class="card-header">3. ORDER SUMMARY</div>
                        <div class="card-body">
                            @foreach($cartItems as $cartItem)
                                <div class="d-flex border-bottom pb-3 mb-3">
                                    <img src="{{ asset($cartItem->product->images->first()->image_path) }}" alt="{{ $cartItem->product->title }}" style="width:60px;height:60px;object-fit:cover;" class="me-3 rounded">
                                    <div>
                                        <p class="mb-0 fw-bold">{{ $cartItem->product->title }}</p>
                                        <p class="mb-0 small text-muted">Qty: {{ $cartItem->quantity }} | Price: ₹{{ $cartItem->price }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Step 4: Payment Options -->
                    <div class="card checkout-step mb-3 shadow-sm">
                        <div class="card-header">4. PAYMENT OPTIONS</div>
                        <div class="card-body">
                            <div class="form-check mb-3 p-3 border rounded-3 bg-light">
                                <input class="form-check-input" type="radio" name="paymentMethod" value="cod" id="cod" checked>
                                <label class="form-check-label fw-bold" for="cod"><i class="fas fa-handshake me-2"></i> Cash on Delivery (COD)</label>
                            </div>
                            <div class="form-check mb-3 p-3 border rounded-3">
                                <input class="form-check-input" type="radio" name="paymentMethod" value="online" id="online">
                                <label class="form-check-label fw-bold" for="online"><i class="fas fa-credit-card me-2"></i> UPI / Cards / Net Banking</label>
                            </div>

                            <div class="border-top pt-3 mt-4">
                                <button class="btn btn-lg w-100 place-order-btn" type="submit">
                                    PLACE ORDER (TOTAL: ₹{{ number_format($totalPrice + ($totalPrice * 0.18), 2) }})
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Column: Price Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm p-4 summary-sticky">
                    <h5 class="mb-3 text-dark border-bottom pb-2">PRICE DETAILS</h5>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted small">Price ({{ count($cartItems) }} items)</span>
                        <span class="small">₹{{ number_format($totalPrice, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted small">GST (18%)</span>
                        <span class="small">₹{{ number_format($totalPrice * 0.18, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted small">Delivery Charges</span>
                        <span class="text-success small">FREE</span>
                    </div>
                    <div class="d-flex justify-content-between py-3 border-top border-2 mt-2">
                        <h5 class="fw-bold text-dark mb-0">Total Payable</h5>
                        <h5 class="fw-bold text-dark mb-0">₹{{ number_format($totalPrice + ($totalPrice * 0.18), 2) }}</h5>
                    </div>
                    <p class="text-success fw-bold mt-3 small">You will save ₹0 on this order!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Add New Address -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('checkout.add_address') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="receiver_name" class="form-control" placeholder="Receiver Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="address" class="form-control" placeholder="Full Address" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="pincode" class="form-control" placeholder="Pincode" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="city" class="form-control" placeholder="City" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="state" class="form-control" placeholder="State" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Address</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
@endsection
