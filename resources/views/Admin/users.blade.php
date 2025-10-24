@extends('Admin.layout.app')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="col-lg-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-dark text-white fw-bold">
                User List
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th> 
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Email ID</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Zip Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user) 
                            <tr id="user-{{ $user->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone ?? 'N/A' }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->city ?? 'N/A' }}</td>
                                <td>{{ $user->address ?? 'N/A' }}</td>
                                <td>{{ $user->zipcode ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }}" 
                                          id="status-{{ $user->id }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>
                                   
                                    <button class="btn btn-sm btn-primary toggle-status" 
                                            data-id="{{ $user->id }}" 
                                            data-status="{{ $user->status }}">
                                        Change Status
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).on('click', '.toggle-status', function() {
        var userId = $(this).data('id');
        var currentStatus = $(this).data('status');
        var newStatus = (currentStatus === 'active') ? 'inactive' : 'active'; 

        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to change the status to ${newStatus}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('admin.user.updateStatus') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        status: newStatus,
                    },
                    success: function(response) {
                        $('#status-' + userId)
                            .removeClass('bg-success bg-danger')
                            .addClass(newStatus === 'active' ? 'bg-success' : 'bg-danger')
                            .text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));

                        Swal.fire(
                            'Success!',
                            response.message,
                            'success'
                        );
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong, please try again.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
@endpush
