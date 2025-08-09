<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Doctor;


class AppointmentController extends Controller
{

    
    // Show Patient Create Appointment
    public function createAppointment()
    {
        $doctors = Doctor::all(); // Fetch all doctors from the doctors table
        return view('patients.create-appointment', compact('doctors'));
    }
  
    public function storeAppointment(Request $request)
    {
        // Ensure patient is logged in and get authenticated user
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to book an appointment.');
        }

        $patient = auth()->user();

        // Check required profile fields
        $requiredFields = [
            'first_name', 'last_name', 'phone', 'email', 'birthdate', 'country',
            'address_line1', 'city', 'postal_code'
        ];
        foreach ($requiredFields as $field) {
            if (empty($patient->$field)) {
                return redirect()->route('patients.profile')->with('warning', "Please complete your profile information (missing: $field) before booking an appointment.");
            }
        }

        // Check emergency contact completeness
        if (!$patient->emergency_contact || empty($patient->emergency_contact->name) || empty($patient->emergency_contact->relationship) || empty($patient->emergency_contact->phone)) {
            return redirect()->route('patients.profile')->with('warning', 'Please complete your emergency contact information before booking an appointment.');
        }

        // Validate incoming request data
        $validated = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'doctor_id' => 'required|exists:doctors,id',
            'message' => 'nullable|string|max:1000',
        ]);

        // Combine date and time
        $appointmentDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $validated['appointment_date'] . ' ' . $validated['appointment_time']);

        // Ensure booking at least 48 hours ahead
        if ($appointmentDateTime->lt(now()->addHours(48))) {
            return back()->with('warning', 'Appointments must be booked at least 48 hours in advance.')->withInput();
        }

        // Create appointment
        Appointment::create([
            'patient_id' => $patient->id,
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'doctor_id' => $validated['doctor_id'],
            'status' => 'Scheduled',
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Appointment booked successfully!');
    }


}
