<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function storeAppointment(Request $request)
    {
        // Ensure the patient is logged in and get their ID
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to book an appointment.');
        }

        // Validate the incoming request data
        $validated = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'doctor' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',  // Optional message
        ]);

        // Create a new appointment record
        $appointment = Appointment::create([
            'patient_id' => auth()->user()->id,  // Use the currently authenticated patient's ID
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'doctor' => $validated['doctor'],
            'status' => 'Scheduled',  // Default to 'Scheduled' status
            'message' => $validated['message'],  // Optional message, can be null
        ]);

        // Redirect back to the appointment page with a success message
        return back()->with('success', 'Appointment booked successfully!');
    }


}
