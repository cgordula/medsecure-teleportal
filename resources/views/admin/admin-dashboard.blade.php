@extends('admin.admin_layout')

@section('content')

<div class="dashboard-header">
    <h1>Admin Dashboard</h1>

    
    <!-- Quick Action Buttons -->
    <div class="d-flex flex-wrap gap-3 my-4">
        <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">+ Create Appointment</a>

    </div>
</div>

<!-- First Row: Main Metrics -->
<div class="dashboard-summary row text-center">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="summary-item">
            <h3>Total Patients</h3>
            <p>{{ $totalPatients }}</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="summary-item">
            <h3>Total Doctors</h3>
            <p>{{ $totalDoctors }}</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="summary-item">
            <h3>Upcoming Appointments</h3>
            <p>{{ $upcomingAppointmentsCount }}</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="summary-item">
            <h3>Completed Appointments</h3>
            <p>{{ $completedAppointmentsCount }}</p>
        </div>
    </div>
</div>


<!-- Second Row: Additional Metrics -->
<div class="dashboard-metrics row mt-4">
    <h2>Other Appointment Statuses</h2>
    <div class="metrics-grid">
         <div class="metric-item" style="border-left-color: #28a745;"> <!-- green for accepted -->
            <h3>Accepted by Doctors</h3>
            <p>{{ $acceptedAppointmentsCount }}</p>
        </div>
        <div class="metric-item" style="border-left-color: #dc3545;"> <!-- red for cancelled -->
            <h3>Cancelled by Patients</h3>
            <p>{{ $cancelledAppointmentsCount }}</p>
        </div>
        <div class="metric-item" style="border-left-color: #fd7e14;"> <!-- orange for declined -->
            <h3>Declined by Doctors</h3>
            <p>{{ $declinedAppointmentsCount }}</p>
        </div>
    </div>
</div>


<!-- Time-Based Patient Visits -->
<div class="dashboard-metrics row mt-4">
    <h2>Patient Visits Overview</h2>
    <!-- Patients Today -->
    <div class="col-md-4 col-sm-6 mb-3">
        <div class="card shadow-sm border-0 h-100" style="border-left: 6px solid #17a2b8;">
            <div class="card-body text-center">
                <i class="fas fa-user-check fa-2x mb-2 text-info"></i>
                <h5 class="card-title mb-1">Patients Today</h5>
                <h2 class="fw-bold text-dark">{{ $patientsToday }}</h2>
            </div>
        </div>
    </div>
    <!-- Patients This Week -->
    <div class="col-md-4 col-sm-6 mb-3">
        <div class="card shadow-sm border-0 h-100" style="border-left: 6px solid #28a745;">
            <div class="card-body text-center">
                <i class="fas fa-calendar-week fa-2x mb-2 text-success"></i>
                <h5 class="card-title mb-1">This Week</h5>
                <h2 class="fw-bold text-dark">{{ $patientsThisWeek }}</h2>
            </div>
        </div>
    </div>
    <!-- Patients This Month -->
    <div class="col-md-4 col-sm-6 mb-3">
        <div class="card shadow-sm border-0 h-100" style="border-left: 6px solid #ffc107;">
            <div class="card-body text-center">
                <i class="fas fa-calendar-alt fa-2x mb-2 text-warning"></i>
                <h5 class="card-title mb-1">This Month</h5>
                <h2 class="fw-bold text-dark">{{ $patientsThisMonth }}</h2>
            </div>
        </div>
    </div>
</div>


<div class="dashboard-metrics mt-5 row gx-4 gy-5 justify-content-center align-items-center">
    <!-- Left: Appointment Status Breakdown -->
    <div class="col-12 col-md-5 text-center">
        <h2>Appointment Status Breakdown</h2>
        <div style="max-width: 300px; margin: 0 auto;">
            <canvas id="appointmentStatusChart" style="width: 100%; height: auto;"></canvas>
        </div>
    </div>

    <!-- Vertical Divider -->
    <div class="d-none d-md-block col-md-1 text-center">
        <div style="height: 300px; width: 2px; background-color: #ccc; margin: 0 auto;"></div>
    </div>

    <!-- Right: Doctor Appointment Pie Chart -->
    <div class="col-12 col-md-5 text-center">
        <h2>Top 5 Doctors by Appointments</h2>
        <div style="max-width: 300px; margin: 0 auto;">
            <canvas id="doctorPieChart" style="width: 100%; height: auto;"></canvas>
        </div>
    </div>
</div>


<div class="dashboard-metrics mt-5 text-center">
    <h2>Top 5 Specializations by Appointment Volume</h2>
    <div style="max-width: 600px; margin: 0 auto;">
        <canvas id="specializationChart"></canvas>
    </div>
</div>


<!-- Calendar / Graph Section -->
<div id="realTimeCalendarContainer">
    <div id="realTimeCalendar"></div>
</div>



@endsection
