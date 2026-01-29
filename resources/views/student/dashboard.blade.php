<?php
session_start();

// Check if student is logged in
if (!isset($_SESSION['student_login']) || $_SESSION['student_login'] !== true) {
    header("Location: student/login.php");
    exit();
}

// Get student data
$student_name = isset($_SESSION['student_name']) ? $_SESSION['student_name'] : "John Student";
$student_email = isset($_SESSION['student_email']) ? $_SESSION['student_email'] : "student@gmail.com";

// Dashboard stats
$active_bookings = 3;
$pending_requests = 1;
$total_bookings = 12;
$available_equipment = 42;
?>
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
    <link rel="stylesheet" href="/assets/student/css/dashboard.css">
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
                    <?php echo strtoupper(substr($student_name, 0, 2)); ?>
                </div>
                <h5><?php echo htmlspecialchars($student_name); ?></h5>
                <p>Student Account</p>
            </div>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="dashboard.php" class="active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="equipment-list.php">
                    <i class="fas fa-basketball-ball"></i>
                    <span>Equipment List</span>
                </a>
            </li>
            <li>
                <a href="booking-status.php">
                    <i class="fas fa-calendar-check"></i>
                    <span>My Bookings</span>
                    <?php if($pending_requests > 0): ?>
                    <span style="margin-left: auto; background: var(--secondary); color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.8rem;">
                        <?php echo $pending_requests; ?>
                    </span>
                    <?php endif; ?>
                </a>
            </li>
            <li>
                <a href="booking-history.php">
                    <i class="fas fa-history"></i>
                    <span>Booking History</span>
                </a>
            </li>
            <li>
                <a href="filter.php">
                    <i class="fas fa-filter"></i>
                    <span>Filter Equipment</span>
                </a>
            </li>
            <li>
                <a href="request-book.php">
                    <i class="fas fa-plus-circle"></i>
                    <span>Request Equipment</span>
                </a>
            </li>
            <li>
                <a href="feedback.php">
                    <i class="fas fa-star"></i>
                    <span>Submit Feedback</span>
                </a>
            </li>
        </ul>
        
        <div class="sidebar-footer">
            <a href="logout.php" class="btn btn-danger btn-sm w-100">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="welcome-text">
                <h4>Welcome back, <?php echo htmlspecialchars(explode(' ', $student_name)[0]); ?>!</h4>
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
                        <div class="stat-value"><?php echo $active_bookings; ?></div>
                        <div class="stat-label">Active Bookings</div>
                    </div>
                </div>
                <a href="booking-status.php" class="stat-link">
                    View Details <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            
            <div class="stat-card pending">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="stat-value"><?php echo $pending_requests; ?></div>
                        <div class="stat-label">Pending Requests</div>
                    </div>
                </div>
                <a href="booking-status.php" class="stat-link">
                    Check Status <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            
            <div class="stat-card history">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div>
                        <div class="stat-value"><?php echo $total_bookings; ?></div>
                        <div class="stat-label">Total Bookings</div>
                    </div>
                </div>
                <a href="booking-history.php" class="stat-link">
                    View History <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            
            <div class="stat-card equipment">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <div>
                        <div class="stat-value"><?php echo $available_equipment; ?></div>
                        <div class="stat-label">Available Equipment</div>
                    </div>
                </div>
                <a href="equipment-list.php" class="stat-link">
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
                <a href="equipment-list.php" class="btn btn-outline-primary btn-sm">Browse Now</a>
            </div>
            
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5>New Booking</h5>
                <p>Request new equipment rental</p>
                <a href="request-book.php" class="btn btn-outline-success btn-sm">Request Now</a>
            </div>
            
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h5>Check Status</h5>
                <p>View your booking status</p>
                <a href="booking-status.php" class="btn btn-outline-warning btn-sm">Check Status</a>
            </div>
            
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h5>Give Feedback</h5>
                <p>Share your rental experience</p>
                <a href="feedback.php" class="btn btn-outline-info btn-sm">Submit Feedback</a>
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
    <script src="/assets/student/js/dashboard.js"></script>
</body>
</html>