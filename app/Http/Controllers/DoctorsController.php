<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorsController extends Controller
{

    public function create()
    {
        return view('doctors.doctor_register');
    }

    public function store(Request $request)
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

        return redirect()->back()->with('success', 'Doctor registered successfully.');
    }
}
