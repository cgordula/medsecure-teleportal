<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


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

        Patient::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Hash the password before saving
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

        // Attempt login using Auth facade
        if (Auth::guard('patients')->attempt($credentials)) {
            // Login successful, redirect to patient dashboard or home
            return redirect()->route('patients.patient-dashboard');
        }

        // Login failed, redirect back to login form with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email'); // Keep the email input val
    }


    public function patientDashboard()
    {
        return view('patients.patient-dashboard');
    }


    public function patientLogout(Request $request)
    {
        Auth::guard('patients')->logout(); // Log out the patient

        return redirect()->route('patients.login.form')->with('success', 'You have been logged out successfully.');
    }


    // Show the Patient Profile
     public function patientProfile()
     {
         $patient = Auth::guard('patients')->user(); // Get the authenticated patient's data
         
         return view('patients.profile', compact('patient'));
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



    // Show Patient Create Appointment
    public function createAppointment()
    {
        return view('patients.create-appointment');
    }
  



    // Dashboard Metrics
    // public function getDashboardMetrics() {
    //     $userId = Auth::guard('patients')->id();
    
    //     // Current month
    //     $startOfMonth = now()->startOfMonth();
    //     $endOfMonth = now()->endOfMonth();
    
    //     $telemedicineAppointments = Appointment::where('patient_id', $userId)
    //         ->where('type', 'telemedicine')
    //         ->whereBetween('date', [$startOfMonth, $endOfMonth])
    //         ->count();
    
    //     $inPersonAppointments = Appointment::where('patient_id', $userId)
    //         ->where('type', 'in-person')
    //         ->whereBetween('date', [$startOfMonth, $endOfMonth])
    //         ->count();
    
    //     $pendingPrescriptions = Prescription::where('patient_id', $userId)
    //         ->where('status', 'pending')
    //         ->count();
    
    //     $completedConsultations = Consultation::where('patient_id', $userId)
    //         ->where('status', 'completed')
    //         ->whereBetween('date', [$startOfMonth, $endOfMonth])
    //         ->count();
    
    //     return view('patients.patient-dashboard', compact(
    //         'telemedicineAppointments', 
    //         'inPersonAppointments', 
    //         'pendingPrescriptions', 
    //         'completedConsultations'
    //     ));
    // }
    
}