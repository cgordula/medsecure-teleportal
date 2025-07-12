@extends('doctors.doctor_layout')

@section('content')
<div class="profile-header">
    <h1>Your Profile</h1>
</div>


<!-- Success/Error message after updating profile -->
@if (session('success'))
    <div id="success-message" class="alert alert-success">
        {{ session('success') }}
    </div>
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
                <img src="{{ $doctor->profile_picture ? asset('storage/doctor_photos/' . $doctor->profile_picture) : 'https://via.placeholder.com/350x200' }}" class="card-img-top custom-profile-img" alt="Doctors's Photo">

                </div>

                <div class="card-body text-center">
                    <h5 class="card-title mb-1">{{ $doctor->first_name }} {{ $doctor->last_name }}</h5>
                    <p class="text-muted mb-2"><i class="fas fa-stethoscope text-primary me-1"></i>{{ ucfirst($doctor->role) }}</p>
                    <p class="text-center small text-secondary mb-1"><i class="fas fa-id-badge text-primary me-2"></i>{{ $doctor->reference_number }}</p>
                    <p class="text-muted small"><i class="fas fa-calendar-alt text-success me-2"></i><strong>Member Since:</strong>{{ $doctor->created_at->format('d F Y') }}</p>

                    <a href="#" class="btn btn-outline-primary btn-sm btn-block mt-3" data-toggle="modal" data-target="#editProfileModal">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

   <!-- Information Card -->
<div class="col">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Doctor Information</h4>
            <ul class="list-unstyled">
                <li class="mb-3 d-flex align-items-start">
                    <i class="fas fa-phone-alt text-primary me-2 mt-1"></i>
                    <div><strong>Phone:</strong><br>{{ $doctor->phone }}</div>
                </li>
                <li class="mb-3 d-flex align-items-start">
                    <i class="fas fa-envelope text-danger me-2 mt-1"></i>
                    <div><strong>Email:</strong><br>{{ $doctor->email }}</div>
                </li>
                <li class="mb-3 d-flex align-items-start">
                    <i class="fas fa-id-badge text-success me-2 mt-1"></i>
                    <div><strong>License Number:</strong><br>{{ $doctor->license_number }}</div>
                </li>
                <li class="mb-3 d-flex align-items-start">
                    <i class="fas fa-user-md text-info me-2 mt-1"></i>
                    <div><strong>Specialization:</strong><br>{{ $doctor->specialization }}</div>
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
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            
            <!-- Profile Edit Form -->
            <form action="{{ route('doctors.update-profile') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-6 form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $doctor->first_name) }}" required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6 form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $doctor->last_name) }}" required>
                        </div>
                    </div>


                    <div class="row">
                        <!-- Phone -->
                        <div class="col-md-6 form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $doctor->email) }}" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="specialization" class="form-label">Specialization</label>
                            <input type="text" class="form-control" id="specialization" name="specialization" value="{{ old('specialization', $doctor->specialization) }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="license_number" class="form-label">License Number</label>
                            <input type="text" class="form-control" id="license_number" name="license_number" value="{{ old('license_number', $doctor->license_number) }}" required>
                        </div>
                    </div>

                    <!-- Photo Upload (Optional) -->
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="profileSave">Save changes</button>
                </div>
            </form>

        </div>
    </div>
</div>



@endsection




