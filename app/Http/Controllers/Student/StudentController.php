<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function showLoginForm()
    {
        return view('student.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        // Temporary credentials (pachhi database thi aavshe)
        if ($request->email == 'dipaksuthar1107@gmail.com' && $request->password == 'Dipak@1234') {
            // Session ma store karo
            session(['student_login' => true]);
            session(['student_email' => $request->email]);
            
            return redirect()->route('student.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid Email or Password.',
        ])->withInput($request->only('email'));
    }

    public function dashboard()
    {
        // Check if student is logged in
        if (!session('student_login')) {
            return redirect()->route('student.login')->withErrors([
                'message' => 'Please login first.'
            ]);
        }

        // Get student email from session
        $student_email = session('student_email', 'student@example.com');
        
        // Extract name from email (temporary until we have database)
        $student_name = explode('@', $student_email)[0];
        $student_name = ucfirst(str_replace('.', ' ', $student_name));

        // Temporary stats (will come from database later)
        $data = [
            'student_name' => $student_name,
            'active_bookings' => 3,
            'pending_requests' => 2,
            'total_bookings' => 15,
            'available_equipment' => 45
        ];

        return view('student.dashboard', $data);
    }

    public function logout()
    {
        session()->forget(['student_login', 'student_email']);
        session()->flush();
        
        return redirect()->route('student.login')->with('success', 'Logged out successfully.');
    }

    public function equipmentList()
    {
        if (!session('student_login')) {
            return redirect()->route('student.login')->withErrors(['message' => 'Please login first.']);
        }
        return view('student.equipment-list');
    }

    public function bookingStatus()
    {
        if (!session('student_login')) {
            return redirect()->route('student.login')->withErrors(['message' => 'Please login first.']);
        }
        return view('student.booking-status');
    }

    public function bookingHistory()
    {
        if (!session('student_login')) {
            return redirect()->route('student.login')->withErrors(['message' => 'Please login first.']);
        }
        return view('student.booking-history');
    }

    public function filter()
    {
        if (!session('student_login')) {
            return redirect()->route('student.login')->withErrors(['message' => 'Please login first.']);
        }
        return view('student.filter');
    }

    public function requestBook()
    {
        if (!session('student_login')) {
            return redirect()->route('student.login')->withErrors(['message' => 'Please login first.']);
        }
        return view('student.request-book');
    }

    public function feedback()
    {
        if (!session('student_login')) {
            return redirect()->route('student.login')->withErrors(['message' => 'Please login first.']);
        }
        return view('student.feedback');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed',
        ]);

        // TODO: Save to database when ready
        // For now, just redirect to login
        return redirect()->route('student.login')->with('success', 'Registration successful! Please login.');
    }
}
