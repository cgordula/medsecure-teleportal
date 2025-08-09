@extends('patients.patient_layout')

@section('content')

<div class="dashboard-header mb-4">
    <h1>My Appointments</h1>
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
            <h4>Scheduled Appointments</h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Appointment Date</th>
                        <th>Doctor</th>
                        <th>Reason</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($scheduledAppointments as $appointment)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }},
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                            </td>
                            <td>{{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
                            <td>{{ $appointment->message }}</td>
                            <td class="text-center">
                                <form action="{{ route('patients.cancel-appointment', $appointment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
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

    {{-- Accepted Appointments --}}
    <div class="card mb-5 shadow">
        <div class="card-header bg-success text-white">
            <h4>Accepted Appointments</h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>Appointment Date</th>
                        <th>Doctor</th>
                        <th>Reason</th>
                        <th>Meeting Link</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($acceptedAppointments as $appointment)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }},
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                            </td>
                            <td>{{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
                            <td>{{ $appointment->message }}</td>
                            <td>
                                @if (!empty($appointment->meeting_link))
                                    <a href="{{ $appointment->meeting_link }}" target="_blank" class="btn btn-info btn-sm">
                                        Join Meeting
                                    </a>
                                @else
                                    <span class="text-muted">No meeting link available</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No accepted appointments.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Declined Appointments --}}
    <div class="card mb-5 shadow">
        <div class="card-header bg-danger text-white">
            <h4>Declined Appointments</h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>Appointment Date</th>
                        <th>Doctor</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($declinedAppointments as $appointment)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }},
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                            </td>
                            <td>{{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
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

    {{-- Cancelled Appointments --}}
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h4>Cancelled Appointments</h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>Appointment Date</th>
                        <th>Doctor</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cancelledAppointments as $appointment)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }},
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                            </td>
                            <td>{{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
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
