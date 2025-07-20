@extends('admin.admin_layout')

@section('content')

<div class="dashboard-header">
    <h1>Appointments</h1>
</div>

@if (session('success'))
    <div id="success-message" class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div id="error-message" class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="container">
    @if($appointments->count())
        <table class="table table-bordered">
            @php
                function sortLink($field, $label, $currentSortField, $currentSortDir) {
                    $dir = ($currentSortField === $field && $currentSortDir === 'asc') ? 'desc' : 'asc';
                    $arrow = '';

                    if ($currentSortField === $field) {
                        $arrow = $currentSortDir === 'asc' ? '↑' : '↓';
                    }

                    $url = request()->fullUrlWithQuery(['sort_by' => $field, 'sort_dir' => $dir]);
                    return "<a href=\"$url\" style=\"text-decoration: none; color: inherit;\">$label $arrow</a>";
                }
            @endphp

            <thead>
                <tr>
                    <th>{!! sortLink('patient_name', 'Patient', $sortField ?? '', $sortDirection ?? '') !!}</th>
                    <th>{!! sortLink('doctor_name', 'Doctor', $sortField ?? '', $sortDirection ?? '') !!}</th>
                    <th>{!! sortLink('appointment_date', 'Date', $sortField ?? '', $sortDirection ?? '') !!}</th>
                    <th>{!! sortLink('appointment_time', 'Time', $sortField ?? '', $sortDirection ?? '') !!}</th>
                    <th>{!! sortLink('status', 'Status', $sortField ?? '', $sortDirection ?? '') !!}</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                        <td>{{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
                        <td>{{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('j F Y') : '' }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                        <td>{{ $appointment->status }}</td>
                        <td>{{ $appointment->message ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-sm btn-primary">Edit</a>

                            <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $appointments->links() }}
        </div>
    @else
        <p>No appointments found.</p>
    @endif
</div>
@endsection
