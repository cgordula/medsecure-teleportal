@extends('doctors.doctor_layout')

@section('content')
<div class="dashboard-header mb-4">
    <h1>Accepted Appointments</h1>
</div>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4>Accepted Appointments with Meeting Links</h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Appointment Date</th>
                        <th>Patient Name</th>
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
                            <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                            <td>{{ $appointment->message }}</td>
                            <td>
                                @if ($appointment->meeting_link)
                                    <a href="{{ $appointment->meeting_link }}" target="_blank" class="btn btn-info btn-sm">
                                        Join Meeting
                                    </a>
                                @else
                                    <span class="text-muted">No link available</span>
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
</div>
@endsection
