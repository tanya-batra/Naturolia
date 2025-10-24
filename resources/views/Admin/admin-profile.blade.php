@extends('Admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Display success or error messages -->
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <!-- Admin Profile Settings -->
        <div class="col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="bi bi-person-circle"></i> Admin Profile
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4 text-center">
                            <!-- Display Profile Image -->
                            <div class="profile-image">
                                <img src="{{ asset($admin->profile_image ?? 'default-avatar.png') }}" alt="Profile Image" class="rounded-circle" width="120">
                            </div>
                            <div class="mt-2">
                                <label for="profile_image" class="btn btn-info btn-sm">Change Image</label>
                                <input type="file" name="profile_image" id="profile_image" style="display: none;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $admin->name) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $admin->phone) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" id="city" value="{{ old('city', $admin->city) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $admin->address) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="zipcode" class="form-label">Zip Code</label>
                            <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode', $admin->zipcode) }}" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password Section -->
        <div class="col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-white fw-bold">
                    <i class="bi bi-lock"></i> Change Password
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.updatePassword') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
