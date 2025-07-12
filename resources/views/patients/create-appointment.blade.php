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
                    <div class="invalid-feedback"> Please select a date that is at least 48 hours from now.</div>
                </div>

                <div class="mb-3">
                    <label for="appointment_time" class="form-label">Preferred Time:</label>
                    <input type="time" class="form-control" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}" required>
                </div>

                <div class="mb-3">
                    <label for="doctor_id" class="form-label">Select Doctor:</label>
                    <select class="form-select" id="doctor_id" name="doctor_id" required>
                        <option value="">-- Select Doctor --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
                            </option>
                        @endforeach
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


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dateInput = document.getElementById('appointment_date');
        const timeInput = document.getElementById('appointment_time');
        const form = document.getElementById('appointmentForm');

        // Calculate min date = today + 2 days
        const now = new Date();
        now.setDate(now.getDate() + 2);
        const minDate = now.toISOString().split('T')[0];
        dateInput.setAttribute('min', minDate);

        form.addEventListener('submit', function (e) {
            const selectedDate = new Date(dateInput.value + 'T' + (timeInput.value || '00:00'));
            const currentDateTime = new Date();
            currentDateTime.setHours(currentDateTime.getHours() + 48); // Add 48 hours

            if (selectedDate < currentDateTime) {
                e.preventDefault();
                alert("Appointments must be scheduled at least 48 hours in advance.");
                dateInput.classList.add('is-invalid');
                timeInput.classList.add('is-invalid');
            } else {
                dateInput.classList.remove('is-invalid');
                timeInput.classList.remove('is-invalid');
            }
        });
    });
</script>

