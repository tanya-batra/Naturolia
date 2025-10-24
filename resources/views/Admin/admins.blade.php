@extends('Admin.layout.app')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="col-lg-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-dark text-white fw-bold">
                Admin List
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>S No .</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Email ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $index => $admin)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                  
                                    @if($admin->profile_image)
                                        <img src="{{ asset('storage/' . $admin->profile_image) }}" alt="Profile Image" width="50" height="50" class="rounded-circle">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->phone ?? 'N/A' }}</td>
                                <td>{{ $admin->email }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
