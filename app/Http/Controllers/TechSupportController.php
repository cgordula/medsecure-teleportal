<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\TechSupport;

class TechSupportController extends Controller
{
    public function submitTechSupport(Request $request)
    {
        // Validate the form input and store it in a variable
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'issue' => 'required|string',
            'message' => 'required|string',
        ]);

        // Save the data in the database
        $techSupport = TechSupport::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'issue' => $validated['issue'],
            'message' => $validated['message'],
        ]);

        // Send the email with the validated data
        // Mail::raw(
        //     // Email content in plain text format
        //     "You have received a new tech support request:\n\n" .
        //     "Name: {$validated['name']}\n" .
        //     "Email: {$validated['email']}\n" .
        //     "Issue: {$validated['issue']}\n" .
        //     "Message: {$validated['message']}",

        //     function ($message) use ($validated) { 
        //         $message->to('carminagordula@gmail.com')
        //                 ->subject('New Tech Support Request')
        //                 ->from($validated['email'], $validated['name']);
        //     }
        // );

        // Redirect back with success message
        return redirect()->back()->with('success', 'Your support request has been submitted. We will contact you soon.');
    }
}
