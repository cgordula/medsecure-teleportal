@extends('patients.patient_layout')

@section('content')
    
    <div class="dashboard-header">
        <h1>Patient Dashboard</h1>
    </div>

    <!-- Health Summary Section -->
    <div class="dashboard-summary">
        <div class="summary-item">
            <h3>Telemedicine Available</h3>
            <p>Online consultations available</p>
        </div>
        <div class="summary-item">
            <h3>Upcoming Appointments</h3>
            <p>2 appointments scheduled</p>
        </div>
        <div class="summary-item">
            <h3>Doctor</h3>
            <p>Dr. Jane Smith</p>
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

        <!-- Telemedicine Section -->
        <div class="telemedicine">
            <h3>Telemedicine Consultations</h3>
            <div class="telemedicine-item">
                <strong>Dr. John Doe</strong>
                <p>March 18, 2024 - 10:00 AM (Virtual)</p>
            </div>
            <div class="telemedicine-item">
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
        <p>Contact: +123 456 7890</p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('patients.create-appointment') }}" class="btn-action">Create Appointment</a>
        <a href="{{ route('patients.profile') }}" class="btn-action">View Profile</a>
    </div>

    
@endsection
