@extends('Admin.layout.app')

@section('content')
<style>
.uniform-image {
    width: 100px;  
    height: 100px;  
    object-fit: cover;
}
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">All Products</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Add Product
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark text-uppercase text-center">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Short Description</th>
                    <th>Price (₹)</th>
                    <th>Best Product</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $product)
                    <tr data-bs-toggle="collapse" data-bs-target="#images-{{ $product->id }}" style="cursor: pointer;" class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td class="text-start">{{ $product->title }}</td>
                        <td>{{ $product->slug }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($product->short_description, 50) }}</td>
                        <td>
                            @if($product->mrp_price > $product->price)
                                <span class="fw-bold text-success">₹{{ number_format($product->price,2) }}</span>
                                <span class="text-muted text-decoration-line-through ms-1">₹{{ number_format($product->mrp_price,2) }}</span>
                                <span class="badge bg-success ms-1">{{ $product->discount ?? round((($product->mrp_price-$product->price)/$product->mrp_price)*100) }}% OFF</span>
                            @else
                                <span class="fw-bold text-success">₹{{ number_format($product->price,2) }}</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm toggle-best-product {{ $product->best_product ? 'btn-success' : 'btn-secondary' }}" data-id="{{ $product->id }}">
                                {{ $product->best_product ? 'Best Product' : 'Mark as Best' }}
                            </button>
                        </td>
                        <td class="d-flex flex-column gap-1 justify-content-center">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- Collapsible row for images --}}
                   <tr class="collapse bg-light" id="images-{{ $product->id }}">
    <td colspan="7">
        <div class="d-flex flex-wrap gap-2 justify-content-start p-3">
            @forelse($product->images as $image)
                <div class="position-relative text-center">
                    <img src="{{ asset($image->image_path) }}" 
                         alt="Product Image" 
                         class="img-thumbnail uniform-image {{ $image->top_image ? 'border-success border-3' : '' }}">
                    <button class="btn btn-sm mt-1 w-100 toggle-featured-btn {{ $image->top_image ? 'btn-success' : 'btn-secondary' }}" 
                            data-id="{{ $image->id }}">
                        {{ $image->top_image ? 'Top Image' : 'Set as Top' }}
                    </button>
                </div>
            @empty
                <span class="text-muted">No Images</span>
            @endforelse
        </div>
    </td>
</tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- jQuery & SweetAlert --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>

<script>
$(document).ready(function() {
    // Toggle Top Image
    $(document).on('click', '.toggle-featured-btn', function(e) {
        e.stopPropagation(); // prevent row collapse toggle
        let btn = $(this);
        let imageId = btn.data('id');

        Swal.fire({
            title: 'Confirm Top Image?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, set it!'
        }).then((result) => {
            if(result.isConfirmed) {
                $.post('/admin/product-images/toggle-featured/' + imageId, {_token: '{{ csrf_token() }}'}, function(res) {
                    if(res.status === 'success') {
                        $('.toggle-featured-btn').removeClass('btn-success').addClass('btn-secondary').text('Set as Top');
                        btn.removeClass('btn-secondary').addClass('btn-success').text('Top Image');
                        Swal.fire('Updated!', 'Top image updated.', 'success');
                    }
                });
            }
        });
    });

    // Toggle Best Product
    $('.toggle-best-product').on('click', function(e) {
        e.stopPropagation();
        let btn = $(this);
        let productId = btn.data('id');

        Swal.fire({
            title: 'Toggle Best Product?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if(result.isConfirmed) {
                $.post('/admin/products/toggle-best/' + productId, {_token: '{{ csrf_token() }}'}, function(res) {
                    if(res.status === 'success') {
                        btn.toggleClass('btn-success btn-secondary');
                        btn.text(res.best_product ? 'Best Product' : 'Mark as Best');
                        Swal.fire('Success!', 'Status updated.', 'success');
                    }
                }).fail(function() {
                    Swal.fire('Error!', 'Failed to update status.', 'error');
                });
            }
        });
    });
});
</script>
@endsection
