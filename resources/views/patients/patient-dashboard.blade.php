@extends('patients.patient_layout')

@section('content')
    
    <div class="dashboard-header">
        <h1>Patient Dashboard</h1>
    </div>

    <!-- Health Summary Section -->
    <div class="dashboard-summary">
        <div class="summary-item">
            <h3>Upcoming Appointments</h3>
            <p>2</p>
        </div>
        <div class="summary-item">
            <h3>Telemedicine History</h3>
            <p>1</p>
        </div>
        <div class="summary-item">
            <h3>Doctor</h3>
            <p>1</p>
        </div>
    </div>

    <div class="dashboard-metrics">
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
    </div>

    <!-- Appointments and Telemedicine -->
    <div class="appointments-section">
        <!-- Upcoming Appointments -->
        <div class="appointments">
            <h3>Upcoming Appointments</h3>
            <div class="appointment-item">
                <strong>Dr. John Doe</strong>
                <p>March 15, 2024 - 2:00 PM</p>
            </div>
            <div class="appointment-item">
                <strong>Dr. Jane Smith</strong>
                <p>March 20, 2024 - 9:00 AM</p>
            </div>
        </div>

        <!-- History Section -->
        <div class="history">
            <h3>History Summary</h3>
            <div class="history-item">
                <strong>Dr. John Doe</strong>
                <p>March 18, 2024 - 10:00 AM (Virtual)</p>
            </div>
            <div class="history-item">
                <strong>Dr. Jane Smith</strong>
                <p>March 22, 2024 - 11:00 AM (Virtual)</p>
            </div>
        </div>
    </div>

    <!-- Doctor Info -->
    <div class="doctor-info">
        <h3>Your Doctor</h3>
        <p><strong>Dr. Jane Smith</strong></p>
        <p>Specialty: Internal Medicine</p>
        <p>License No.: 12345678</p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('patients.create-appointment') }}" class="btn-action">Create Appointment</a>
        <a href="{{ route('patients.profile') }}" class="btn-action">View Profile</a>
    </div>


    <div id="realTimeCalendarContainer">
        <div id="realTimeCalendar"></div>
    </div>



    
@endsection
