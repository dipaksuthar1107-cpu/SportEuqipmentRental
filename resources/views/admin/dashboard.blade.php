<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard | Sports Equipment Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <!-- Admin Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dashboard.css') }}">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">
                <i class="fas fa-dumbbell"></i>
            </div>
            <h4>SportAdmin</h4>
            <button class="toggle-btn" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ Request::is('admin/dashboard*') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.equipment') }}" class="{{ Request::is('admin/equipment*') ? 'active' : '' }}">
                    <i class="fas fa-dumbbell"></i>
                    <span>Equipment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.booking') }}" class="{{ Request::is('admin/booking*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Bookings</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.report') }}" class="{{ Request::is('admin/report*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.penalty') }}" class="{{ Request::is('admin/penalty*') ? 'active' : '' }}">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Penalty</span>
                </a>
            </li>
            <li class="mt-4">
                <a href="{{ route('admin.logout') }}">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
        
        <div class="user-profile">
            <div class="user-avatar">AD</div>
            <div class="user-name">{{ session('admin_name', 'Admin') }}</div>
            <div class="user-role">Super Administrator</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Topbar -->
        <div class="topbar">
            <div>
                <h2>Sports Equipment Rental Dashboard</h2>
                <div class="date-display" id="currentDate"></div>
            </div>
            <div class="topbar-actions">
                <button class="notification-btn" id="notificationBtn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">5</span>
                </button>
                <span class="badge bg-primary fs-6 px-3 py-2">Admin</span>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h5>Quick Actions</h5>
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <a href="{{ route('admin.equipment') }}" class="action-btn">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Equipment</span>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('admin.booking') }}" class="action-btn">
                        <i class="fas fa-calendar-plus"></i>
                        <span>New Booking</span>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('admin.report') }}" class="action-btn">
                        <i class="fas fa-file-export"></i>
                        <span>Generate Report</span>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('admin.penalty') }}" class="action-btn">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Add Penalty</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="stats-card stats-card-1">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <h3>{{ $stats['total_equipment'] }}</h3>
                        <p>Total Equipment</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-card-2">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <h3>{{ $stats['pending_requests'] }}</h3>
                        <p>Pending Requests</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-card-3">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3>{{ $stats['approved_today'] }}</h3>
                        <p>Approved Today</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-card-4">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-undo-alt"></i>
                        </div>
                        <h3>{{ $stats['returned_today'] }}</h3>
                        <p>Items Returned Today</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats Cards -->
        <div class="row g-4 mt-0">
            <div class="col-md-3">
                <div class="stats-card stats-card-5">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>{{ $stats['active_users'] }}</h3>
                        <p>Active Students</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-card-6">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <h3>₹{{ number_format($stats['penalty_collected']) }}</h3>
                        <p>Penalty Collected</p>
                    </div>
                </div>
            </div>
            
            <!-- Charts Row -->
            <div class="col-md-6">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="chart-card">
                            <div class="card-header">
                                <span>Booking Trends</span>
                                <select class="form-select form-select-sm w-auto d-inline-block">
                                    <option>Last 7 Days</option>
                                    <option>Last 30 Days</option>
                                    <option>Last 3 Months</option>
                                </select>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="bookingTrendChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="row g-4">
            <div class="col-md-8">
                <div class="chart-card">
                    <div class="card-header">
                        <span>Equipment Usage Distribution</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="equipmentUsageChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-card">
                    <div class="card-header">
                        <span>Status Overview</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Booking Requests -->
        <div class="table-card">
            <div class="card-header">
                <span>Recent Booking Requests</span>
                <a href="booking.html" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Equipment</th>
                                <th>Category</th>
                                <th>Qty</th>
                                <th>Booking Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_bookings as $booking)
                            <tr>
                                <td>#{{ str_pad($booking->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                            {{ substr($booking->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <div>
                                            <strong>{{ $booking->user->name ?? 'Unknown' }}</strong>
                                            <div class="text-muted small">{{ $booking->user->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $booking->equipment->name ?? 'N/A' }}</td>
                                <td>{{ $booking->equipment->category ?? 'N/A' }}</td>
                                <td>{{ $booking->quantity }}</td>
                                <td>{{ date('d-M-Y', strtotime($booking->booking_date)) }}</td>
                                <td>
                                    <span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                                </td>
                                <td>
                                    @if($booking->status == 'pending')
                                    <button class="btn btn-sm btn-success me-1" onclick="updateBookingStatus('{{ $booking->id }}', 'approved')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="updateBookingStatus('{{ $booking->id }}', 'rejected')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @else
                                    <a href="{{ route('admin.booking') }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer" id="footer">
        © <span id="currentYear"></span> Sports Equipment Rental Portal
    </footer>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        window.adminDashboardData = @json($chart_data);
        window.adminStats = @json($stats);
        window.routes = {
            updateBookingStatus: "{{ route('admin.booking.update-status') }}"
        };
    </script>
    <script src="{{ asset('assets/admin/js/dashboard.js') }}"></script>
</body>
</html>