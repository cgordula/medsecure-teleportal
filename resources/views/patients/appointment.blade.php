@extends('patients.patient_layout')

@section('content')
    <div class="appointment-header">
        <h1>Schedule Appointment</h1>
    </div>

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

    <!-- Full Width Form Wrapper (Specific Class for Appointment Form) -->
    <div class="appointment-form-container">
        <!-- Appointment Form -->
        <form id="appointmentForm" class="appointment-form" action="{{ route('patients.store-appointment') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ auth()->user()->id }}">

            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
            </div>

            <div class="form-group">
                <label for="appointment_date">Preferred Date:</label>
                <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}" required>
            </div>

            <div class="form-group">
                <label for="appointment_time">Preferred Time:</label>
                <input type="time" class="form-control" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}" required>
            </div>

            <div class="form-group">
                <label for="doctor">Select Doctor:</label>
                <select class="form-control" id="doctor" name="doctor" required>
                <option value="Dr. Orawan Kosumsupamala" {{ old('doctor') == 'Dr. Orawan Kosumsupamala' ? 'selected' : '' }}>Dr. Orawan Kosumsupamala</option>
                <option value="Dr. Woraporn Ratanalert" {{ old('doctor') == 'Dr. Woraporn Ratanalert' ? 'selected' : '' }}>Dr. Woraporn Ratanalert</option>
                <option value="Dr. Krairit Tiyakul" {{ old('doctor') == 'Dr. Krairit Tiyakul' ? 'selected' : '' }}>Dr. Krairit Tiyakul</option>
                </select>
            </div>

            <div class="form-group">
                <label for="message">Message (Optional):</label>
                <textarea class="form-control" id="message" name="message" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </form>
    </div>

@endsection
