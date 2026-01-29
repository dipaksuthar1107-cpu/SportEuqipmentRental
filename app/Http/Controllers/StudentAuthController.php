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
        if ($request->email == 'student@gmail.com' && $request->password == '12345') {
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

        return view('student.dashboard');
    }

    public function logout()
    {
        session()->forget(['student_login', 'student_email']);
        session()->flush();
        
        return redirect()->route('student.login')->with('success', 'Logged out successfully.');
    }
}
