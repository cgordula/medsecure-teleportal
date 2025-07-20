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
            ->get();

        // Appointments: ID or date
        $appointments = Appointment::where('id', $query)
            ->orWhere('appointment_date', 'like', "%$query%")
            ->orWhere('status', 'like', "%$query%")
            ->get();


        // Doctors: first name, last name, or specialization
        $doctors = Doctor::where('first_name', 'like', "%$query%")
        ->orWhere('last_name', 'like', "%$query%")
        ->orWhere('specialization', 'like', "%$query%")
        ->orWhere('email', 'like', "%$query%")
        ->orWhere('reference_number', 'like', "%$query%")
        ->get();

        // Admins: first name, last name, or email
        $admins = Admin::where('first_name', 'like', "%$query%")
        ->orWhere('last_name', 'like', "%$query%")
        ->orWhere('email', 'like', "%$query%")
        ->get();

        return view('admin.search-results', compact('query', 'patients', 'appointments', 'doctors', 'admins'));
    }
}
