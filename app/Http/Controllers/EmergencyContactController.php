<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyContact;

class EmergencyContactController extends Controller
{
    // Update the emergency contact data
    public function updateEmergencyContact(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'phone' => 'required|string|max:15', // Adjust phone validation as needed
        ]);

        // Retrieve or create an emergency contact for the logged-in user
        $emergencyContact = EmergencyContact::firstOrNew(['patient_id' => auth()->user()->id]);

        // Update the emergency contact details
        $emergencyContact->name = $validated['name'];
        $emergencyContact->relationship = $validated['relationship'];
        $emergencyContact->phone = $validated['phone'];

        // Save the updated emergency contact
        $emergencyContact->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Emergency contact updated successfully!');
    }
}
