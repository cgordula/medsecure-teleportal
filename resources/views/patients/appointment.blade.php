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

    <div class="container d-flex justify-content-center align-items-center mt-5">
        <div class="card p-4 shadow" style="max-width: 600px; width: 100%;">
            <h4 class="text-center mb-4">Book an Appointment</h4>
            <form id="appointmentForm" action="{{ route('patients.store-appointment') }}" method="POST">
                @csrf
                <input type="hidden" name="patient_id" value="{{ auth()->user()->id }}">

                <div class="mb-3">
                    <label for="appointment_date" class="form-label">Preferred Date:</label>
                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}" required>
                </div>

                <div class="mb-3">
                    <label for="appointment_time" class="form-label">Preferred Time:</label>
                    <input type="time" class="form-control" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}" required>
                </div>

                <div class="mb-3">
                    <label for="doctor" class="form-label">Select Doctor:</label>
                    <select class="form-select" id="doctor" name="doctor" required>
                        <option value="Dr. Orawan Kosumsupamala" {{ old('doctor') == 'Dr. Orawan Kosumsupamala' ? 'selected' : '' }}>Dr. Orawan Kosumsupamala</option>
                        <option value="Dr. Woraporn Ratanalert" {{ old('doctor') == 'Dr. Woraporn Ratanalert' ? 'selected' : '' }}>Dr. Woraporn Ratanalert</option>
                        <option value="Dr. Krairit Tiyakul" {{ old('doctor') == 'Dr. Krairit Tiyakul' ? 'selected' : '' }}>Dr. Krairit Tiyakul</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message (Optional):</label>
                    <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100" id="bookAppointment">Book Appointment</button>
            </form>
        </div>
    </div>





@endsection
