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
        return view('patients.register');
    }

    // Handle form submission
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'required|email|unique:patients,email',
            'password' => 'required|min:8|confirmed',
        ]);

        Patient::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'Active'
        ]);

        return redirect()->route('patients.register')->with('success', 'Registration successful.');
    }
}