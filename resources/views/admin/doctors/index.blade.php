@extends('admin.admin_layout')

@section('content')
<div class="dashboard-header">
    <h1>All Doctors</h1>
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
            <th>{!! sortLink('reference_number', 'Ref. No.', $sortField ?? '', $sortDirection ?? '') !!}</th>
            <th>{!! sortLink('first_name', 'First Name', $sortField ?? '', $sortDirection ?? '') !!}</th>
            <th>{!! sortLink('last_name', 'Last Name', $sortField ?? '', $sortDirection ?? '') !!}</th>
            <th>{!! sortLink('email', 'Email', $sortField ?? '', $sortDirection ?? '') !!}</th>
            <th>{!! sortLink('phone', 'Phone', $sortField ?? '', $sortDirection ?? '') !!}</th>
            <th>{!! sortLink('specialization', 'Specialization', $sortField ?? '', $sortDirection ?? '') !!}</th>
            <th>{!! sortLink('license_number', 'License No.', $sortField ?? '', $sortDirection ?? '') !!}</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($doctors as $doctor)
            <tr>
                <td>{{ $doctor->reference_number }}</td>
                <td>{{ $doctor->first_name }}</td>
                <td>{{ $doctor->last_name }}</td>
                <td>{{ $doctor->email }}</td>
                <td>{{ $doctor->phone }}</td>
                <td>{{ $doctor->specialization }}</td>
                <td>{{ $doctor->license_number }}</td>
                <td>
                    <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-primary">Edit</a>

                    <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this doctor?');">
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
    {{ $doctors->links() }}
</div>

</div>
@endsection
