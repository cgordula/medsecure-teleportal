@extends('admin.admin_layout')

@section('content')
<div class="dashboard-header">
    <h1>Create New Appointment</h1>
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

        <form action="{{ route('admin.appointments.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="patient_id" class="form-label">Select Patient</label>
                <select class="form-select" name="patient_id" required>
                    <option value="">-- Choose Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="doctor_id" class="form-label">Select Doctor</label>
                <select class="form-select" name="doctor_id" required>
                    <option value="">-- Choose Doctor --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }} - {{ $doctor->specialization }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="appointment_date" class="form-label">Appointment Date</label>
                <input type="date" class="form-control" name="appointment_date" required>
            </div>

            <div class="mb-3">
                <label for="appointment_time" class="form-label">Appointment Time</label>
                <input type="time" class="form-control" name="appointment_time" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Appointment Status</label>
                <select class="form-select" name="status" required>
                    <option value="Scheduled">Scheduled</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="Declined">Declined</option>
                    <option value="Accepted">Accepted</option>
                </select>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Create Appointment</button>
            </div>
        </form>
    </div>
</div>
@endsection
