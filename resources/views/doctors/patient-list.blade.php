@extends('doctors.doctor_layout')

@section('content')

    <div class="dashboard-header mb-4">
        <h1>Doctor's Patient List</h1>
    </div>

    <div class="container mt-4">

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

        {{-- Scheduled Appointments --}}
        <div class="card mb-5 shadow">
            <div class="card-header bg-primary text-white">
                <h4>Scheduled Appointment Requests</h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Appointment Date</th>
                            <th>Reason</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($scheduledAppointments as $appointment)
                            <tr>
                                <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }},
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </td>
                                <td>{{ $appointment->message }}</td>
                                <td class="text-center d-flex justify-content-center">
                                    {{-- Accept Form --}}
                                    <form action="{{ route('appointments.updateStatus') }}" method="POST" class="me-2">
                                        @csrf
                                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                        <input type="hidden" name="status" value="Accepted">
                                        <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                    </form>

                                    {{-- Decline Form --}}
                                    <form action="{{ route('appointments.updateStatus') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                        <input type="hidden" name="status" value="Declined">
                                        <button type="submit" class="btn btn-danger btn-sm">Decline</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No scheduled appointments.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        {{-- Accepted Patients --}}
        <div class="card mb-5 shadow">
            <div class="card-header bg-success text-white">
                <h4>Accepted Patients</h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Appointment Date</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($acceptedAppointments as $appointment)
                            <tr>
                                <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }},
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </td>
                                <td>{{ $appointment->message }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No accepted appointments.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Declined Patients --}}
        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h4>Declined Patients</h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Appointment Date</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($declinedAppointments as $appointment)
                            <tr>
                                <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }},
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </td>
                                <td>{{ $appointment->message }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No declined appointments.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Cancelled Patients --}}
        <div class="card shadow mt-4">
            <div class="card-header bg-warning text-white">
                <h4>Cancelled Patients</h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Appointment Date</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cancelledAppointments as $appointment)
                            <tr>
                                <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }},
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </td>
                                <td>{{ $appointment->message }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No cancelled appointments.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


    </div>

@endsection
