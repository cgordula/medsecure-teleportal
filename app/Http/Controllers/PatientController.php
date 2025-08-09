<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalInformation;
use App\Models\EmergencyContact;
use App\Models\Appointment;
use App\Models\Doctor;


class PatientController extends Controller
{
    // Show the registration form
    public function createPatient()
    {
        return view('patients.patient_register');
    }

    // Handle form submission
    public function storePatient(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email', // Ensure the email is unique
            'password' => 'required|confirmed|min:8', // Confirm the password
        ]);

        // Generate unique reference number
        $date = now()->format('Ymd');
        // Get the next sequence number (based on how many patients exist)
        $nextPatientNumber = str_pad(Patient::count() + 1, 4, '0', STR_PAD_LEFT); 
        // Generate the reference number
        $referenceNumber = 'MSP-' . $date . '-' . $nextPatientNumber;
        

        $token = Str::random(60);
        // dd(Patient::count(), $referenceNumber); //debug

        Patient::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Hash the password before saving
            'token' => $token,
            'reference_number' => $referenceNumber,
        ]);


        // return redirect()->back()->with('success', 'Patient registered successfully!');

        session()->flash('success', 'Registration successful! You can now log in.');

        return redirect()->route('patients.login.form');
    }


    // Show the login form
    public function patientLoginForm()
    {
        return view('patients.login');
    }

    // Handle login
    public function patientLogin(Request $request)
    {
        // Validate login request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if "Remember Me" checkbox is selected
        $remember = $request->has('remember');

        // Attempt login using Auth facade
        if (Auth::guard('patients')->attempt($credentials, $remember)) {

            // Login successful, regenerate session and redirect
            $request->session()->regenerate();
            return redirect()->route('patients.patient-dashboard');
        }

        // Login failed, redirect back to login form with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email'); // Keep the email input val
    }


    public function patientDashboard()
    {
        // Get the authenticated patient
        $patient = Auth::guard('patients')->user();

        // Fetch upcoming appointments
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('status', 'Scheduled') // Filter for scheduled appointments
            ->whereDate('appointment_date', '>=', now()) // Appointments in the future or today
            ->orderBy('appointment_date', 'asc') // Sort ascending by date
            ->get();

        // Count upcoming appointments
        $upcomingAppointmentsCount = $upcomingAppointments->count();

         // Fetch past appointments (excluding today)
        $appointmentHistory = Appointment::where('patient_id', $patient->id)
        ->where('status', 'Completed') // Filter for completed appointments
        ->whereDate('appointment_date', '<', now()) // Only past dates
        ->orderBy('appointment_date', 'desc') // Sort descending by date
        ->get();

        // Count telemedicine history (past completed appointments)
        $telemedicineHistoryCount = $appointmentHistory->count();

        // Fetch unique doctors associated with all appointments
        // $uniqueDoctors = $upcomingAppointments->pluck('doctor')->unique('id');
        // $doctorCount = $uniqueDoctors->count();

        // Fetch unique doctors associated with all appointments
        $doctorCount = Appointment::where('patient_id', $patient->id)
            ->distinct('doctor_id')
            ->count('doctor_id');

        $allDoctors = Doctor::whereIn('id', Appointment::where('patient_id', $patient->id)
        ->pluck('doctor_id')
        ->unique())
        ->get();


        // Loop through each appointment and add doctor details
        foreach ($upcomingAppointments as $appointment) {
            // Check if a doctor is associated with the appointment
            if ($appointment->doctor) {
                // Add doctor details to the appointment
                $appointment->specialization = $appointment->doctor->specialization;
                $appointment->license_number = $appointment->doctor->license_number;
            } else {
                // Fallback if no doctor is found
                $appointment->specialization = 'Unknown';
                $appointment->license_number = 'N/A';
            }
        }

        
        // Pass data to the view
        return view('patients.patient-dashboard', compact(
            'upcomingAppointments',
            'appointmentHistory',
            'upcomingAppointmentsCount',
            'telemedicineHistoryCount',
            'doctorCount',
            'allDoctors'
        ));
    }



    public function patientLogout(Request $request)
    {
        Auth::guard('patients')->logout(); // Log out the patient
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('patients.login')->with('success', 'You have been logged out successfully.');
    }


    // Show the Patient Profile
     public function patientProfile()
     {
         $patient = Auth::guard('patients')->user(); // Get the authenticated patient's data
         
         $medicalInfo = MedicalInformation::firstOrNew(['patient_id' => $patient->id]);
         $emergencyContact = $patient->emergency_contact;
     
         // Return the profile view with the necessary data
         return view('patients.profile', compact('patient', 'medicalInfo', 'emergencyContact'));
     }


    // Show Edit Profile Form
    public function editPatientProfile()
    {
        $patient = Auth::guard('patients')->user(); // Get the authenticated patient's data
        return view('patients.edit-profile', compact('patient'));
    }

    // Update the Patient Profile
    public function updatePatientProfile(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . Auth::guard('patients')->id(), // Ensure unique email, except for the logged-in patient
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'birthdate' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        // Get the authenticated patient
        $patient = Auth::guard('patients')->user();


        // Handle photo upload
        if ($request->hasFile('profile_picture')) {
            // Get the original file name
            $originalFileName = $request->file('profile_picture')->getClientOriginalName();
            
            // Optionally, you could append a unique identifier to prevent name conflicts
            // e.g., using the time as a unique prefix or a random string
            $newFileName = time() . '_' . $originalFileName;
        
            // Store the file in the 'public/patient_photos' directory and save the new file name
            $photoPath = $request->file('profile_picture')->storeAs('public/patient_photos', $newFileName);
            
            // Save just the file name in the database
            $validatedData['profile_picture'] = $newFileName;
        }
        
    
        // Calculate the patient's age from the birthdate
        if ($request->has('birthdate') && $request->birthdate) {
            $birthdate = \Carbon\Carbon::parse($request->birthdate);
            $age = $birthdate->age;  // Calculate age
            $validatedData['age'] = $age;  // Store age
        }      

        // Update patient information
        $patient->update($validatedData);

        // Return to the profile page with a success message
        return redirect()->route('patients.profile')->with('success', 'Profile updated successfully!');
    }


    // Update medical information
    public function updateMedicalInfo(Request $request)
    {
        $patient = auth()->guard('patients')->user();

        $medicalInfo = MedicalInformation::firstOrNew(['patient_id' => $patient->id]);

        // Validate inputs here as needed (for simplicity, omitted)

        // Store JSON or arrays as JSON strings
        $medicalInfo->medical_history = $request->input('medical_history');
        $medicalInfo->current_medications = $request->input('current_medications');
        $medicalInfo->allergies = $request->input('allergies');
        $medicalInfo->primary_complaint = $request->input('primary_complaint');
        $medicalInfo->consultation_notes = $request->input('consultation_notes');
        $medicalInfo->diagnoses = $request->input('diagnoses');
        $medicalInfo->prescriptions = $request->input('prescriptions');
        $medicalInfo->body_measures = $request->input('body_measures');
        $medicalInfo->patient_id = $patient->id;

        $medicalInfo->save();

        return redirect()->back()->with('success', 'Medical information updated successfully.');
    }


    public function myAppointments()
    {
        $patient = Auth::guard('patients')->user();

        // Automatically decline outdated scheduled appointments
        Appointment::where('patient_id', $patient->id)
            ->where('status', 'Scheduled')
            ->where('appointment_date', '<', Carbon::today())
            ->update(['status' => 'Declined']);

        $scheduledAppointments = Appointment::with('doctor')
            ->where('patient_id', $patient->id)
            ->where('status', 'Scheduled')
            ->where('appointment_date', '>=', Carbon::today()) // optional: only future or today
            ->orderBy('appointment_date', 'asc')
            ->get();        
        
        // Fetch accepted appointments
        $acceptedAppointments = Appointment::with('doctor')
            ->where('patient_id', $patient->id)
            ->where('status', 'Accepted')
            ->orderBy('appointment_date', 'asc')
            ->get();
        
        // Fetch declined appointments
        $declinedAppointments = Appointment::with('doctor')
            ->where('patient_id', $patient->id)
            ->where('status', 'Declined')
            ->orderBy('appointment_date', 'asc')
            ->get();

        $cancelledAppointments = Appointment::with('doctor')
            ->where('patient_id', $patient->id)
            ->where('status', 'Cancelled')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('patients.my-appointments', compact('scheduledAppointments', 'acceptedAppointments', 'declinedAppointments', 'cancelledAppointments'));
    }


    public function cancelAppointment($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('patient_id', Auth::guard('patients')->id())
            ->where('status', 'Scheduled')
            ->firstOrFail();

        $appointment->status = 'Cancelled';
        $appointment->save();

        return redirect()->route('patients.my-appointments')->with('success', 'Appointment cancelled successfully.');
    }



    public function techSupport()
    {
        $patient = Auth::guard('patients')->user(); // Get the authenticated patient's data
        return view('patients.tech-support', compact('patient'));
    }

    
}