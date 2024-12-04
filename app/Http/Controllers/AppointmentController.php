<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function storeAppointment(Request $request)
    {
        // Validate the input data
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'appointment_time' => 'required|date_format:H:i',
            'reason' => 'required|string|max:500',
            'selected_date' => 'required|date',
        ]);

        // Create a new appointment
        $appointment = new Appointment();
        $appointment->patient_name = $request->patient_name;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->reason = $request->reason;
        $appointment->selected_date = $request->selected_date;
        $appointment->save();

        return redirect()->route('patients.appointment')->with('success', 'Appointment scheduled successfully!');
    }

}
