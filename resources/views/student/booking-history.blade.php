
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
                    {{ strtoupper(substr($student_name ?? 'Student', 0, 2)) }}
                </div>
                <h5>{{ $student_name ?? 'Student' }}</h5>
                <p>Student Account</p>
            </div>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('student.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.equipment-list') }}" class="{{ Request::is('student/equipment-list*') || Request::is('student/equipment-detail*') ? 'active' : '' }}">
                    <i class="fas fa-basketball-ball"></i>
                    <span>Equipment List</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.booking-status') }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>My Bookings</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.booking-history') }}" class="active">
                    <i class="fas fa-history"></i>
                    <span>Booking History</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.equipment-list') }}">
                    <i class="fas fa-filter"></i>
                    <span>Filter Equipment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.equipment-list') }}">
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
                 data-equipment="<?php echo strtolower($item->equipment->name ?? 'N/A'); ?>"
                 data-category="<?php echo strtolower($item->equipment->category ?? 'General'); ?>"
                 data-feedback="<?php echo 'pending'; ?>">
                <div class="history-header">
                    <div class="history-title">
                        <div class="history-icon" style="overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 10px;">
                            @if($item->equipment->image)
                                <img src="{{ asset('storage/' . $item->equipment->image) }}" alt="{{ $item->equipment->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="{{ $item->equipment->icon ?? 'fas fa-dumbbell' }}"></i>
                            @endif
                        </div>
                        <div class="history-details">
                            <h5><?php echo $item->equipment->name ?? 'N/A'; ?></h5>
                            <p><?php echo $item->equipment->category ?? 'General'; ?></p>
                        </div>
                    </div>
                    <span class="badge" style="background: rgba(0, 201, 167, 0.1); color: var(--accent); padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>
                
                <div class="history-body">
                    <div class="history-info">
                        <div class="info-item">
                            <span class="info-label">Booking ID</span>
                            <span class="info-value">#BH-<?php echo str_pad($item->id, 3, '0', STR_PAD_LEFT); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Quantity</span>
                            <span class="info-value"><?php echo $item->quantity; ?> items</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Booked Date</span>
                            <span class="info-value"><?php echo $item->created_at->format('Y-m-d'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Pickup Date</span>
                            <span class="info-value"><?php echo $item->booking_date; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Returned Date</span>
                            <span class="info-value"><?php echo $item->return_date; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Deposit</span>
                            <span class="info-value">₹<?php echo $item->equipment->deposit ?? '0'; ?></span>
                        </div>
                    </div>
                    
                    <div class="feedback-section">
                        <div class="feedback-header">
                            <div>
                                <strong>Feedback Status:</strong>
                                <span class="badge bg-warning" style="margin-left: 0.5rem;">
                                    Pending
                                </span>
                            </div>
                            <div class="rating-display">
                                <span class="no-rating">No rating yet</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="history-actions">
                        <button class="btn-action btn-view" onclick="viewHistoryDetails(<?php echo $item->id; ?>)">
                            <i class="fas fa-eye"></i> View Details
                        </button>
                        <button class="btn-action btn-feedback" onclick="submitFeedback(<?php echo $item->id; ?>)">
                            <i class="fas fa-star"></i> Give Feedback
                        </button>
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