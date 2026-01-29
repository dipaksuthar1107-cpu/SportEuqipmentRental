<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Booking Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../admin1/css/booking.css">
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
                <a href="dashboard.php" class="active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="equipment.php">
                    <i class="fas fa-dumbbell"></i>
                    <span>Equipment</span>
                </a>
            </li>
            <li>
                <a href="booking.php">
                    <i class="fas fa-calendar-check"></i>
                    <span>Bookings</span>
                </a>
            </li>
            <li>
                <a href="report.php">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li>
                <a href="penalty.php">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Penalty</span>
                </a>
            </li>
            <li class="mt-4">
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
        
        <div class="user-profile">
            <div class="user-avatar">AD</div>
            <div class="user-name">Admin User</div>
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
                            <i class="fas fa-user-circle me-2"></i>Admin User
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
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
                    <h3>12</h3>
                    <p>Pending Requests</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-2">
                    <i class="fas fa-check-circle"></i>
                    <h3>45</h3>
                    <p>Approved Today</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-3">
                    <i class="fas fa-box-open"></i>
                    <h3>28</h3>
                    <p>To Be Collected</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-4">
                    <i class="fas fa-undo-alt"></i>
                    <h3>15</h3>
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
                                <tr id="booking-1">
                                    <td>1</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Rahul Sharma</strong>
                                                <div class="text-muted small">ID: STU001</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-baseball-bat-ball"></i>
                                            </div>
                                            <span>Cricket Bat</span>
                                        </div>
                                    </td>
                                    <td>Outdoor</td>
                                    <td>2</td>
                                    <td>10-Feb-2026</td>
                                    <td>15-Feb-2026</td>
                                    <td>
                                        <span class="status-badge status-pending">Pending</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success me-1" onclick="updateStatus(1, 'approved')" data-bs-toggle="tooltip" title="Approve">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger me-1" onclick="updateStatus(1, 'rejected')" data-bs-toggle="tooltip" title="Reject">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="viewBookingDetails(1)" data-bs-toggle="tooltip" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr id="booking-2">
                                    <td>2</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Amit Patel</strong>
                                                <div class="text-muted small">ID: STU002</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-futbol"></i>
                                            </div>
                                            <span>Football</span>
                                        </div>
                                    </td>
                                    <td>Outdoor</td>
                                    <td>1</td>
                                    <td>09-Feb-2026</td>
                                    <td>12-Feb-2026</td>
                                    <td>
                                        <span class="status-badge status-approved">Approved</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info me-1" onclick="updateStatus(2, 'collected')" data-bs-toggle="tooltip" title="Mark as Collected">
                                            <i class="fas fa-box-open"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editBooking(2)" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr id="booking-3">
                                    <td>3</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Neha Verma</strong>
                                                <div class="text-muted small">ID: STU003</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-table-tennis-paddle-ball"></i>
                                            </div>
                                            <span>Badminton Racket</span>
                                        </div>
                                    </td>
                                    <td>Indoor</td>
                                    <td>1</td>
                                    <td>05-Feb-2026</td>
                                    <td>08-Feb-2026</td>
                                    <td>
                                        <span class="status-badge status-collected">Collected</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary me-1" onclick="updateStatus(3, 'returned')" data-bs-toggle="tooltip" title="Mark as Returned">
                                            <i class="fas fa-undo-alt"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editBooking(3)" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr id="booking-4">
                                    <td>4</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Priya Singh</strong>
                                                <div class="text-muted small">ID: STU004</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-basketball"></i>
                                            </div>
                                            <span>Basketball</span>
                                        </div>
                                    </td>
                                    <td>Outdoor</td>
                                    <td>3</td>
                                    <td>11-Feb-2026</td>
                                    <td>14-Feb-2026</td>
                                    <td>
                                        <span class="status-badge status-returned">Returned</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success me-1" onclick="completeBooking(4)" data-bs-toggle="tooltip" title="Complete">
                                            <i class="fas fa-flag-checkered"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="viewBookingDetails(4)" data-bs-toggle="tooltip" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr id="booking-5">
                                    <td>5</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Raj Kumar</strong>
                                                <div class="text-muted small">ID: STU005</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-dumbbell"></i>
                                            </div>
                                            <span>Dumbbell Set</span>
                                        </div>
                                    </td>
                                    <td>Fitness</td>
                                    <td>1</td>
                                    <td>12-Feb-2026</td>
                                    <td>15-Feb-2026</td>
                                    <td>
                                        <span class="status-badge status-rejected">Rejected</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning me-1" onclick="editBooking(5)" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBooking(5)" data-bs-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
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
    <script src="admin1/js/booking.js"></script>
</body>
</html>