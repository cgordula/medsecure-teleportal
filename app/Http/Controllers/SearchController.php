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

        // Parse query to date format Y-m-d if possible
        try {
            $parsedDate = \Carbon\Carbon::parse($query)->format('Y-m-d');
        } catch (\Exception $e) {
            $parsedDate = null;
        }

        // Patients: name, email, or reference_number
        $patients = Patient::where('first_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('reference_number', 'like', "%$query%")
            ->paginate(10);

        // Appointments: ID, date, or status
        $appointments = Appointment::where('id', $query)
            ->orWhere('status', 'like', "%$query%");

        if ($parsedDate) {
            $appointments = $appointments->orWhere('appointment_date', $parsedDate);
        } else {
            // If not a valid date, you can skip or add any fallback search
            $appointments = $appointments->orWhere('appointment_date', 'like', "%$query%");
        }

        $appointments = $appointments->paginate(10);

        // Doctors: first name, last name, specialization, email, reference_number
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
