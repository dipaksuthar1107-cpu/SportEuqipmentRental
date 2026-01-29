<?php
session_start();

// Check if student is logged in
if (!isset($_SESSION['student_login']) || $_SESSION['student_login'] !== true) {
    header("Location: login.php");
    exit();
}

// Get student data
$student_name = isset($_SESSION['student_name']) ? $_SESSION['student_name'] : "John Student";

// Booking history data (in real app, fetch from database)
$history = [
    [
        'id' => 1,
        'equipment' => 'Cricket Bat',
        'category' => 'Outdoor',
        'quantity' => 2,
        'booked_date' => '05-Jan-2026',
        'pickup_date' => '05-Jan-2026',
        'returned_date' => '06-Jan-2026',
        'status' => 'returned',
        'feedback' => 'submitted',
        'icon' => 'fas fa-baseball-bat',
        'deposit' => '₹400',
        'rating' => 5,
        'feedback_date' => '07-Jan-2026'
    ],
    [
        'id' => 2,
        'equipment' => 'Football',
        'category' => 'Outdoor',
        'quantity' => 1,
        'booked_date' => '20-Dec-2025',
        'pickup_date' => '20-Dec-2025',
        'returned_date' => '21-Dec-2025',
        'status' => 'returned',
        'feedback' => 'pending',
        'icon' => 'fas fa-futbol',
        'deposit' => '₹150',
        'rating' => null,
        'feedback_date' => null
    ],
    [
        'id' => 3,
        'equipment' => 'Dumbbells (10kg)',
        'category' => 'Fitness',
        'quantity' => 1,
        'booked_date' => '10-Dec-2025',
        'pickup_date' => '10-Dec-2025',
        'returned_date' => '10-Dec-2025',
        'status' => 'returned',
        'feedback' => 'submitted',
        'icon' => 'fas fa-dumbbell',
        'deposit' => '₹250',
        'rating' => 4,
        'feedback_date' => '11-Dec-2025'
    ],
    [
        'id' => 4,
        'equipment' => 'Basketball',
        'category' => 'Outdoor',
        'quantity' => 1,
        'booked_date' => '05-Dec-2025',
        'pickup_date' => '05-Dec-2025',
        'returned_date' => '06-Dec-2025',
        'status' => 'returned',
        'feedback' => 'submitted',
        'icon' => 'fas fa-basketball-ball',
        'deposit' => '₹180',
        'rating' => 5,
        'feedback_date' => '07-Dec-2025'
    ],
    [
        'id' => 5,
        'equipment' => 'Table Tennis Set',
        'category' => 'Indoor',
        'quantity' => 1,
        'booked_date' => '25-Nov-2025',
        'pickup_date' => '25-Nov-2025',
        'returned_date' => '26-Nov-2025',
        'status' => 'returned',
        'feedback' => 'submitted',
        'icon' => 'fas fa-table-tennis',
        'deposit' => '₹300',
        'rating' => 4,
        'feedback_date' => '27-Nov-2025'
    ],
    [
        'id' => 6,
        'equipment' => 'Badminton Racket',
        'category' => 'Indoor',
        'quantity' => 2,
        'booked_date' => '15-Nov-2025',
        'pickup_date' => '15-Nov-2025',
        'returned_date' => '16-Nov-2025',
        'status' => 'returned',
        'feedback' => 'pending',
        'icon' => 'fas fa-table-tennis',
        'deposit' => '₹300',
        'rating' => null,
        'feedback_date' => null
    ]
];

// Stats
$total_bookings = count($history);
$feedback_pending = array_filter($history, function($item) {
    return $item['feedback'] === 'pending';
});
$feedback_pending_count = count($feedback_pending);

