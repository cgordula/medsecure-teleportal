@extends('admin.admin_layout')

@section('content')
<div class="container mt-4">
    <h2>Edit Patient: {{ $patient->first_name }} {{ $patient->last_name }}</h2>

    <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $patient->first_name) }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $patient->email) }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="Male" {{ $patient->gender === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $patient->gender === 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ $patient->gender === 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Birthdate</label>
                <input type="date" name="birthdate" value="{{ old('birthdate', $patient->birthdate) }}" class="form-control" required>
            </div>

            <!-- Address -->
            <div class="col-md-6 mb-3">
                <label>Address Line 1</label>
                <input type="text" name="address_line1" value="{{ old('address_line1', $patient->address_line1) }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>City</label>
                <input type="text" name="city" value="{{ old('city', $patient->city) }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>State</label>
                <input type="text" name="state" value="{{ old('state', $patient->state) }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Postal Code</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', $patient->postal_code) }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Country</label>
                <input type="text" name="country" value="{{ old('country', $patient->country) }}" class="form-control" required>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-success" type="submit">Save Changes</button>
            <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
