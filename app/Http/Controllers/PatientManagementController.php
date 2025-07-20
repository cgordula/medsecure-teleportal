<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientManagementController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort_by', 'first_name');  // default sort field
        $sortDirection = $request->get('sort_dir', 'asc');    // default sort direction

        $allowedSortFields = [
            'reference_number',
            'first_name',
            'last_name',
            'email',
            'gender',
            'birthdate',
            'phone',
        ];

        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'first_name';  // fallback default
        }

        $patients = Patient::orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends(['sort_by' => $sortField, 'sort_dir' => $sortDirection]);

        return view('admin.patients.index', compact('patients', 'sortField', 'sortDirection'));
    }


    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'first_name'     => 'nullable|string|max:255',
            'last_name'      => 'nullable|string|max:255',
            'email'          => 'nullable|email|unique:patients,email,' . $id,
            'phone'          => 'nullable|string|max:20',
            'gender'         => 'nullable|string|max:10',
            'birthdate'      => 'nullable|date',
            'address_line1'  => 'nullable|string|max:255',
            'city'           => 'nullable|string|max:255',
            'state'          => 'nullable|string|max:255',
            'postal_code'    => 'nullable|string|max:20',
            'country'        => 'nullable|string|max:255',
        ]);

        $patient->update($validated);

        return redirect()->route('admin.patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);  // Find patient or throw 404 if not found
        $patient->delete();                   // Delete the patient record

        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully.');
    }

}