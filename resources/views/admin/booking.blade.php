<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Booking Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/booking.css') }}">
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
        <!-- Navbar -->
        <nav class="navbar navbar-light bg-white rounded shadow-sm mb-4">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <h4 class="mb-0"><i class="fas fa-calendar-check text-primary me-2"></i> Booking Management</h4>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i>{{ session('admin_name', 'Admin') }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Stats Cards -->
        <div class="row mb-4 fade-in">
            <div class="col-md-3">
                <div class="stats-card stats-1">
                    <i class="fas fa-clock"></i>
                    <h3>{{ $bookings->where('status', 'pending')->count() }}</h3>
                    <p>Pending Requests</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-2">
                    <i class="fas fa-check-circle"></i>
                    <h3>{{ $bookings->where('status', 'approved')->count() }}</h3>
                    <p>Approved Today</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-3">
                    <i class="fas fa-box-open"></i>
                    <h3>{{ $bookings->where('status', 'collected')->count() }}</h3>
                    <p>To Be Collected</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-4">
                    <i class="fas fa-undo-alt"></i>
                    <h3>{{ $bookings->where('status', 'returned')->count() }}</h3>
                    <p>Pending Returns</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-card fade-in">
            <h5 class="mb-3"><i class="fas fa-filter me-2"></i>Filter Bookings</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="form-select" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="collected">Collected</option>
                        <option value="returned">Returned</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterCategory">
                        <option value="">All Categories</option>
                        <option>Indoor</option>
                        <option>Outdoor</option>
                        <option>Fitness</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="filterDate">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" id="applyFilter">
                        <i class="fas fa-search me-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Booking Timeline -->
        <div class="card mb-4 fade-in">
            <div class="card-header">
                <i class="fas fa-stream me-2"></i>Booking Process
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-step completed">
                        <div class="step-icon"><i class="fas fa-clipboard-check"></i></div>
                        <div class="step-label">Requested</div>
                    </div>
                    <div class="timeline-step completed">
                        <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="step-label">Approved</div>
                    </div>
                    <div class="timeline-step active">
                        <div class="step-icon"><i class="fas fa-box-open"></i></div>
                        <div class="step-label">Collected</div>
                    </div>
                    <div class="timeline-step">
                        <div class="step-icon"><i class="fas fa-undo-alt"></i></div>
                        <div class="step-label">Returned</div>
                    </div>
                    <div class="timeline-step">
                        <div class="step-icon"><i class="fas fa-flag-checkered"></i></div>
                        <div class="step-label">Completed</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Requests -->
        <div class="card fade-in">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-list me-2"></i>Booking Requests
                </div>
                <div class="d-flex">
                    <input type="text" class="form-control me-2" placeholder="Search bookings..." style="width: 200px;" id="searchBooking">
                    <button class="btn btn-outline-primary" id="exportBtn">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover" id="bookingTable">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Equipment</th>
                                    <th>Category</th>
                                    <th>Qty</th>
                                    <th>Booking Date</th>
                                    <th>Return Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr id="booking-{{ $booking->id }}">
                                    <td>{{ $booking->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $booking->user->name ?? 'Unknown' }}</strong>
                                                <div class="text-muted small">{{ $booking->user->email ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                <i class="{{ $booking->equipment->icon ?? 'fas fa-dumbbell' }}"></i>
                                            </div>
                                            <span>{{ $booking->equipment->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $booking->equipment->category ?? 'General' }}</td>
                                    <td>{{ $booking->quantity }}</td>
                                    <td>{{ $booking->booking_date }}</td>
                                    <td>{{ $booking->return_date }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                                    </td>
                                    <td>
                                        @if($booking->status == 'pending')
                                        <button class="btn btn-sm btn-success me-1" onclick="updateStatus({{ $booking->id }}, 'approved')" data-bs-toggle="tooltip" title="Approve">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger me-1" onclick="updateStatus({{ $booking->id }}, 'rejected')" data-bs-toggle="tooltip" title="Reject">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                        @elseif($booking->status == 'approved')
                                        <button class="btn btn-sm btn-info me-1" onclick="updateStatus({{ $booking->id }}, 'collected')" data-bs-toggle="tooltip" title="Mark as Collected">
                                            <i class="fas fa-box-open"></i>
                                        </button>
                                        @elseif($booking->status == 'collected')
                                        <button class="btn btn-sm btn-secondary me-1" onclick="updateStatus({{ $booking->id }}, 'returned')" data-bs-toggle="tooltip" title="Mark as Returned">
                                            <i class="fas fa-undo-alt"></i>
                                        </button>
                                        @endif
                                        <button class="btn btn-sm btn-info" onclick="viewBookingDetails({{ $booking->id }})" data-bs-toggle="tooltip" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
        window.dbBookings = @json($bookings);
    </script>
    <script src="{{ asset('assets/admin/js/booking.js') }}"></script>
</body>
</html>