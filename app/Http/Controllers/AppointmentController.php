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
        $patient = auth()->user();

        // Ensure the patient is logged in and get their ID
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to book an appointment.');
        }

        if (empty($patient->first_name) && empty($patient->last_name) && empty($patient->phone) && empty($patient->email) && empty($patient->birthdate) && empty($patient->country)) {
            // Redirect to profile page with a message to complete their profile
            return redirect()->route('patients.store-appointment')->with('warning', 'Please complete your profile information before booking an appointment.');
        }

        // Validate the incoming request data (basic format)
        $validated = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'doctor_id' => 'required|exists:doctors,id',
            'message' => 'nullable|string|max:1000',
        ]);

        // Combine date and time to form full datetime
        $appointmentDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $validated['appointment_date'] . ' ' . $validated['appointment_time']);

        // Ensure it is at least 48 hours from now
        if ($appointmentDateTime->lt(now()->addHours(48))) {
            return back()->with('warning', 'Appointments must be booked at least 48 hours in advance.')
                        ->withInput();
        }

        // Create a new appointment record
        $appointment = Appointment::create([
            'patient_id' => auth()->user()->id,  // Use the currently authenticated patient's ID
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'doctor_id' => $validated['doctor_id'],
            'status' => 'Scheduled',  // Default to 'Scheduled' status
            'message' => $validated['message'],  // Optional message, can be null
        ]);

        // Redirect back to the appointment page with a success message
        return back()->with('success', 'Appointment booked successfully!');
    }


    // Show all appointments (Admin View)
    public function index(Request $request)
    {
        $sortField = $request->get('sort_by', 'appointment_date');
        $sortDirection = $request->get('sort_dir', 'asc');

        $allowedSorts = [
            'appointment_date' => 'appointments.appointment_date',
            'appointment_time' => 'appointments.appointment_time',
            'status' => 'appointments.status',
        ];

        if ($sortField === 'patient_name') {
            $orderColumn = DB::raw("CONCAT(patients.first_name, ' ', patients.last_name)");
        } elseif ($sortField === 'doctor_name') {
            $orderColumn = DB::raw("CONCAT(doctors.first_name, ' ', doctors.last_name)");
        } else {
            $orderColumn = $allowedSorts[$sortField] ?? 'appointments.appointment_date';
        }

        $appointments = Appointment::select('appointments.*')
            ->leftJoin('patients', 'appointments.patient_id', '=', 'patients.id')
            ->leftJoin('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            ->orderBy($orderColumn, $sortDirection)
            ->with(['patient', 'doctor'])
            ->paginate(10)
            ->appends(['sort_by' => $sortField, 'sort_dir' => $sortDirection]);

        return view('admin.appointments.index', compact('appointments', 'sortField', 'sortDirection'));
    }

    // Admin - Edit
    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    // Admin - Delete
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted successfully.');
    }

    // Admin - Update
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'sometimes|exists:patients,id',
            'doctor_id' => 'sometimes|exists:doctors,id',
            'appointment_date' => 'sometimes|date',
            'appointment_time' => 'sometimes',
            'status' => 'sometimes|string',
            'message' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment updated successfully.');
    }


 

}
