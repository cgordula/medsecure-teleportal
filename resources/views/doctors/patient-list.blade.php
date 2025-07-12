@extends('doctors.doctor_layout')

@section('content')

    <div class="dashboard-header mb-4">
        <h1>Doctor's Patient List</h1>
    </div>

    <div class="container mt-4">

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
                        <tr>
                            <td>John Doe</td>
                            <td>25 Jun 2025, 10:00</td>
                            <td>General Checkup</td>
                            <td class="text-center">
                                <button class="btn btn-success btn-sm">Accept</button>
                                <button class="btn btn-danger btn-sm ms-2">Decline</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>26 Jun 2025, 14:30</td>
                            <td>Follow-up Consultation</td>
                            <td class="text-center">
                                <button class="btn btn-success btn-sm">Accept</button>
                                <button class="btn btn-danger btn-sm ms-2">Decline</button>
                            </td>
                        </tr>
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
                        <tr>
                            <td>Michael Johnson</td>
                            <td>20 Jun 2025, 09:00</td>
                            <td>Dental Checkup</td>
                        </tr>
                        <tr>
                            <td>Lisa Brown</td>
                            <td>22 Jun 2025, 11:15</td>
                            <td>Skin Allergy</td>
                        </tr>
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
                        <tr>
                            <td>Samuel Lee</td>
                            <td>18 Jun 2025, 15:00</td>
                            <td>Eye Checkup</td>
                        </tr>
                        <tr>
                            <td>Emily Davis</td>
                            <td>19 Jun 2025, 13:45</td>
                            <td>Vaccination</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
