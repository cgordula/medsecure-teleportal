<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

        // Generate unique reference number
        $date = now()->format('Ymd');
        // Get the next sequence number (based on how many doctors exist)
        $nextDoctorNumber = str_pad(Doctor::count() + 1, 4, '0', STR_PAD_LEFT); 
        // Generate the reference number
        $referenceNumber = 'MSD-' . $date . '-' . $nextDoctorNumber;

        Doctor::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Hash the password before saving
            'specialization' => $validatedData['specialization'], // Add specialization
            'license_number' => $validatedData['license_number'], // Add license number
            'role' => 'doctor', // Default role for doctors
            'reference_number' => $referenceNumber,
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
        ->whereDate('appointment_date', '>=', now()->toDateString()) // Only today or future
        // ->whereDate('appointment_date', '>', now()) // Appointments in the future
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
        $allAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->whereNotNull('patient_id')
            ->get();

        // Get all unique patient models (regardless of appointment status or date)
        $uniquePatients = $allAppointments->pluck('patient')->unique('id')->values();

        $patientCount = $uniquePatients->count();

        
        // Pass data to the view
        return view('doctors.doctor-dashboard', compact(
            'upcomingAppointments',
            'appointmentHistory',
            'upcomingAppointmentsCount',
            'telemedicineHistoryCount',
            'patientCount',
            'uniquePatients'
        ));
    }


    public function doctorLogout(Request $request)
    {
        Auth::guard('doctors')->logout(); // Log out the doctor
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('doctors.login')->with('success', 'You have been logged out successfully.');
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


   public function doctorPatientLists()
   {
        $doctor = Auth::guard('doctors')->user();


        // Automatically decline outdated scheduled appointments
        Appointment::where('doctor_id', $doctor->id)
        ->where('status', 'Scheduled')
        ->where('appointment_date', '<', Carbon::today())
        ->update(['status' => 'Declined']);

        // Fetch scheduled appointments
        $scheduledAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('status', 'Scheduled')
            ->where('appointment_date', '>', Carbon::now())
            ->orderBy('appointment_date', 'asc')
            ->get();

        // Fetch accepted appointments
        $acceptedAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('status', 'Accepted')
            ->orderBy('appointment_date', 'asc')
            ->get();

        // Fetch declined appointments
        $declinedAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('status', 'Declined')
            ->orderBy('appointment_date', 'asc')
            ->get();

        // Fetch cancelled appointments
        $cancelledAppointments = Appointment::with('patient')
        ->where('doctor_id', $doctor->id)
        ->where('status', 'Cancelled')  // or 'Cancelled by Patient' if you have that exact status
        ->orderBy('appointment_date', 'asc')
        ->get();
        

        return view('doctors.patient-list', compact(
            'scheduledAppointments',
            'acceptedAppointments',
            'declinedAppointments',
            'cancelledAppointments'
        ));
    }

    public function updateAppointmentStatus(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'status' => 'required|in:Accepted,Declined',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        // Ensure the logged-in doctor owns the appointment
        if ($appointment->doctor_id !== Auth::guard('doctors')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $appointment->status = $request->status;
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment status updated successfully.');
    }


   public function techSupport()
    {
        $doctor = Auth::guard('doctors')->user(); // Get the authenticated doctors's data
        return view('doctors.tech-support', compact('doctor'));
    }
}
