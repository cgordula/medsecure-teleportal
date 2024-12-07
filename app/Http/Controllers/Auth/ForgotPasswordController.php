<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('password.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:patients,email',
        ]);

        // Send password reset link for the 'patients' broker
        $response = Password::broker('patients')->sendResetLink($request->only('email'));

        // Check the response and set a success message
        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', 'We have emailed your password reset link!');
        } else {
            return back()->withErrors(['email' => 'We couldn’t find a user with that email address.']);
        }
    }
}
