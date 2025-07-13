<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;

class AdminController extends Controller
{
    public function createAdmin()
    {
        return view('admin.admin_register');
    }

    public function storeAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|string|in:admin,doctor,editor,viewer', // Validate role
        ]);

        // Create admin user
        Admin::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'] // Save role
        ]);

      
        session()->flash('success', 'Admin registered successfully! You can now log in.');

        return redirect()->route('admin.login');
    }

    // Show the login form
    public function adminLoginForm()
    {
        return view('admin.login'); 
    }

    // Handle login
    public function adminLogin(Request $request)
    {
        // Validate login request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if "Remember Me" checkbox is selected
        $remember = $request->has('remember');


        // Check if the email exists in the admin table
        $adminExists = Admin::where('email', $credentials['email'])->exists();

        // Attempt login using Auth facade
        if (Auth::guard('admin')->attempt($credentials)) {
            // Login successful, redirect to patient dashboard or home
            $request->session()->regenerate();
            return redirect()->route('admin.admin-dashboard');
        }

        if (!$adminExists) {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->onlyInput('email'); // Keep the email input value
        }

        // Login failed, redirect back to login form with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email'); // Keep the email input val
    }


    public function adminDashboard()
    {
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();

        $upcomingAppointmentsCount = Appointment::where('status', 'Scheduled')->count();
        $completedAppointmentsCount = Appointment::where('status', 'Completed')->count();
        $cancelledAppointmentsCount = Appointment::where('status', 'Cancelled')->count();
        $declinedAppointmentsCount = Appointment::where('status', 'Declined')->count();
        $acceptedAppointmentsCount = Appointment::where('status', 'Accepted')->count();

        $allPatients = Patient::all();
        $allDoctors = Doctor::all();

        $upcomingAppointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'Scheduled')
            ->orderBy('appointment_date', 'asc')
            ->get();

        $completedAppointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'Completed')
            ->orderBy('appointment_date', 'desc')
            ->get();
        

        // Get top 5 doctors with most appointments
        $doctorAppointmentCounts = Appointment::select('doctor_id', DB::raw('COUNT(*) as count'))
        ->groupBy('doctor_id')
        ->with('doctor')
        ->orderByDesc('count')
        ->take(5)
        ->get()
        ->map(function ($item) {
            return [
                'name' => $item->doctor->first_name . ' ' . $item->doctor->last_name,
                'count' => $item->count
            ];
        });

        
        $appointmentsBySpecialization = Appointment::join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
        ->select('doctors.specialization', DB::raw('count(*) as total'))
        ->groupBy('doctors.specialization')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

        $appointmentStatusBreakdown = Appointment::select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();



        return view('admin.admin-dashboard', compact(
            'totalPatients',
            'totalDoctors',
            'upcomingAppointmentsCount',
            'completedAppointmentsCount',
            'cancelledAppointmentsCount',
            'declinedAppointmentsCount',
            'acceptedAppointmentsCount',
            'allPatients',
            'allDoctors',
            'upcomingAppointments',
            'completedAppointments',
            'doctorAppointmentCounts',
            'appointmentsBySpecialization',
            'appointmentStatusBreakdown'
        ));
    }



    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout(); // Log out the admin
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form')->with('success', 'You have been logged out successfully.');
    }
}
