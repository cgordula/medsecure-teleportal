<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    // Show the form to reset the password
    public function showResetForm(Request $request, $token = null)
    {
        return view('password.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Handle a password reset request
    public function reset(Request $request)
    {
        // Validate the incoming request
        $this->validate($request, [
            'email' => 'required|email|exists:patients,email', // Ensure email exists in the 'patients' table
            'password' => 'required|confirmed|min:8', // Password must be confirmed and at least 8 characters long
            'token' => 'required',
        ]);

        // Attempt the password reset
        $response = Password::broker('patients')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($patient) use ($request) {
                $patient->forceFill([
                    'password' => Hash::make($request->password), // Use Hash::make for password hashing
                ])->save();
            }
        );

        // Check if the reset was successful
        if ($response == Password::PASSWORD_RESET) {
            session()->flash('success', 'Your password has been reset successfully.');
            return redirect()->route('patients.login.form'); // Adjust if you have a specific login route
        }

        // If the password reset fails, return with errors
        return back()->withErrors(['email' => [trans($response)]]);
    }

    // Send the password reset link
    public function sendResetLinkEmail(Request $request)
    {
        // Validate the incoming email address
        $this->validate($request, [
            'email' => 'required|email|exists:patients,email', // Ensure email exists in the 'patients' table
        ]);

        // Send the reset link using the 'patients' broker
        $response = Password::broker('patients')->sendResetLink(
            $request->only('email')
        );

        // Check if the reset link was sent successfully
        if ($response == Password::RESET_LINK_SENT) {
            session()->flash('success', 'We have emailed your password reset link!');
            return back();
        }

        // If the reset link fails, return with errors
        return back()->withErrors(['email' => trans($response)]);
    }
}