// Sort by date (newest first)
usort($history, function($a, $b) {
    return strtotime($b['booked_date']) - strtotime($a['booked_date']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking History | Sports Rental</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Booking History CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/student/css/booking-history.css') }}">
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
                <a href="booking-status.php">
                    <i class="fas fa-calendar-check"></i>
                    <span>My Bookings</span>
                </a>
            </li>
            <li>
                <a href="booking-history.php" class="active">
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
            <h1>Booking History</h1>
            <p>View all your past equipment rentals and manage feedback</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card history">
                <div class="stat-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="stat-value"><?php echo $total_bookings; ?></div>
                <div class="stat-label">Total Bookings</div>
            </div>
            
            <div class="stat-card pending">
                <div class="stat-icon">
                    <i class="fas fa-comment-dots"></i>
                </div>
                <div class="stat-value"><?php echo $feedback_pending_count; ?></div>
                <div class="stat-label">Pending Feedback</div>
            </div>
        </div>
        
        <!-- Search & Filter -->
        <div class="search-filter">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search equipment or category...">
            </div>
            <div class="filter-select">
                <select id="feedbackFilter">
                    <option value="all">All Feedback Status</option>
                    <option value="pending">Pending Feedback</option>
                    <option value="submitted">Submitted Feedback</option>
                </select>
            </div>
            <div class="filter-select">
                <select id="categoryFilter">
                    <option value="all">All Categories</option>
                    <option value="outdoor">Outdoor</option>
                    <option value="indoor">Indoor</option>
                    <option value="fitness">Fitness</option>
                </select>
            </div>
        </div>
        
        <!-- History Cards -->
        <div class="history-container" id="historyContainer">
            <?php foreach ($history as $item): ?>
            <div class="history-card" 
                 data-equipment="<?php echo strtolower($item['equipment']); ?>"
                 data-category="<?php echo strtolower($item['category']); ?>"
                 data-feedback="<?php echo $item['feedback']; ?>">
                <div class="history-header">
                    <div class="history-title">
                        <div class="history-icon">
                            <i class="<?php echo $item['icon']; ?>"></i>
                        </div>
                        <div class="history-details">
                            <h5><?php echo $item['equipment']; ?></h5>
                            <p><?php echo $item['category']; ?></p>
                        </div>
                    </div>
                    <span class="badge" style="background: rgba(0, 201, 167, 0.1); color: var(--accent); padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
                        Completed
                    </span>
                </div>
                
                <div class="history-body">
                    <div class="history-info">
                        <div class="info-item">
                            <span class="info-label">Booking ID</span>
                            <span class="info-value">#BH-<?php echo str_pad($item['id'], 3, '0', STR_PAD_LEFT); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Quantity</span>
                            <span class="info-value"><?php echo $item['quantity']; ?> items</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Booked Date</span>
                            <span class="info-value"><?php echo $item['booked_date']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Pickup Date</span>
                            <span class="info-value"><?php echo $item['pickup_date']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Returned Date</span>
                            <span class="info-value"><?php echo $item['returned_date']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Deposit</span>
                            <span class="info-value"><?php echo $item['deposit']; ?></span>
                        </div>
                    </div>
                    
                    <div class="feedback-section">
                        <div class="feedback-header">
                            <div>
                                <strong>Feedback Status:</strong>
                                <span class="badge <?php echo $item['feedback'] == 'submitted' ? 'bg-success' : 'bg-warning'; ?>" style="margin-left: 0.5rem;">
                                    <?php echo ucfirst($item['feedback']); ?>
                                </span>
                            </div>
                            <div class="rating-display">
                                <?php if ($item['rating']): ?>
                                <div class="stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $item['rating']): ?>
                                            <i class="fas fa-star"></i>
                                        <?php else: ?>
                                            <i class="far fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <span><?php echo $item['rating']; ?>/5</span>
                                <?php else: ?>
                                <span class="no-rating">No rating yet</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ($item['feedback_date']): ?>
                        <p class="mb-0" style="font-size: 0.85rem; color: #666;">
                            <i class="far fa-calendar me-1"></i>
                            Feedback submitted on <?php echo $item['feedback_date']; ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="history-actions">
                        <button class="btn-action btn-view" onclick="viewHistoryDetails(<?php echo $item['id']; ?>)">
                            <i class="fas fa-eye"></i> View Details
                        </button>
                        <?php if ($item['feedback'] == 'pending'): ?>
                        <button class="btn-action btn-feedback" onclick="submitFeedback(<?php echo $item['id']; ?>)">
                            <i class="fas fa-star"></i> Give Feedback
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Empty State (hidden by default) -->
        <div class="empty-state" id="emptyState" style="display: none;">
            <i class="fas fa-history"></i>
            <h4>No matching bookings found</h4>
            <p>Try adjusting your search or filter criteria</p>
            <button class="btn btn-primary" onclick="resetFilters()">
                <i class="fas fa-redo me-2"></i> Reset Filters
            </button>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p class="mb-0">© <?php echo date("Y"); ?> Sports Equipment Rental Portal | Booking History</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Booking History JS -->
    <script src="{{ asset('/assets/student/js/booking-history.js') }}"></script>
</body>
</html>