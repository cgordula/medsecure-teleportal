@extends('patients.patient_layout')

@section('content')
<h2>Your Profile</h2>

<!-- Success message after updating profile -->
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif


<div class="row">
    <!-- Profile Section -->
    <div class="col-md-4">
        <div class="card">
            <div class="profile-image-wrapper">
                <img src="{{ $patient->profile_picture ? asset('storage/patient_photos/' . $patient->profile_picture) : 'https://via.placeholder.com/350x200' }}" class="card-img-top fixed-profile-image" alt="Patient's Photo">
            </div>

            <div class="card-body">
                <h5 class="card-title">{{ $patient->first_name }} {{ $patient->last_name }}</h5>
                <p class="card-text text-muted">Patient</p>
                <p class="text-muted"><strong>Member Since: </strong>{{ $patient->created_at->format('F Y') }}</p>
                <p class="text-muted"><strong>Age: </strong>{{ \Carbon\Carbon::parse($patient->birthdate)->age }} years</p>
                <p class="text-muted"><strong>Gender: </strong>{{ $patient->gender }}</p>
                <p class="text-muted"><strong>Birthdate: </strong>{{ $patient->birthdate ? \Carbon\Carbon::parse($patient->birthdate)->format('F j, Y') : '' }}</p>
                <p class="text-muted"><strong>Phone: </strong>{{ $patient->phone }}</p>
                <p class="text-muted"><strong>Email: </strong>{{ $patient->email }}</p>
                <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#editProfileModal">Edit Profile</a>
            </div>
        </div>
    </div>

    <!-- Patient Information Section -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Medical Information</h4>
            </div>
            <div class="card-body">
                <h5>Medical History</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et augue eu ligula sodales tincidunt non eget urna.</p>
                <hr>
                <h5>Current Medications</h5>
                <ul>
                    <li>Medicine A - 2 times a day</li>
                    <li>Medicine B - Once a day</li>
                    <li>Medicine C - As needed</li>
                </ul>
                <hr>
                <h5>Allergies</h5>
                <p>Penicillin, Aspirin</p>
                <hr>
                <h5>Emergency Contact</h5>
                <p><strong>Name:</strong> Jane Doe</p>
                <p><strong>Relationship:</strong> Sister</p>
                <p><strong>Phone:</strong> +1 234 567 890</p>
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
            <form action="{{ route('patients.update-profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- First Name -->
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required>
                    </div>

                    <!-- Last Name -->
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required>
                    </div>
                    
                    <!-- Gender -->
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ $patient->gender == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Birthdate -->
                    <div class="form-group">
                        <label for="birthdate">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ old('birthdate', $patient->birthdate ? $patient->birthdate->format('Y-m-d') : '') }}">
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}">
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $patient->email) }}" required>
                    </div>

                    <!-- Photo Upload (Optional) -->
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection


<!-- Add these to the bottom of your HTML or inside the <head> tag -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

