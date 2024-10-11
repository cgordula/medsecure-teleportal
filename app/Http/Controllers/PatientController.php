<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    // Show the registration form
    public function create()
    {
        return view('patients.patient_register');
    }

    // Handle form submission
    public function store(Request $request)
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

        return redirect()->back()->with('success', 'Patient registered successfully!');
    }
}