@extends('admin.admin_layout')

@section('content')
<div class="profile-header">
    <h1>Your Profile</h1>
</div>

@if (session('success'))
    <div id="success-message" class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div id="error-message" class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="container mt-4">
    <div class="row d-flex">
        <!-- Profile Card -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="profile-image-wrapper">
                    <img src="{{ $admin->profile_picture ? asset('storage/admin_photos/' . $admin->profile_picture) : asset('images/default-admin.png') }}" class="card-img-top custom-profile-img" alt="Admin Photo" />
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title mb-1">{{ $admin->first_name }} {{ $admin->last_name }}</h5>
                    <p class="text-muted mb-2"><i class="fas fa-user-shield text-primary me-1"></i>{{ ucfirst($admin->role) }}</p>
                    <p class="text-muted small"><i class="fas fa-calendar-alt text-success me-2"></i><strong>Created:</strong> {{ $admin->created_at->format('d F Y') }}</p>

                    <a href="#" class="btn btn-outline-primary btn-sm mt-3" data-toggle="modal" data-target="#editProfileModal">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Admin Info Card -->
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-4">Admin Information</h4>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-envelope text-danger me-2 mt-1"></i>
                            <div><strong>Email:</strong><br>{{ $admin->email }}</div>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-user-tag text-info me-2 mt-1"></i>
                            <div><strong>Role:</strong><br>{{ ucfirst($admin->role) }}</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.update-profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $admin->first_name) }}" required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $admin->last_name) }}" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $admin->email) }}" required>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6 form-group">
                            <label>Role</label>
                            <select class="form-control" name="role" required>
                                <option value="admin" {{ $admin->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="editor" {{ $admin->role === 'editor' ? 'selected' : '' }}>Editor</option>
                                <option value="viewer" {{ $admin->role === 'viewer' ? 'selected' : '' }}>Viewer</option>
                            </select>
                        </div>

                        <!-- Optional: Password -->
                        <div class="col-md-6 form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password">
                        </div>

                        <!-- Profile Picture -->
                        <div class="col-12 form-group">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
