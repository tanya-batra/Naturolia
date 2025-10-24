@extends('Admin.layout.app')
@section('content')
<div class="container-fluid">

    <div class="row g-4 mb-4">

        <!-- Total Products -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-box-seam fs-1 text-warning"></i>
                    </div>
                    <h6 class="text-muted">Total Products</h6>
                    <h3 class="fw-bold text-dark">{{ $totalProducts }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-cart-check fs-1 text-primary"></i>
                    </div>
                    <h6 class="text-muted">Total Orders</h6>
                    <h3 class="fw-bold text-dark">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-hourglass-split fs-1 text-warning"></i>
                    </div>
                    <h6 class="text-muted">Pending Orders</h6>
                    <h3 class="fw-bold text-danger">{{ $pendingOrders }}</h3>
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-truck fs-1 text-success"></i>
                    </div>
                    <h6 class="text-muted">Completed Orders</h6>
                    <h3 class="fw-bold text-success">{{ $completedOrders }}</h3>
                </div>
            </div>
        </div>

        <!-- Cancelled Orders -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-x-circle fs-1 text-danger"></i>
                    </div>
                    <h6 class="text-muted">Cancelled Orders</h6>
                    <h3 class="fw-bold text-dark">{{ $cancelledOrders }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-people fs-1 text-info"></i>
                    </div>
                    <h6 class="text-muted">Total Customers</h6>
                    <h3 class="fw-bold text-dark">{{ $totalCustomers }}</h3>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
