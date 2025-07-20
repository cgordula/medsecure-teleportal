@extends('admin.admin_layout')

@section('content')
<div class="dashboard-header">
    <h1>Edit Appointment</h1>
</div>

<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="card p-4 shadow" style="max-width: 600px; width: 100%;">

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

        <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="patient_id" class="form-label">Select Patient</label>
                <select class="form-select" name="patient_id" required>
                    <option value="">-- Choose Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                            {{ $patient->first_name }} {{ $patient->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="doctor_id" class="form-label">Select Doctor</label>
                <select class="form-select" name="doctor_id" required>
                    <option value="">-- Choose Doctor --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                            Dr. {{ $doctor->first_name }} {{ $doctor->last_name }} - {{ $doctor->specialization }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="appointment_date" class="form-label">Appointment Date</label>
                <input type="date" class="form-control" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" required>
            </div>

            <div class="mb-3">
                <label for="appointment_time" class="form-label">Appointment Time</label>
                <input type="time" class="form-control" name="appointment_time" value="{{ old('appointment_time', $appointment->appointment_time) }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Appointment Status</label>
                <select class="form-select" name="status" required>
                    <option value="Scheduled" {{ $appointment->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="Completed" {{ $appointment->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ $appointment->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="Declined" {{ $appointment->status == 'Declined' ? 'selected' : '' }}>Declined</option>
                    <option value="Accepted" {{ $appointment->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                </select>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Update Appointment</button>
            </div>
        </form>
    </div>
</div>
@endsection
