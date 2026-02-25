<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipment;
use App\Models\Booking;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\PasswordResetMail;
use App\Services\SmsService;

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
        $total_bookings = 0;
        $feedback_pending_count = 0;

        if ($user) {
            $history = Booking::with(['equipment', 'feedback'])
                ->where('user_id', $user->id)
                ->whereIn('status', ['returned', 'cancelled', 'rejected'])
                ->orderBy('updated_at', 'desc')
                ->get();

            $total_bookings = $history->count();
            
            // Count bookings that don't have feedback yet
            $feedback_pending_count = Booking::where('user_id', $user->id)
                ->where('status', 'returned')
                ->whereDoesntHave('feedback')
                ->count();
        }

        $student_name = session('student_name', 'Student');
        
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
        
        if (!$id) {
            return redirect()->route('student.booking-history')->with('info', 'Please select a returned booking to give feedback.');
        }

        $booking = Booking::with('equipment')->find($id);

        if (!$booking || $booking->status !== 'returned') {
            return redirect()->route('student.booking-history')->with('error', 'Invalid booking for feedback.');
        }

        // Check if feedback already submitted
        $existingFeedback = Feedback::where('booking_id', $id)->first();
        if ($existingFeedback) {
            return redirect()->route('student.booking-history')->with('info', 'Feedback already submitted for this booking.');
        }

        $data = [
            'student_name' => session('student_name', 'Student'),
            'booking' => $booking,
            'equipment_name' => $booking->equipment->name,
            'equipment_icon' => $booking->equipment->icon,
            'category' => $booking->equipment->category,
            'booking_id' => $booking->id
        ];
        
        return view('student.feedback', $data);
    }

    public function submitFeedback(Request $request)
    {
        if (!session('student_login')) {
            return response()->json(['success' => false, 'message' => 'Please login first.'], 401);
        }

        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'overallRating' => 'required|integer|min:1|max:5',
            'condition' => 'required|string',
            'qualityRating' => 'nullable|integer|min:1|max:5',
            'bookingRating' => 'nullable|integer|min:1|max:5',
            'staffRating' => 'nullable|integer|min:1|max:5',
            'comments' => 'required|string',
            'recommend' => 'required|string',
        ]);

        $student_email = session('student_email');
        $user = \App\Models\User::where('email', $student_email)->first();

        $feedback = Feedback::create([
            'user_id' => $user->id,
            'booking_id' => $request->booking_id,
            'overall_rating' => $request->overallRating,
            'condition' => $request->condition,
            'quality_rating' => $request->qualityRating,
            'booking_rating' => $request->bookingRating,
            'staff_rating' => $request->staffRating,
            'comments' => $request->comments,
            'recommend' => $request->recommend,
        ]);

        if ($feedback) {
            return response()->json([
                'success' => true,
                'message' => 'Feedback submitted successfully!',
                'redirect' => route('student.booking-history')
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Failed to submit feedback.']);
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

    public function sendOtp(Request $request)
    {
        try {
            $email        = $request->email ?? session('reset_email');
            $verification = $request->verification ?? session('reset_method', 'email');

            if (!$email) {
                return response()->json(['success' => false, 'message' => 'Email is required.']);
            }

            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'No account found with this email address.']);
            }

            $otp = sprintf("%06d", mt_rand(100000, 999999));

            DB::table('password_resets')->updateOrInsert(
                ['email' => $email],
                ['token' => $otp, 'created_at' => Carbon::now()]
            );

            if ($verification === 'email') {
                try {
                    Mail::to($email)->send(new PasswordResetMail($user->name, $otp));
                    $message = "OTP sent successfully to {$email}!";
                } catch (\Exception $mailEx) {
                    \Illuminate\Support\Facades\Log::error('Student mail send failed: ' . $mailEx->getMessage());
                    return response()->json(['success' => false, 'message' => 'Failed to send email. Please check your inbox or try again. Error: ' . $mailEx->getMessage()]);
                }
            } else {
                $smsService = new SmsService();
                $phone = $user->phone ?? '1234567890';
                $smsService->sendSms($phone, "Sports Rental: Your reset OTP is: " . $otp);
                $message = "OTP sent via SMS!";
            }

            session([
                'reset_email'  => $email,
                'reset_method' => $verification
            ]);

            return response()->json([
                'success'  => true,
                'message'  => $message,
                'redirect' => route('student.verify-otp')
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('sendOtp error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    public function showVerifyOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('student.forgot-password');
        }
        return view('student.verify-otp', ['email' => session('reset_email')]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|size:6',
            'email' => 'required|email'
        ]);

        $otp = implode('', $request->otp);
        $resetData = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $otp)
            ->first();

        if (!$resetData || Carbon::parse($resetData->created_at)->addMinutes(30)->isPast()) {
            return back()->withErrors(['message' => 'Invalid or expired OTP.']);
        }

        // Mark as verified in session
        session(['otp_verified' => true]);

        return redirect()->route('student.reset-password');
    }

    public function showResetForm()
    {
        if (!session('otp_verified') || !session('reset_email')) {
            return redirect()->route('student.forgot-password')->withErrors(['message' => 'Please verify OTP first.']);
        }

        return view('student.reset-password', ['email' => session('reset_email')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:5|confirmed',
        ]);

        if (!session('otp_verified') || session('reset_email') !== $request->email) {
            return redirect()->route('student.forgot-password')->withErrors(['message' => 'Session expired or unauthorized.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();
        session()->forget(['otp_verified', 'reset_email']);

        return redirect()->route('student.login')->with('success', 'Password updated successfully!');
    }
}
