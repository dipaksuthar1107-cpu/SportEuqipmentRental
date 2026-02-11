<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        // Temporary credentials (pachhi database thi aavshe)
        if ($request->email == 'admin@gmail.com' && $request->password == '12345') {
            // Session ma store karo
            session(['admin_login' => true]);
            session(['admin_email' => $request->email]);
            
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid Email or Password.',
        ])->withInput($request->only('email'));
    }

    public function dashboard()
    {
        // Check if admin is logged in
        if (!session('admin_login')) {
            return redirect()->route('admin.login')->withErrors([
                'message' => 'Please login first.'
            ]);
        }

        // Get admin email from session
        $admin_email = session('admin_email', 'admin@example.com');
        
        // Extract name from email (temporary until we have database)
        $admin_name = explode('@', $admin_email)[0];
        $admin_name = ucfirst(str_replace('.', ' ', $admin_name));

        // Store admin name in session for sidebar
        session(['admin_name' => $admin_name]);

        return view('admin.dashboard');
    }

    public function logout()
    {
        session()->forget(['admin_login', 'admin_email']);
        session()->flush();
        
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }

    public function equipment()
    {
        if (!session('admin_login')) {
            return redirect()->route('admin.login')->withErrors(['message' => 'Please login first.']);
        }
        return view('admin.equipment');
    }

    public function booking()
    {
        if (!session('admin_login')) {
            return redirect()->route('admin.login')->withErrors(['message' => 'Please login first.']);
        }
        return view('admin.booking');
    }

    public function report()
    {
        if (!session('admin_login')) {
            return redirect()->route('admin.login')->withErrors(['message' => 'Please login first.']);
        }
        return view('admin.report');
    }

    public function penalty()
    {
        if (!session('admin_login')) {
            return redirect()->route('admin.login')->withErrors(['message' => 'Please login first.']);
        }
        return view('admin.penalty');
    }
}
