@extends('admin.admin_layout')

@section('content')
<div class="container mt-4">
    <h2>Edit Doctor: {{ $doctor->first_name }} {{ $doctor->last_name }}</h2>

    <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Reference No.</label>
                <input type="text" name="reference_number" value="{{ old('reference_number', $doctor->reference_number) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $doctor->first_name) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $doctor->last_name) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $doctor->email) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $doctor->phone) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Specialization</label>
                <input type="text" name="specialization" value="{{ old('specialization', $doctor->specialization) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>License Number</label>
                <input type="text" name="license_number" value="{{ old('license_number', $doctor->license_number) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="Doctor" {{ $doctor->role === 'Doctor' ? 'selected' : '' }}>Doctor</option>
                    <option value="Admin" {{ $doctor->role === 'Admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Profile Picture</label>
                <input type="file" name="profile_picture" class="form-control">
                @if($doctor->profile_picture)
                    <img src="{{ asset('storage/' . $doctor->profile_picture) }}" alt="Profile Picture" width="100" class="mt-2">
                @endif
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-success" type="submit">Save Changes</button>
            <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
