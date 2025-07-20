@extends('admin.admin_layout')

@section('content')
<div class="container mt-4">
    <h2>All Doctors</h2>

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
                <th>Ref. No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Specialization</th>
                <th>License No.</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doctors as $doctor)
                <tr>
                    <td>{{ $doctor->reference_number }}</td>
                    <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->phone }}</td>
                    <td>{{ $doctor->specialization }}</td>
                    <td>{{ $doctor->license_number }}</td>
                    <td>
                        <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
