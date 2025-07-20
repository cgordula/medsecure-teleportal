<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Patients: name or email
        $patients = Patient::where('first_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('reference_number', 'like', "%$query%")
            ->paginate(10);

        // Appointments: ID or date
        $appointments = Appointment::where('id', $query)
            ->orWhere('appointment_date', 'like', "%$query%")
            ->orWhere('status', 'like', "%$query%")
            ->paginate(10);

        // Doctors: first name, last name, or specialization
        $doctors = Doctor::where('first_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")
            ->orWhere('specialization', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('reference_number', 'like', "%$query%")
            ->paginate(10);

        // Admins: first name, last name, or email
        $admins = Admin::where('first_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->paginate(10);

        return view('admin.search-results', compact('query', 'patients', 'appointments', 'doctors', 'admins'));
    }
}
