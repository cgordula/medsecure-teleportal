<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
 
         // Attempt login using Auth facade
         if (Auth::guard('doctors')->attempt($credentials)) {
             // Login successful, redirect to patient dashboard or home
             return redirect()->route('doctors.doctor-dashboard');
         }
 
         // Login failed, redirect back to login form with error
         return back()->withErrors([
             'email' => 'The provided credentials do not match our records.',
         ])->onlyInput('email'); // Keep the email input val
     }
 
 
     public function doctorDashboard()
     {
         return view('doctors.doctor-dashboard'); // This points to the view file you'll create next
     }
}
