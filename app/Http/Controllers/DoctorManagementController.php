<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorManagementController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort_by', 'first_name'); // default sort field
        $sortDirection = $request->get('sort_dir', 'asc');   // default sort direction

        $allowedSortFields = ['reference_number', 'first_name', 'last_name', 'email', 'phone', 'specialization', 'license_number'];

        // Validate sort field to prevent SQL injection
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'first_name';
        }

        $doctors = Doctor::orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends(['sort_by' => $sortField, 'sort_dir' => $sortDirection]);

        return view('admin.doctors.index', compact('doctors', 'sortField', 'sortDirection'));
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