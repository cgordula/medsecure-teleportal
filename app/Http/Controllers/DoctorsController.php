<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalInformation;
use App\Models\EmergencyContact;
use App\Models\Appointment;
use App\Models\Patient;

class DoctorsController extends Controller
{

    public function createDoctor()
    {
        return view('doctors.doctor_register');
    }

    public function storeDoctor(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:doctors',
            'password' => 'required|string|min:8|confirmed',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
        ]);


        Doctor::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Hash the password before saving
            'specialization' => $validatedData['specialization'], // Add specialization
            'license_number' => $validatedData['license_number'], // Add license number
            'role' => 'doctor', // Default role for doctors
        ]);

        session()->flash('success', 'Registration successful! You can now log in.');
        return redirect()->route('doctors.login.form');
    }


    // Show the login form
    public function doctorLoginForm()
    {
        return view('doctors.login'); 
    }

    // Handle login
    public function doctorLogin(Request $request)
    {
        // Validate login request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if "Remember Me" checkbox is selected
        $remember = $request->has('remember');


        // Attempt login using Auth facade
        if (Auth::guard('doctors')->attempt($credentials)) {
            // Login successful, redirect to patient dashboard or home
            $request->session()->regenerate();
            return redirect()->route('doctors.doctor-dashboard');
        }

        // Login failed, redirect back to login form with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email'); // Keep the email input val
    }


    public function doctorDashboard()
    {
        // Get the authenticated patient
        $doctor = Auth::guard('doctors')->user();

         // Fetch upcoming appointments for the authenticated doctor
        $upcomingAppointments = Appointment::with('patient') // Eager-load patient relationship
        ->where('doctor_id', $doctor->id)
        ->where('status', 'Scheduled') // Only scheduled appointments
        ->whereDate('appointment_date', '>', now()) // Appointments in the future
        ->orderBy('appointment_date', 'asc') // Sort by date ascending
        ->get();

        // Count upcoming appointments
        $upcomingAppointmentsCount = $upcomingAppointments->count();

        // Fetch past completed appointments
        $appointmentHistory = Appointment::with('patient') // Eager-load patient relationship
        ->where('doctor_id', $doctor->id)
        ->where('status', 'Completed') // Only completed appointments
        ->whereDate('appointment_date', '<', now()) // Past appointments only
        ->orderBy('appointment_date', 'desc') // Sort by date descending
        ->get();

        // Count telemedicine history (past completed appointments)
        $telemedicineHistoryCount = $appointmentHistory->count();

        // Fetch unique patients associated with all appointments
        $patientCount = Appointment::where('doctor_id', $doctor->id)
            ->distinct('patient_id')
            ->count('patient_id');

        
        // Pass data to the view
        return view('doctors.doctor-dashboard', compact(
            'upcomingAppointments',
            'appointmentHistory',
            'upcomingAppointmentsCount',
            'telemedicineHistoryCount',
            'patientCount'
        ));
    }


    public function doctorLogout(Request $request)
    {
        Auth::guard('doctors')->logout(); // Log out the doctor
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('doctors.login.form')->with('success', 'You have been logged out successfully.');
    }


    // Show the Patient Profile
    public function doctorProfile()
    {
        $doctor = Auth::guard('doctors')->user(); // Get the authenticated doctors's data
        
       
        // Return the profile view with the necessary data
        return view('doctors.profile', compact('doctor'));
    }


   // Show Edit Profile Form
   public function editDoctorProfile()
   {
       $doctor = Auth::guard('doctors')->user(); // Get the authenticated doctors's data
       return view('doctors.edit-profile', compact('doctor'));
   }

   // Update the Doctor's Profile
   public function updateDoctorProfile(Request $request)
   {
       // Validate the incoming data
       $validatedData = $request->validate([
           'first_name' => 'required|string|max:255',
           'last_name' => 'required|string|max:255',
           'email' => 'required|email|unique:doctors,email,' . Auth::guard('doctors')->id(), // Ensure unique email, except for the logged-in doctor
           'phone' => 'nullable|string|max:20',
           'specialization' => 'required|string|max:255',
           'license_number' => 'required|string|max:255',
           'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
       ]);

       // Get the authenticated doctor
       $doctor = Auth::guard('doctors')->user();


       // Handle photo upload
       if ($request->hasFile('profile_picture')) {
            // Get the original file name
            $originalFileName = $request->file('profile_picture')->getClientOriginalName();
            
            // Optionally, you could append a unique identifier to prevent name conflicts
            // e.g., using the time as a unique prefix or a random string
            $newFileName = time() . '_' . $originalFileName;
        
            // Store the file in the 'public/doctor_photos' directory and save the new file name
            $photoPath = $request->file('profile_picture')->storeAs('public/doctor_photos', $newFileName);
            
            // Save just the file name in the database
            $validatedData['profile_picture'] = $newFileName;
        }    
   

       // Update doctor information
       $doctor->update($validatedData);

       // Return to the profile page with a success message
       return redirect()->route('doctors.profile')->with('success', 'Profile updated successfully!');
   }

   public function techSupport()
    {
        $doctor = Auth::guard('doctors')->user(); // Get the authenticated doctors's data
        return view('doctors.tech-support', compact('doctor'));
    }
}
