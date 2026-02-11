
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard | Sports Rental</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Student Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('assets/student/css/dashboard.css') }}">
</head>
<body>
    <!-- Mobile Toggle -->
    <button class="mobile-toggle" id="mobileToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="student-info">
                <div class="student-avatar">
                    {{ strtoupper(substr($student_name ?? 'Student', 0, 2)) }}
                </div>
                <h5>{{ $student_name ?? 'Student' }}</h5>
                <p>Student Account</p>
            </div>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('student.dashboard') }}" class="active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.equipment-list') }}">
                    <i class="fas fa-basketball-ball"></i>
                    <span>Equipment List</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.booking-status') }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>My Bookings</span>
                    @if(isset($pending_requests) && $pending_requests > 0)
                    <span style="margin-left: auto; background: var(--secondary); color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.8rem;">
                        {{ $pending_requests }}
                    </span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('student.booking-history') }}">
                    <i class="fas fa-history"></i>
                    <span>Booking History</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.filter') }}">
                    <i class="fas fa-filter"></i>
                    <span>Filter Equipment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.request-book') }}">
                    <i class="fas fa-plus-circle"></i>
                    <span>Request Equipment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.feedback') }}">
                    <i class="fas fa-star"></i>
                    <span>Submit Feedback</span>
                </a>
            </li>
        </ul>
        
        <div class="sidebar-footer">
            <a href="{{ route('student.logout') }}" class="btn btn-danger btn-sm w-100">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="welcome-text">
                <h4>Welcome back, {{ explode(' ', $student_name ?? 'Student')[0] }}!</h4>
                <p>Manage your sports equipment rentals</p>
            </div>
            <div class="date-time">
                <div class="current-date" id="currentDate"></div>
                <div class="current-time" id="currentTime"></div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card booking">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $active_bookings ?? 0 }}</div>
                        <div class="stat-label">Active Bookings</div>
                    </div>
                </div>
                <a href="{{ route('student.booking-status') }}" class="stat-link">
                    View Details <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            
            <div class="stat-card pending">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $pending_requests ?? 0 }}</div>
                        <div class="stat-label">Pending Requests</div>
                    </div>
                </div>
                <a href="{{ route('student.booking-status') }}" class="stat-link">
                    Check Status <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            
            <div class="stat-card history">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $total_bookings ?? 0 }}</div>
                        <div class="stat-label">Total Bookings</div>
                    </div>
                </div>
                <a href="{{ route('student.booking-history') }}" class="stat-link">
                    View History <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            
            <div class="stat-card equipment">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $available_equipment ?? 0 }}</div>
                        <div class="stat-label">Available Equipment</div>
                    </div>
                </div>
                <a href="{{ route('student.equipment-list') }}" class="stat-link">
                    Browse Now <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <h3 class="section-title">Quick Actions</h3>
        <div class="actions-grid">
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h5>Browse Equipment</h5>
                <p>Explore available sports equipment</p>
                <a href="{{ route('student.equipment-list') }}" class="btn btn-outline-primary btn-sm">Browse Now</a>
            </div>
            
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5>New Booking</h5>
                <p>Request new equipment rental</p>
                <a href="{{ route('student.request-book') }}" class="btn btn-outline-success btn-sm">Request Now</a>
            </div>
            
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h5>Check Status</h5>
                <p>View your booking status</p>
                <a href="{{ route('student.booking-status') }}" class="btn btn-outline-warning btn-sm">Check Status</a>
            </div>
            
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h5>Give Feedback</h5>
                <p>Share your rental experience</p>
                <a href="{{ route('student.feedback') }}" class="btn btn-outline-info btn-sm">Submit Feedback</a>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="recent-activity">
            <h3 class="section-title">Recent Activity</h3>
            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <div class="activity-details">
                        <h6>New Booking Request</h6>
                        <p>Football - Requested for 2 days</p>
                    </div>
                    <div class="activity-time">2 hours ago</div>
                </li>
                
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="activity-details">
                        <h6>Booking Approved</h6>
                        <p>Table Tennis Set - Ready for pickup</p>
                    </div>
                    <div class="activity-time">Yesterday</div>
                </li>
                
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-undo-alt"></i>
                    </div>
                    <div class="activity-details">
                        <h6>Equipment Returned</h6>
                        <p>Dumbbell Set - Deposit refunded</p>
                    </div>
                    <div class="activity-time">3 days ago</div>
                </li>
                
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="activity-details">
                        <h6>Feedback Submitted</h6>
                        <p>Basketball - Rated 5 stars</p>
                    </div>
                    <div class="activity-time">1 week ago</div>
                </li>
            </ul>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?php echo date("Y"); ?> Sports Equipment Rental Portal | Student Dashboard</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Student Dashboard JS -->
    <script src="{{ asset('assets/student/js/dashboard.js') }}"></script>
</body>
</html>