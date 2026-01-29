<?php
session_start();

// Check if student is logged in
if (!isset($_SESSION['student_login']) || $_SESSION['student_login'] !== true) {
    header("Location: login.php");
    exit();
}

// Get student data
$student_name = isset($_SESSION['student_name']) ? $_SESSION['student_name'] : "John Student";

// Equipment data (in real app, fetch from database)
$equipment = [
    [
        'id' => 1,
        'name' => 'Table Tennis Set',
        'category' => 'Indoor',
        'condition' => 'Excellent',
        'available' => 8,
        'total' => 10,
        'deposit' => '₹200',
        'icon' => 'fas fa-table-tennis',
        'color' => 'primary'
    ],
    [
        'id' => 2,
        'name' => 'Football',
        'category' => 'Outdoor',
        'condition' => 'Good',
        'available' => 12,
        'total' => 15,
        'deposit' => '₹150',
        'icon' => 'fas fa-futbol',
        'color' => 'success'
    ],
    [
        'id' => 3,
        'name' => 'Dumbbell Set (10kg)',
        'category' => 'Fitness',
        'condition' => 'Excellent',
        'available' => 5,
        'total' => 8,
        'deposit' => '₹250',
        'icon' => 'fas fa-dumbbell',
        'color' => 'warning'
    ],
    [
        'id' => 4,
        'name' => 'Basketball',
        'category' => 'Outdoor',
        'condition' => 'Good',
        'available' => 10,
        'total' => 12,
        'deposit' => '₹180',
        'icon' => 'fas fa-basketball-ball',
        'color' => 'danger'
    ],
    [
        'id' => 5,
        'name' => 'Badminton Set',
        'category' => 'Indoor',
        'condition' => 'Excellent',
        'available' => 6,
        'total' => 8,
        'deposit' => '₹220',
        'icon' => 'fas fa-table-tennis',
        'color' => 'info'
    ],
    [
        'id' => 6,
        'name' => 'Yoga Mat',
        'category' => 'Fitness',
        'condition' => 'Good',
        'available' => 15,
        'total' => 20,
        'deposit' => '₹100',
        'icon' => 'fas fa-spa',
        'color' => 'success'
    ],
    [
        'id' => 7,
        'name' => 'Volleyball Set',
        'category' => 'Outdoor',
        'condition' => 'Good',
        'available' => 4,
        'total' => 6,
        'deposit' => '₹300',
        'icon' => 'fas fa-volleyball-ball',
        'color' => 'warning'
    ],
    [
        'id' => 8,
        'name' => 'Chess Board',
        'category' => 'Indoor',
        'condition' => 'Excellent',
        'available' => 9,
        'total' => 10,
        'deposit' => '₹50',
        'icon' => 'fas fa-chess',
        'color' => 'secondary'
    ],
    [
        'id' => 9,
        'name' => 'Cricket Bat',
        'category' => 'Outdoor',
        'condition' => 'Good',
        'available' => 7,
        'total' => 10,
        'deposit' => '₹200',
        'icon' => 'fas fa-baseball-bat',
        'color' => 'success'
    ],
    [
        'id' => 10,
        'name' => 'Tennis Racket',
        'category' => 'Outdoor',
        'condition' => 'Excellent',
        'available' => 5,
        'total' => 8,
        'deposit' => '₹280',
        'icon' => 'fas fa-baseball-ball',
        'color' => 'info'
    ],
    [
        'id' => 11,
        'name' => 'Resistance Bands',
        'category' => 'Fitness',
        'condition' => 'Good',
        'available' => 12,
        'total' => 15,
        'deposit' => '₹80',
        'icon' => 'fas fa-band-aid',
        'color' => 'danger'
    ],
    [
        'id' => 12,
        'name' => 'Whistle & Stopwatch',
        'category' => 'Other',
        'condition' => 'Excellent',
        'available' => 20,
        'total' => 25,
        'deposit' => '₹30',
        'icon' => 'fas fa-clock',
        'color' => 'secondary'
    ]
];

// Get categories for filter
$categories = array_unique(array_column($equipment, 'category'));
sort($categories);
array_unshift($categories, 'All');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filter Equipment | Sports Rental</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/student/css/filter.css">
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
                <a href="booking-history.php">
                    <i class="fas fa-history"></i>
                    <span>Booking History</span>
                </a>
            </li>
            <li>
                <a href="filter.php" class="active">
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
            <h1>Filter Equipment by Category</h1>
            <p>Browse and filter available sports equipment</p>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-section">
            <h5 class="filter-title">Filter by Category</h5>
            <div class="filter-buttons" id="filterButtons">
                <?php foreach ($categories as $index => $category): ?>
                <button class="filter-btn <?php echo $index === 0 ? 'active' : ''; ?>" 
                        data-category="<?php echo strtolower($category); ?>">
                    <?php if ($category === 'Indoor'): ?>
                        <i class="fas fa-home"></i>
                    <?php elseif ($category === 'Outdoor'): ?>
                        <i class="fas fa-sun"></i>
                    <?php elseif ($category === 'Fitness'): ?>
                        <i class="fas fa-dumbbell"></i>
                    <?php elseif ($category === 'Other'): ?>
                        <i class="fas fa-ellipsis-h"></i>
                    <?php else: ?>
                        <i class="fas fa-th-large"></i>
                    <?php endif; ?>
                    <?php echo $category; ?>
                </button>
                <?php endforeach; ?>
            </div>
            
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search equipment by name...">
            </div>
        </div>
        
        <!-- Results Count -->
        <div class="results-count">
            Showing <span id="resultsCount"><?php echo count($equipment); ?></span> of <?php echo count($equipment); ?> equipment items
        </div>
        
        <!-- Equipment Grid -->
        <div class="equipment-grid" id="equipmentGrid">
            <?php foreach ($equipment as $item): ?>
            <div class="equipment-card" 
                 data-category="<?php echo strtolower($item['category']); ?>"
                 data-name="<?php echo strtolower($item['name']); ?>">
                <div class="equipment-header">
                    <div class="equipment-icon">
                        <i class="<?php echo $item['icon']; ?>"></i>
                    </div>
                    <h5><?php echo $item['name']; ?></h5>
                    <span class="category-badge badge-<?php echo strtolower($item['category']); ?>">
                        <?php echo $item['category']; ?>
                    </span>
                </div>
                
                <div class="equipment-body">
                    <div class="equipment-info">
                        <div class="info-item">
                            <span class="info-label">Condition</span>
                            <span class="info-value"><?php echo $item['condition']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Deposit</span>
                            <span class="info-value"><?php echo $item['deposit']; ?></span>
                        </div>
                    </div>
                    
                    <div class="availability">
                        <div class="availability-dot <?php echo $item['available'] > 3 ? 'available' : 'low'; ?>"></div>
                        <span class="info-value"><?php echo $item['available']; ?> of <?php echo $item['total']; ?> available</span>
                    </div>
                    
                    <div class="equipment-actions">
                        <button class="btn-view" onclick="viewEquipment(<?php echo $item['id']; ?>)">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <button class="btn-request" onclick="requestEquipment(<?php echo $item['id']; ?>)">
                            <i class="fas fa-calendar-plus"></i> Request
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p class="mb-0">© <?php echo date("Y"); ?> Sports Equipment Rental Portal | Filter Equipment</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="/assets/student/js/filter.js"></script>
</body>
</html>