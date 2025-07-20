<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorManagementController extends Controller
{
    public function index()
    {
        $doctors = Doctor::orderBy('created_at', 'desc')->get();
        return view('admin.doctors.index', compact('doctors'));
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'reference_number' => 'nullable|string|max:255',
            'first_name'       => 'nullable|string|max:255',
            'last_name'        => 'nullable|string|max:255',
            'email'            => 'nullable|email|unique:doctors,email,' . $doctor->id,
            'phone'            => 'nullable|string|max:20',
            'specialization'   => 'nullable|string|max:255',
            'license_number'   => 'nullable|string|max:255',
            'role'             => 'nullable|in:Doctor,Admin',
            'profile_picture'  => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('doctors', 'public');
        }

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully.');
    }
}