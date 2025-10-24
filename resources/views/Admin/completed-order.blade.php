@extends('Admin.layout.app')

@section('content')
<div class="container-fluid">
    <!-- Completed Orders List -->
    <div class="col-lg-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-dark text-white fw-bold">
                Completed Orders List
            </div>
            <div class="card-body p-0">
                <div class="accordion" id="accordionCompletedOrders">
                    @forelse($orders as $order)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $order->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $order->id }}" aria-expanded="false" aria-controls="collapse{{ $order->id }}">
                                <table class="table table-hover align-middle mb-0 mb-0 w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Status</th>
                                            <th>Order Date</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td><span class="badge bg-success">{{ ucfirst($order->status) }}</span></td>
                                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                                            <td>₹ {{ number_format($order->total, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </button>
                        </h2>
                        <div id="collapse{{ $order->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $order->id }}" data-bs-parent="#accordionCompletedOrders">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Product Image</th>
                                                <th>Quantity</th>
                                                <th>User City</th>
                                                <th>Shipping Address</th>
                                                <th>Zip Code</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->items as $item)
                                            <tr>
                                                <td>{{ $item->product->title ?? 'N/A' }}</td>
                                                <td>
                                                    <img src="{{ asset($item->product->images->first()->image_path ?? 'images/default-placeholder.jpg') }}" alt="Product Image" width="50" height="50" class="rounded">
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $order->user->city ?? 'N/A' }}</td>
                                                <td>{{ $order->shipping_address }}</td>
                                                <td>{{ $order->user->zipcode ?? 'N/A' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center p-4">No completed orders found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
