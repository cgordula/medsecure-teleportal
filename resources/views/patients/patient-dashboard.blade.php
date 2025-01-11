@extends('patients.patient_layout')

@section('content')
    
    <div class="dashboard-header">
        <h1>Patient Dashboard</h1>
    </div>

    <!-- Health Summary Section -->
    <div class="dashboard-summary">
        <div class="summary-item">
            <h3>Upcoming Appointments</h3>
            <p>{{ $upcomingAppointmentsCount }}</p>
        </div>
        <div class="summary-item">
            <h3>Telemedicine History</h3>
            <p>{{ $telemedicineHistoryCount }}</p>
        </div>
        <div class="summary-item">
            <h3>Doctor</h3>
            <p>{{ $doctorCount }}</p>
        </div>
    </div>

    <!-- <div class="dashboard-metrics">
        <h2>Monthly Metrics</h2>
        <div class="metrics-grid">
            <div class="metric-item">
                <h3>Month-to-Date Appointments</h3>
                <p>2</p>
            </div>
            <div class="metric-item">
                <h3>Different Doctors Consulted</h3>
                <p>5</p>
            </div>
            <div class="metric-item">
                <h3>Telemedicine Sessions</h3>
                <p>6</p>
            </div>
        </div>
    </div> -->

    <!-- Appointments and Telemedicine -->
    <div class="appointments-section">
        <!-- Upcoming Appointments -->
        <div class="appointments">
            <h3>Upcoming Appointments</h3>
            @forelse ($upcomingAppointments as $appointment)
                <div class="appointment-item">
                    <strong>Dr. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</strong>
                    <p>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }} - {{ $appointment->appointment_time }}</p>
                </div>
            @empty
                <p>No upcoming appointments.</p>
            @endforelse
        </div>

        <!-- History Section -->
        <div class="history">
            <h3>History Summary</h3>
            @forelse ($appointmentHistory as $appointment)
                <div class="history-item">
                    <strong>Dr. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</strong>
                    <p>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }} - {{ $appointment->appointment_time }}</p>
                </div>
            @empty
                <p>No completed appointments found.</p>
            @endforelse
        </div>
    </div>

    <!-- Doctor Info -->
    @if ($upcomingAppointments->isNotEmpty())
        @foreach ($upcomingAppointments as $appointment)
            <div class="doctor-info">
                <h3>Your Doctor</h3>
                <strong>Dr. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</strong>
                <p>Specialty: {{ $appointment->specialization }}</p>
                <p>License No.: {{ $appointment->license_number }}</p>
            </div>
        @endforeach
    @else
        <div class="doctor-info">
            <h3>Your Doctor</h3>
            <p>No doctor information available for upcoming appointments.</p>
        </div>
    @endif



    <!-- Quick Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('patients.appointment') }}" class="btn-action">Create Appointment</a>
        <a href="{{ route('patients.profile') }}" class="btn-action">View Profile</a>
    </div>


    <div id="realTimeCalendarContainer">
        <div id="realTimeCalendar"></div>
    </div>



    
@endsection
