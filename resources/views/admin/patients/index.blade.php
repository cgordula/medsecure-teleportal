@extends('admin.admin_layout')

@section('content')
<div class="dashboard-header">
    <h1>All Patients</h1>
</div>

<div class="container mt-4">
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

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>Patient Ref. No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Birthdate</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->reference_number }}</td>
                    <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ $patient->birthdate ? \Carbon\Carbon::parse($patient->birthdate)->format('j F Y') : '' }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>
                        <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
