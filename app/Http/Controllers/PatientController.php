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
        return view('patients.profile');
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