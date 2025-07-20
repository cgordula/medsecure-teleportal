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

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>{!! sortLink('reference_number', 'Patient Ref. No.', $sortField ?? '', $sortDirection ?? '') !!}</th>
                <th>{!! sortLink('first_name', 'First Name', $sortField ?? '', $sortDirection ?? '') !!}</th>
                <th>{!! sortLink('last_name', 'Last Name', $sortField ?? '', $sortDirection ?? '') !!}</th>
                <th>{!! sortLink('email', 'Email', $sortField ?? '', $sortDirection ?? '') !!}</th>
                <th>{!! sortLink('gender', 'Gender', $sortField ?? '', $sortDirection ?? '') !!}</th>
                <th>{!! sortLink('birthdate', 'Birthdate', $sortField ?? '', $sortDirection ?? '') !!}</th>
                <th>{!! sortLink('phone', 'Phone', $sortField ?? '', $sortDirection ?? '') !!}</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->reference_number }}</td>
                    <td>{{ $patient->first_name }}</td>
                    <td>{{ $patient->last_name }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ $patient->birthdate ? \Carbon\Carbon::parse($patient->birthdate)->format('j F Y') : '' }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>
                        <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-sm btn-primary">Edit</a>

                        <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this patient?');">
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
        {{ $patients->links() }}
    </div>
</div>
@endsection
