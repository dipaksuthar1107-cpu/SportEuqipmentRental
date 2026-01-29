<?php
session_start();

// Check if student is logged in
if (!isset($_SESSION['student_login']) || $_SESSION['student_login'] !== true) {
    header("Location: login.php");
    exit();
}

// Get student data
$student_name = isset($_SESSION['student_name']) ? $_SESSION['student_name'] : "John Student";

// Booking data (in real app, fetch from database)
$bookings = [
    [
        'id' => 1,
        'equipment' => 'Cricket Bat',
        'category' => 'Outdoor',
        'quantity' => 2,
        'booking_date' => '10-Feb-2026',
        'pickup_date' => '10-Feb-2026',
        'return_date' => '11-Feb-2026',
        'status' => 'pending',
        'icon' => 'fas fa-baseball-bat',
        'deposit' => '₹400'
    ],
    [
        'id' => 2,
        'equipment' => 'Football',
        'category' => 'Outdoor',
        'quantity' => 1,
        'booking_date' => '05-Feb-2026',
        'pickup_date' => '06-Feb-2026',
        'return_date' => '06-Feb-2026',
        'status' => 'approved',
        'icon' => 'fas fa-futbol',
        'deposit' => '₹150'
    ],
    [
        'id' => 3,
        'equipment' => 'Dumbbells (10kg)',
        'category' => 'Fitness',
        'quantity' => 1,
        'booking_date' => '01-Feb-2026',
        'pickup_date' => '02-Feb-2026',
        'return_date' => '02-Feb-2026',
        'status' => 'collected',
        'icon' => 'fas fa-dumbbell',
        'deposit' => '₹250'
    ],
    [
        'id' => 4,
        'equipment' => 'Badminton Racket',
        'category' => 'Indoor',
        'quantity' => 2,
        'booking_date' => '28-Jan-2026',
        'pickup_date' => '28-Jan-2026',
        'return_date' => '29-Jan-2026',
        'status' => 'returned',
        'icon' => 'fas fa-table-tennis',
        'deposit' => '₹300'
    ],
    [
        'id' => 5,
        'equipment' => 'Basketball',
        'category' => 'Outdoor',
        'quantity' => 1,
        'booking_date' => '25-Jan-2026',
        'pickup_date' => '25-Jan-2026',
        'return_date' => '26-Jan-2026',
        'status' => 'cancelled',
        'icon' => 'fas fa-basketball-ball',
        'deposit' => '₹180'
    ]
];

// Count bookings by status
$status_counts = [
    'pending' => 0,
    'approved' => 0,
    'collected' => 0,
    'returned' => 0,
    'cancelled' => 0
];

foreach ($bookings as $booking) {
    $status_counts[$booking['status']]++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Booking Status | Sports Rental</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Booking Status CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/student/css/booking-status.css') }}">
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
                <a href="dashboard.php">
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
                <a href="booking-status.php" class="active">
                    <i class="fas fa-calendar-check"></i>
                    <span>My Bookings</span>
                </a>
            </li>
            <li>
                <a href="booking-history.php">
                    <i class="fas fa-history"></i>
                    <span>Booking History</span>
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
            <li>
                <a href="logout.php" class="text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
        
        <div class="sidebar-footer">
            <a href="dashboard.php" class="btn btn-outline-primary btn-sm w-100">
                <i class="fas fa-home me-2"></i> Back to Dashboard
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1>My Booking Status</h1>
                <p>Track and manage all your equipment rental bookings</p>
            </div>
            <div class="text-end">
                <a href="request-book.php" class="btn btn-light">
                    <i class="fas fa-plus me-2"></i> New Booking
                </a>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card pending">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value"><?php echo $status_counts['pending']; ?></div>
                <div class="stat-label">Pending</div>
            </div>
            
            <div class="stat-card approved">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value"><?php echo $status_counts['approved']; ?></div>
                <div class="stat-label">Approved</div>
            </div>
            
            <div class="stat-card collected">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-value"><?php echo $status_counts['collected']; ?></div>
                <div class="stat-label">Collected</div>
            </div>
            
            <div class="stat-card returned">
                <div class="stat-icon">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <div class="stat-value"><?php echo $status_counts['returned']; ?></div>
                <div class="stat-label">Returned</div>
            </div>
            
            <div class="stat-card cancelled">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-value"><?php echo $status_counts['cancelled']; ?></div>
                <div class="stat-label">Cancelled</div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="filters">
            <h5 class="mb-3">Filter by Status:</h5>
            <div class="filter-buttons" id="filterButtons">
                <button class="filter-btn active" data-filter="all">All (<?php echo count($bookings); ?>)</button>
                <button class="filter-btn" data-filter="pending">Pending (<?php echo $status_counts['pending']; ?>)</button>
                <button class="filter-btn" data-filter="approved">Approved (<?php echo $status_counts['approved']; ?>)</button>
                <button class="filter-btn" data-filter="collected">Collected (<?php echo $status_counts['collected']; ?>)</button>
                <button class="filter-btn" data-filter="returned">Returned (<?php echo $status_counts['returned']; ?>)</button>
                <button class="filter-btn" data-filter="cancelled">Cancelled (<?php echo $status_counts['cancelled']; ?>)</button>
            </div>
        </div>
        
        <!-- Booking Cards -->
        <div class="booking-cards" id="bookingCards">
            <?php foreach ($bookings as $booking): ?>
            <div class="booking-card <?php echo $booking['status']; ?>" data-status="<?php echo $booking['status']; ?>">
                <div class="booking-header">
                    <div class="booking-title">
                        <div class="booking-icon">
                            <i class="<?php echo $booking['icon']; ?>"></i>
                        </div>
                        <div class="booking-details">
                            <h5><?php echo $booking['equipment']; ?></h5>
                            <p><?php echo $booking['category']; ?></p>
                        </div>
                    </div>
                    <span class="status-badge badge-<?php echo $booking['status']; ?>">
                        <?php echo ucfirst($booking['status']); ?>
                    </span>
                </div>
                
                <div class="booking-body">
                    <div class="booking-info">
                        <div class="info-item">
                            <span class="info-label">Booking ID</span>
                            <span class="info-value">#BK-<?php echo str_pad($booking['id'], 3, '0', STR_PAD_LEFT); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Quantity</span>
                            <span class="info-value"><?php echo $booking['quantity']; ?> items</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Booking Date</span>
                            <span class="info-value"><?php echo $booking['booking_date']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Pickup Date</span>
                            <span class="info-value"><?php echo $booking['pickup_date']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Return Date</span>
                            <span class="info-value"><?php echo $booking['return_date']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Deposit</span>
                            <span class="info-value"><?php echo $booking['deposit']; ?></span>
                        </div>
                    </div>
                    
                    <div class="booking-actions">
                        <button class="btn-action btn-view" onclick="viewBookingDetails(<?php echo $booking['id']; ?>)">
                            <i class="fas fa-eye"></i> View Details
                        </button>
                        <?php if ($booking['status'] == 'pending' || $booking['status'] == 'approved'): ?>
                        <button class="btn-action btn-cancel" onclick="cancelBooking(<?php echo $booking['id']; ?>)">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p class="mb-0">© <?php echo date("Y"); ?> Sports Equipment Rental Portal | My Bookings</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Booking Status JS -->
    <script src="{{ asset('/assets/student/js/booking-status.js') }}"></script>
</body>
</html>