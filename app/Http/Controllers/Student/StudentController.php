<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipment;
use App\Models\Booking;

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

        $user = \App\Models\User::where('email', $request->email)
            ->where('role', 'student')
            ->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            session(['student_login' => true]);
            session(['student_email' => $user->email]);
            session(['student_name' => $user->name]);
            
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

        // Real stats from database
        $data = [
            'student_name' => $student_name,
            'active_bookings' => Booking::where('status', 'collected')->count(), // Should eventually filter by current student
            'pending_requests' => Booking::where('status', 'pending')->count(),
            'total_bookings' => Booking::count(),
            'available_equipment' => Equipment::sum('available')
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

        $student_name = session('student_name', 'Student');
        $categories = ['All', 'Ball Sports', 'Indoor Sports', 'Gym Equipment', 'Cricket', 'Badminton'];
        $equipment = Equipment::all();

        return view('student.filter', compact('categories', 'equipment', 'student_name'));
    }

    public function equipmentDetail($id)
    {
        if (!session('student_login')) {
            return redirect()->route('student.login')->withErrors(['message' => 'Please login first.']);
        }

        $equipment = Equipment::find($id);

        if (!$equipment) {
            return redirect()->route('student.equipment-list')->withErrors(['message' => 'Equipment not found.']);
        }

        $student_name = session('student_name', 'Student');
        return view('student.equipment-list', compact('equipment', 'student_name'));
    }

    private function getMockEquipment()
    {
        return [
            [
                'id' => 1,
                'name' => 'Basketball',
                'description' => 'Professional grade basketball for indoor and outdoor use',
                'category' => 'Ball Sports',
                'condition' => 'Excellent',
                'quantity' => 10,
                'available' => 7,
                'deposit' => '₹500',
                'daily_rate' => '₹50',
                'max_days' => 7,
                'image_icon' => 'fas fa-basketball-ball',
                'icon' => 'fas fa-basketball-ball',
                'rating' => 4.5,
                'total' => 10,
                'reviews' => 28,
                'rules' => [
                    'Valid student ID required for rental',
                    'Equipment must be returned in same condition',
                    'Late returns will incur penalty charges',
                    'Damage or loss will be charged from deposit',
                    'Maximum rental period is 7 days'
                ],
                'features' => [
                    'Official size and weight',
                    'Durable rubber construction',
                    'Suitable for all surfaces',
                    'Deep channel design for better grip'
                ]
            ],
            [
                'id' => 2,
                'name' => 'Football',
                'description' => 'Standard size football for training and matches',
                'category' => 'Ball Sports',
                'condition' => 'Good',
                'quantity' => 8,
                'available' => 5,
                'total' => 8,
                'deposit' => '₹400',
                'daily_rate' => '₹40',
                'max_days' => 5,
                'image_icon' => 'fas fa-football-ball',
                'icon' => 'fas fa-football-ball',
                'rating' => 4.2,
                'reviews' => 15,
                'rules' => ['Return after use', 'No rough use on concrete'],
                'features' => ['Water resistant', 'Standard size']
            ],
            [
                'id' => 3,
                'name' => 'Table Tennis Set',
                'description' => 'Complete set with 2 rackets and 3 balls',
                'category' => 'Indoor Sports',
                'condition' => 'Excellent',
                'quantity' => 5,
                'available' => 3,
                'total' => 5,
                'deposit' => '₹800',
                'daily_rate' => '₹30',
                'max_days' => 3,
                'image_icon' => 'fas fa-table-tennis',
                'icon' => 'fas fa-table-tennis',
                'rating' => 4.8,
                'reviews' => 10,
                'rules' => ['Handle with care'],
                'features' => ['High quality rubber', 'Lightweight']
            ],
            [
                'id' => 4,
                'name' => 'Cricket Bat',
                'description' => 'English willow cricket bat for professional practice',
                'category' => 'Cricket',
                'condition' => 'Good',
                'quantity' => 6,
                'available' => 4,
                'total' => 6,
                'deposit' => '₹600',
                'daily_rate' => '₹60',
                'max_days' => 10,
                'image_icon' => 'fas fa-baseball-ball',
                'icon' => 'fas fa-baseball-ball',
                'rating' => 4.0,
                'reviews' => 20,
                'rules' => ['Use with leather balls only'],
                'features' => ['English willow', 'Grip included']
            ],
            [
                'id' => 5,
                'name' => 'Badminton Racket',
                'description' => 'Graphite frame badminton racket',
                'category' => 'Badminton',
                'condition' => 'Excellent',
                'quantity' => 8,
                'available' => 6,
                'total' => 8,
                'deposit' => '₹300',
                'daily_rate' => '₹25',
                'max_days' => 4,
                'image_icon' => 'fas fa-shuttlecock',
                'icon' => 'fas fa-shuttlecock',
                'rating' => 4.6,
                'reviews' => 12,
                'rules' => ['No dragging on court'],
                'features' => ['Lightweight', 'High tension strings']
            ],
            [
                'id' => 6,
                'name' => 'Dumbbell Set',
                'description' => 'Adjustable dumbbell set (5kg - 20kg)',
                'category' => 'Gym Equipment',
                'condition' => 'Good',
                'quantity' => 4,
                'available' => 2,
                'total' => 4,
                'deposit' => '₹1500',
                'daily_rate' => '₹100',
                'max_days' => 14,
                'image_icon' => 'fas fa-dumbbell',
                'icon' => 'fas fa-dumbbell',
                'rating' => 4.7,
                'reviews' => 8,
                'rules' => ['Do not drop on floor'],
                'features' => ['Adjustable weight', 'Rubber coating']
            ]
        ];
    }

    public function bookingStatus()
    {
        if (!session('student_login')) {
            return redirect()->route('student.login')->withErrors(['message' => 'Please login first.']);
        }

        $student_email = session('student_email');
        $user = \App\Models\User::where('email', $student_email)->first();

        $bookings = collect();
        if ($user) {
            $bookings = Booking::with('equipment')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Calculate status counts
        $status_counts = [
            'pending' => $bookings->where('status', 'pending')->count(),
            'approved' => $bookings->where('status', 'approved')->count(),
            'collected' => $bookings->where('status', 'collected')->count(),
            'returned' => $bookings->where('status', 'returned')->count(),
            'cancelled' => $bookings->where('status', 'cancelled')->count(),
        ];

        $student_name = session('student_name', 'Student');
        return view('student.booking-status', compact('bookings', 'status_counts', 'student_name'));
    }

    public function bookingHistory()
    {
        if (!session('student_login')) {
            return redirect()->route('student.login')->withErrors(['message' => 'Please login first.']);
        }

        $student_email = session('student_email');
        $user = \App\Models\User::where('email', $student_email)->first();

        $history = [];
        if ($user) {
            $history = Booking::with('equipment')
                ->where('user_id', $user->id)
                ->whereIn('status', ['returned', 'cancelled', 'rejected'])
                ->orderBy('return_date', 'desc')
                ->get();
        }

        $student_name = session('student_name', 'Student');
        
        // Count for stats
        $total_bookings = count($history);
        $feedback_pending_count = 0; // Temporary until feedback table implemented

        return view('student.booking-history', compact('history', 'total_bookings', 'feedback_pending_count', 'student_name'));
    }



    public function requestBook($id = null)
    {
        if (!session('student_login')) {
            return redirect()->route('student.login')->withErrors(['message' => 'Please login first.']);
        }

        $student_name = session('student_name', 'Student');

        // Find the equipment by ID
        $equipment = Equipment::find($id);

        // If no equipment found or no ID provided, redirect to equipment list
        if (!$equipment) {
            return redirect()->route('student.equipment-list')->with('info', 'Please select an equipment to request.');
        }

        return view('student.request-book', compact('equipment', 'student_name'));
    }

    public function submitBooking(Request $request)
    {
        if (!session('student_login')) {
            return response()->json(['success' => false, 'message' => 'Please login first.'], 401);
        }

        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'quantity' => 'required|integer|min:1',
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required',
            'duration' => 'required|integer|min:1',
            'purpose' => 'nullable|string',
        ]);

        $student_email = session('student_email');
        $student_name = session('student_name', 'Student');

        // Find or create user to get user_id
        $user = \App\Models\User::firstOrCreate(
            ['email' => $student_email],
            ['name' => $student_name, 'password' => \Illuminate\Support\Facades\Hash::make('password')] // Default password
        );

        $return_date = date('Y-m-d', strtotime($request->pickup_date . ' + ' . $request->duration . ' days'));

        $booking = Booking::create([
            'user_id' => $user->id,
            'equipment_id' => $request->equipment_id,
            'quantity' => $request->quantity,
            'booking_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'return_date' => $return_date,
            'purpose' => $request->purpose,
            'status' => 'pending'
        ]);

        if ($booking) {
            // Update equipment availability
            $equipment = Equipment::find($request->equipment_id);
            $equipment->available -= $request->quantity;
            $equipment->save();

            return response()->json([
                'success' => true,
                'message' => 'Booking request submitted successfully! Redirecting to status page...',
                'redirect' => route('student.booking-status')
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Failed to submit booking request.']);
    }

    public function feedback($id = null)
    {
        if (!session('student_login')) {
            return redirect()->route('student.login')->withErrors(['message' => 'Please login first.']);
        }
        
        // Mock recent bookings for feedback
        $recentBookings = [
            [
                'id' => 5, 
                'equipment' => 'Dumbbell Set', 
                'category' => 'Gym Equipment',
                'icon' => 'fas fa-dumbbell',
                'return_date' => '2026-01-27'
            ],
            [
                'id' => 4, 
                'equipment' => 'Cricket Bat', 
                'category' => 'Cricket',
                'icon' => 'fas fa-baseball-ball',
                'return_date' => '2026-01-18'
            ]
        ];
        
        // Find the specific booking or default to the most recent one
        $selectedBooking = null;
        if ($id) {
            foreach ($recentBookings as $booking) {
                if ($booking['id'] == $id) {
                    $selectedBooking = $booking;
                    break;
                }
            }
        }
        
        // If no ID or ID not found, use the first one from mock data
        if (!$selectedBooking) {
            $selectedBooking = $recentBookings[0];
        }

        $data = [
            'student_name' => session('student_name', 'Student'),
            'recentBookings' => $recentBookings,
            'equipment_name' => $selectedBooking['equipment'],
            'equipment_icon' => $selectedBooking['icon'],
            'category' => $selectedBooking['category'],
            'booking_id' => $selectedBooking['id']
        ];
        
        return view('student.feedback', $data);
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'student'
        ]);

        return redirect()->route('student.login')->with('success', 'Registration successful! Please login.');
    }
}
