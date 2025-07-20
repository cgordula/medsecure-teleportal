@extends('admin.admin_layout')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Search Results for: "{{ $query }}"</h3>

    @if($patients->isEmpty() && $doctors->isEmpty() && $appointments->isEmpty() && $admins->isEmpty())
        <div class="alert alert-warning">No results found.</div>
    @endif

    {{-- Patients --}}
    @if(!$patients->isEmpty())
        <h5 class="mt-4">Patients</h5>
        <div class="row">
            @foreach($patients as $patient)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="card-title">{{ $patient->first_name }} {{ $patient->last_name }}</h6>
                            <p class="mb-0"><i class="fas fa-envelope me-1"></i>{{ $patient->email }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Appointments --}}
    @if(!$appointments->isEmpty())
        <h5 class="mt-4">Appointments</h5>
        <ul class="list-group mb-4">
            @foreach($appointments as $appt)
                <li class="list-group-item">
                    <strong>ID:</strong> {{ $appt->id }}<br>
                    <strong>Date:</strong> {{ $appt->appointment_date }}<br>
                    <strong>Time:</strong> {{ $appt->appointment_time }}
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Doctors --}}
    @if(!$doctors->isEmpty())
        <h5 class="mt-4">Doctors</h5>
        <div class="row">
            @foreach($doctors as $doctor)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="card-title">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h6>
                            <p class="mb-0"><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                            <p class="mb-0"><i class="fas fa-envelope me-1"></i>{{ $doctor->email }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Admins --}}
    @if(!$admins->isEmpty())
        <h5 class="mt-4">Admin Results</h5>
        <div class="row">
            @foreach($admins as $admin)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="card-title">{{ $admin->first_name }} {{ $admin->last_name }}</h6>
                            <p class="mb-0"><i class="fas fa-envelope me-1"></i>{{ $admin->email }}</p>
                            @if(!empty($admin->role))
                                <span class="badge bg-primary mt-2">{{ ucfirst($admin->role) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
