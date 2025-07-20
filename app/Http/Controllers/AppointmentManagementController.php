<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Doctor;

class AppointmentManagementController extends Controller
{
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