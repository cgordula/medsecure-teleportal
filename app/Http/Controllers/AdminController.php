<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function createAdmin()
    {
        return view('admin.admin_register');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|string|in:admin,doctor,editor,viewer', // Validate role
        ]);

        // Create admin user
        Admin::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Save role
        ]);

        return redirect()->back()->with('success', 'Admin registered successfully!');
    }

    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:admins',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     $admin = Admin::create([
    //         'first_name' => $request->first_name,
    //         'last_name' => $request->last_name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role' => 'admin', // Default role, change as needed
    //     ]);

    //     Auth::login($admin);

    //     return redirect()->route('admin.dashboard'); // Redirect to your admin dashboard
    // }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     if (Auth::attempt($request->only('email', 'password'))) {
    //         return redirect()->route('admin.dashboard'); // Redirect to admin dashboard on success
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }

    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect()->route('admin.login'); // Redirect to login page after logout
    // }
}
