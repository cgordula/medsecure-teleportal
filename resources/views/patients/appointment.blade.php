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

    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    <!-- Full Width Form Wrapper (Specific Class for Appointment Form) -->
    <div class="appointment-form-container">
        <!-- Appointment Form -->
        <form id="appointmentForm" class="appointment-form" action="{{ route('patients.store-appointment') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ auth()->user()->id }}">


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

            <button type="submit" class="btn btn-primary" id="bookAppointment">Book Appointment</button>
        </form>
    </div>




@endsection
