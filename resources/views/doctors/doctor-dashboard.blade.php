@extends('doctors.doctor_layout')

@section('content')
    
    <div class="dashboard-header">
        <h1>Doctor Dashboard</h1>
    </div>

    <!-- Metrics Summary Section -->
    <div class="dashboard-summary">
        <div class="summary-item">
            <h3>Upcoming Appointments</h3>
            <p>
                <a href="#" data-bs-toggle="modal" data-bs-target="#upcomingAppointmentsModal">{{ $upcomingAppointmentsCount }}</a>
            </p>
        </div>
        <div class="summary-item">
            <h3>Telemedicine History</h3>
            <p>
                <a href="#" data-bs-toggle="modal" data-bs-target="#telemedicineHistoryModal">{{ $telemedicineHistoryCount }}</a>
            </p>
        </div>
        <div class="summary-item">
            <h3>Patients</h3>
            <p>
                <a href="#" data-bs-toggle="modal" data-bs-target="#patientModal">{{ $patientCount }}</a>
            </p>
        </div>
    </div>


    <!-- Appointments and Telemedicine -->
    <div class="appointments-section">
        <!-- Upcoming Appointments -->
        <div class="appointments">
            <h3>Upcoming Appointments</h3>
            @forelse ($upcomingAppointments as $appointment)
                <div class="appointment-item">
                    <strong>Dr. {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</strong>
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
                    <strong>Dr. {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</strong>
                    <p>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }} - {{ $appointment->appointment_time }}</p>
                </div>
            @empty
                <p>No completed appointments found.</p>
            @endforelse
        </div>
    </div>


    <div id="realTimeCalendarContainer">
        <div id="realTimeCalendar"></div>
    </div>

    <!-- Modals -->

    <!-- Upcoming Appointments Modal -->
    <div class="modal fade" id="upcomingAppointmentsModal" tabindex="-1" aria-labelledby="upcomingAppointmentsModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="upcomingAppointmentsModalLabel">Upcoming Appointments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @forelse ($upcomingAppointments as $appointment)
                        <div>
                            <strong>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</strong>
                            <p>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }} at {{ $appointment->appointment_time }}</p>
                        </div>
                        <hr>
                    @empty
                        <p>No upcoming appointments.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Telemedicine History Modal -->
    <div class="modal fade" id="telemedicineHistoryModal" tabindex="-1" aria-labelledby="telemedicineHistoryModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="telemedicineHistoryModalLabel">Telemedicine History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @forelse ($appointmentHistory as $appointment)
                        <div>
                            <strong>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</strong>
                            <p>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }} at {{ $appointment->appointment_time }}</p>
                        </div>
                        <hr>
                    @empty
                        <p>No telemedicine history.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Patient Modal -->
    <div class="modal fade" id="patientModal" tabindex="-1" aria-labelledby="patientModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="patientModalLabel">Patients</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $uniquePatients = $upcomingAppointments->pluck('patient')->unique('id');
                    @endphp
                    @forelse ($uniquePatients as $patient)
                        <div>
                            <strong>{{ $patient->first_name }} {{ $patient->last_name }}</strong>
                            <p class="m-0">Birthdate: {{ $appointment->patient->birthdate ? \Carbon\Carbon::parse($appointment->patient->birthdate)->format('F j, Y') : '' }}</p>
                            <p class="m-0">Age: {{ \Carbon\Carbon::parse($appointment->patient->birthdate)->age }} years</p>
                        </div>
                        <hr>
                    @empty
                        <p>No patients associated with your appointments.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection
