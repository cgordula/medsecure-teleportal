@extends('admin.admin_layout')

@section('content')

<div class="dashboard-header">
    <h1>Admin Dashboard</h1>
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
<div class="dashboard-metrics">
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
