<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Booking;
use App\Models\Penalty;
use App\Models\User;

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

        $user = \App\Models\User::where('email', $request->email)
            ->where('role', 'admin')
            ->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            session(['admin_login' => true]);
            session(['admin_email' => $user->email]);
            session(['admin_name' => $user->name]);
            
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

        // Fetch real stats
        $stats = [
            'total_equipment' => Equipment::sum('quantity'),
            'active_bookings' => Booking::where('status', 'collected')->count(),
            'pending_requests' => Booking::where('status', 'pending')->count(),
            'total_penalties' => Penalty::where('status', 'unpaid')->count(),
            'approved_today' => Booking::where('status', 'approved')->whereDate('updated_at', date('Y-m-d'))->count(),
            'returned_today' => Booking::where('status', 'returned')->whereDate('updated_at', date('Y-m-d'))->count(),
            'active_rentals' => Booking::whereIn('status', ['approved', 'collected'])->count(),
            'penalty_collected' => Penalty::where('status', 'paid')->sum('amount'),
            'active_users' => User::where('role', 'student')->count(),
        ];

        $recent_bookings = Booking::with(['user', 'equipment'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Simplified chart data
        $chart_data = [
            'bookings_labels' => Booking::selectRaw('DATE(created_at) as date')->groupBy('date')->orderBy('date', 'desc')->take(7)->get()->pluck('date')->reverse()->values(),
            'bookings_counts' => Booking::selectRaw('COUNT(*) as count')->groupBy(\DB::raw('DATE(created_at)'))->orderBy(\DB::raw('DATE(created_at)'), 'desc')->take(7)->get()->pluck('count')->reverse()->values(),
            'categories' => Equipment::selectRaw('category, COUNT(*) as count')->groupBy('category')->get()
        ];

        return view('admin.dashboard', compact('stats', 'recent_bookings', 'chart_data'));
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
        
        $equipment = Equipment::all();
        return view('admin.equipment', compact('equipment'));
    }

    public function booking()
    {
        if (!session('admin_login')) {
            return redirect()->route('admin.login')->withErrors(['message' => 'Please login first.']);
        }
        
        $bookings = Booking::with(['user', 'equipment'])->get();
        return view('admin.booking', compact('bookings'));
    }

    public function report()
    {
        if (!session('admin_login')) {
            return redirect()->route('admin.login')->withErrors(['message' => 'Please login first.']);
        }

        // 1. Basic Stats
        $totalEquipmentCount = Equipment::sum('quantity');
        $totalBookingsCount = Booking::count();
        $returnedItemsCount = Booking::where('status', 'returned')->count();
        $totalPenaltyAmount = Penalty::sum('amount');
        $activeUsersCount = User::where('role', 'student')->count();
        $returnRate = $totalBookingsCount > 0 ? ($returnedItemsCount / $totalBookingsCount) * 100 : 0;

        // 2. Charts Data (Last 7 days for demo)
        $bookingsChartData = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();

        $categoryChartData = Equipment::selectRaw('category, SUM(quantity) as total')
            ->groupBy('category')
            ->get();

        $usageChartData = Booking::selectRaw('equipment_id, COUNT(*) as count')
            ->with('equipment')
            ->groupBy('equipment_id')
            ->orderBy('count', 'DESC')
            ->take(5)
            ->get();

        $revenueChartData = Penalty::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();

        // 3. Tables Data
        $mostUsedEquipment = Booking::selectRaw('equipment_id, COUNT(*) as rentals')
            ->with('equipment')
            ->groupBy('equipment_id')
            ->orderBy('rentals', 'DESC')
            ->take(5)
            ->get();

        $topBorrowers = Booking::selectRaw('user_id, COUNT(*) as rentals')
            ->with('user')
            ->groupBy('user_id')
            ->orderBy('rentals', 'DESC')
            ->take(5)
            ->get();

        return view('admin.report', compact(
            'totalEquipmentCount',
            'totalBookingsCount',
            'returnedItemsCount',
            'totalPenaltyAmount',
            'activeUsersCount',
            'returnRate',
            'bookingsChartData',
            'categoryChartData',
            'usageChartData',
            'revenueChartData',
            'mostUsedEquipment',
            'topBorrowers'
        ));
    }

    public function updateBookingStatus(Request $request)
    {
        if (!session('admin_login')) {
            return response()->json(['success' => false, 'message' => 'Please login first.'], 401);
        }

        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'status' => 'required|in:approved,rejected,collected,returned'
        ]);

        $booking = Booking::find($request->booking_id);
        $old_status = $booking->status;
        $booking->status = $request->status;
        $booking->save();

        // Stock management logic
        if ($request->status == 'rejected' && $old_status == 'pending') {
            // Give back stock if rejected before collection
            $equipment = Equipment::find($booking->equipment_id);
            $equipment->available += $booking->quantity;
            $equipment->save();
        } elseif ($request->status == 'returned' && $old_status == 'collected') {
            // Give back stock when returned
            $equipment = Equipment::find($booking->equipment_id);
            $equipment->available += $booking->quantity;
            $equipment->save();

            // Check for late return and apply penalty if needed
            $return_date = new \DateTime($booking->return_date);
            $now = new \DateTime();
            if ($now > $return_date) {
                $diff = $now->diff($return_date)->days;
                if ($diff > 0) {
                    Penalty::create([
                        'user_id' => $booking->user_id,
                        'equipment_id' => $booking->equipment_id,
                        'booking_id' => $booking->id,
                        'amount' => $diff * 100, // Example: 100 per day late
                        'reason' => "Late return by $diff days",
                        'status' => 'unpaid'
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking status updated successfully!',
            'new_status' => $booking->status
        ]);
    }

    public function storeEquipment(Request $request)
    {
        if (!session('admin_login')) return response()->json(['success' => false], 401);

        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'deposit' => 'required|numeric|min:0',
            'daily_rate' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'icon' => 'nullable|string'
        ]);

        Equipment::create([
            'name' => $request->name,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'available' => $request->quantity,
            'deposit' => $request->deposit,
            'daily_rate' => $request->daily_rate,
            'description' => $request->description,
            'icon' => $request->icon ?? 'fas fa-dumbbell',
            'max_days' => 7,
            'rating' => 0,
            'reviews' => 0,
            'rules' => [],
            'features' => []
        ]);

        return response()->json(['success' => true, 'message' => 'Equipment added successfully!']);
    }

    public function updateEquipment(Request $request)
    {
        if (!session('admin_login')) return response()->json(['success' => false], 401);

        $request->validate([
            'id' => 'required|exists:equipment,id',
            'name' => 'required|string',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'deposit' => 'required|numeric|min:0',
            'daily_rate' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'icon' => 'nullable|string'
        ]);

        $equipment = Equipment::find($request->id);
        $diff = $request->quantity - $equipment->quantity;
        $equipment->available += $diff;
        
        $equipment->update($request->all());

        return response()->json(['success' => true, 'message' => 'Equipment updated successfully!']);
    }

    public function deleteEquipment(Request $request)
    {
        if (!session('admin_login')) return response()->json(['success' => false], 401);

        $request->validate(['id' => 'required|exists:equipment,id']);

        $equipment = Equipment::find($request->id);
        $activeBookings = Booking::where('equipment_id', $equipment->id)
            ->whereIn('status', ['pending', 'approved', 'collected'])
            ->count();
        
        if ($activeBookings > 0) {
            return response()->json(['success' => false, 'message' => 'Cannot delete equipment with active bookings.']);
        }

        $equipment->delete();

        return response()->json(['success' => true, 'message' => 'Equipment deleted successfully!']);
    }

    public function storePenalty(Request $request)
    {
        if (!session('admin_login')) return response()->json(['success' => false], 401);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'equipment_id' => 'required|exists:equipment,id',
            'reason' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'reason_details' => 'nullable|string'
        ]);

        Penalty::create([
            'user_id' => $request->user_id,
            'equipment_id' => $request->equipment_id,
            'reason' => $request->reason,
            'reason_details' => $request->reason_details,
            'amount' => $request->amount,
            'status' => 'unpaid',
            'issued_date' => date('Y-m-d'),
            'due_date' => date('Y-m-d', strtotime('+7 days'))
        ]);

        return response()->json(['success' => true, 'message' => 'Penalty added successfully!']);
    }

    public function updatePenaltyStatus(Request $request)
    {
        if (!session('admin_login')) return response()->json(['success' => false], 401);

        $request->validate([
            'penalty_id' => 'required|exists:penalties,id',
            'status' => 'required|in:paid,waived'
        ]);

        $penalty = Penalty::find($request->penalty_id);
        $penalty->status = $request->status;
        $penalty->save();

        return response()->json(['success' => true, 'message' => 'Penalty status updated!']);
    }

    public function penalty()
    {
        if (!session('admin_login')) {
            return redirect()->route('admin.login')->withErrors(['message' => 'Please login first.']);
        }
        
        $penalties = Penalty::with(['user', 'equipment'])->get();
        $users = User::all();
        $equipment = Equipment::all();
        return view('admin.penalty', compact('penalties', 'users', 'equipment'));
    }
}
