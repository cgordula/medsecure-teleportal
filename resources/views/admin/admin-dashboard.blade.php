@extends('admin.admin_layout')

@section('content')

<div class="dashboard-header mb-4">
    <h1 class="fw-bold">📊 Admin Dashboard</h1>
    <p class="text-muted">Overview of your clinic’s key metrics, appointments, and performance trends.</p>

    <!-- Quick Action Buttons -->
    <div class="d-flex flex-wrap gap-2 mt-3">
        <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Create Appointment
        </a>
    </div>
</div>

<!-- Top KPI Cards -->
<div class="row g-3 mb-4">
    @php
        $kpis = [
            ['title' => 'Total Patients', 'value' => $totalPatients, 'icon' => 'fas fa-users', 'color' => '#17a2b8'],
            ['title' => 'Total Doctors', 'value' => $totalDoctors, 'icon' => 'fas fa-user-md', 'color' => '#28a745'],
            ['title' => 'Upcoming Appointments', 'value' => $upcomingAppointmentsCount, 'icon' => 'fas fa-calendar-day', 'color' => '#ffc107'],
            ['title' => 'Completed Appointments', 'value' => $completedAppointmentsCount, 'icon' => 'fas fa-check-circle', 'color' => '#6f42c1'],
        ];
    @endphp

    @foreach($kpis as $kpi)
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100" style="border-left: 6px solid {{ $kpi['color'] }};">
                <div class="card-body text-center">
                    <i class="{{ $kpi['icon'] }} fa-2x mb-2" style="color: {{ $kpi['color'] }}"></i>
                    <h6 class="text-muted">{{ $kpi['title'] }}</h6>
                    <h2 class="fw-bold">{{ $kpi['value'] }}</h2>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Status Overview -->
<h4 class="mt-4">📅 Appointment Status Overview</h4>
<div class="row g-3 mb-4">
    @php
        $statuses = [
            ['title' => 'Accepted by Doctors', 'value' => $acceptedAppointmentsCount, 'color' => '#28a745', 'icon' => 'fas fa-thumbs-up'],
            ['title' => 'Cancelled by Patients', 'value' => $cancelledAppointmentsCount, 'color' => '#dc3545', 'icon' => 'fas fa-times-circle'],
            ['title' => 'Declined by Doctors', 'value' => $declinedAppointmentsCount, 'color' => '#fd7e14', 'icon' => 'fas fa-ban'],
        ];
    @endphp

    @foreach($statuses as $status)
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 h-100" style="border-left: 6px solid {{ $status['color'] }};">
                <div class="card-body text-center">
                    <i class="{{ $status['icon'] }} fa-2x mb-2" style="color: {{ $status['color'] }}"></i>
                    <h6 class="text-muted">{{ $status['title'] }}</h6>
                    <h2 class="fw-bold">{{ $status['value'] }}</h2>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Patient Visits -->
<h4 class="mt-5">👥 Patient Visits</h4>
<div class="row g-3">
    @php
        $visits = [
            ['title' => 'Today', 'value' => $patientsToday, 'color' => '#17a2b8', 'icon' => 'fas fa-calendar-day'],
            ['title' => 'This Week', 'value' => $patientsThisWeek, 'color' => '#28a745', 'icon' => 'fas fa-calendar-week'],
            ['title' => 'This Month', 'value' => $patientsThisMonth, 'color' => '#ffc107', 'icon' => 'fas fa-calendar-alt'],
        ];
    @endphp

    @foreach($visits as $visit)
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 h-100" style="border-left: 6px solid {{ $visit['color'] }};">
                <div class="card-body text-center">
                    <i class="{{ $visit['icon'] }} fa-2x mb-2" style="color: {{ $visit['color'] }}"></i>
                    <h6 class="text-muted">{{ $visit['title'] }}</h6>
                    <h2 class="fw-bold">{{ $visit['value'] }}</h2>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Charts Section -->
<div class="row g-4 mt-5">
    <div class="col-md-6 text-center">
        <h5>📊 Appointment Status Breakdown</h5>
        <canvas id="appointmentStatusChart" style="max-height: 300px;"></canvas>
    </div>
    <div class="col-md-6 text-center">
        <h5>🏆 Top 5 Doctors by Appointments</h5>
        <canvas id="doctorPieChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<!-- Specialization Chart -->
<div class="mt-5 text-center">
    <h5>🏥 Top 5 Specializations by Appointment Volume</h5>
    <canvas id="specializationChart" style="max-height: 350px;"></canvas>
</div>

<!-- Calendar -->
<div class="mt-5">
    <h5>🗓 Real-Time Appointment Calendar</h5>
    <div id="realTimeCalendar"></div>
</div>

@endsection
