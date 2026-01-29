<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Penalty Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../admin1/css/penalty.css">
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
                    <h4 class="mb-0"><i class="fas fa-exclamation-triangle text-danger me-2"></i> Penalty Management</h4>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-danger fs-6 px-3 py-2">Admin</span>
                </div>
            </div>
        </nav>

        <!-- Stats Cards -->
        <div class="row mb-4 fade-in">
            <div class="col-md-3">
                <div class="stats-card stats-1">
                    <i class="fas fa-money-check-alt"></i>
                    <h3 id="totalPenalties">₹8,450</h3>
                    <p>Total Penalties</p>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i>
                        <span>15% from last month</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-2">
                    <i class="fas fa-clock"></i>
                    <h3 id="pendingPenalties">₹3,200</h3>
                    <p>Pending Payment</p>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i>
                        <span>22% from last month</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-3">
                    <i class="fas fa-check-circle"></i>
                    <h3 id="collectedPenalties">₹5,250</h3>
                    <p>Amount Collected</p>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i>
                        <span>8% from last month</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-4">
                    <i class="fas fa-users"></i>
                    <h3 id="studentsWithPenalties">18</h3>
                    <p>Students with Penalties</p>
                    <div class="trend down">
                        <i class="fas fa-arrow-down"></i>
                        <span>5% from last month</span>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- Filters -->
        <div class="filters-card fade-in">
            <h5 class="mb-3"><i class="fas fa-filter me-2"></i>Filter Penalties</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="form-select" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="paid">Paid</option>
                        <option value="waived">Waived</option>
                        <option value="partial">Partial Payment</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterReason">
                        <option value="">All Reasons</option>
                        <option value="late">Late Return</option>
                        <option value="damage">Damage</option>
                        <option value="lost">Lost Equipment</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="filterDate">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-danger w-100" id="applyFilter">
                        <i class="fas fa-search me-2"></i>Filter Penalties
                    </button>
                </div>
            </div>
        </div>

        <!-- Add Penalty -->
        <div class="card mb-4 fade-in">
            <div class="card-header card-header-danger">
                <i class="fas fa-plus-circle me-2"></i>Add New Penalty
            </div>
            <div class="card-body">
                <form id="addPenaltyForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Student Name</label>
                                <select class="form-select" id="penaltyStudent" required>
                                    <option value="">Select Student</option>
                                    <option value="Rahul Sharma (STU001)">Rahul Sharma (STU001)</option>
                                    <option value="Amit Patel (STU002)">Amit Patel (STU002)</option>
                                    <option value="Neha Verma (STU003)">Neha Verma (STU003)</option>
                                    <option value="Priya Singh (STU004)">Priya Singh (STU004)</option>
                                    <option value="Raj Kumar (STU005)">Raj Kumar (STU005)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Equipment</label>
                                <select class="form-select" id="penaltyEquipment" required>
                                    <option value="">Select Equipment</option>
                                    <option value="Cricket Bat (BAT-001)">Cricket Bat (BAT-001)</option>
                                    <option value="Football (FB-002)">Football (FB-002)</option>
                                    <option value="Badminton Racket (BR-003)">Badminton Racket (BR-003)</option>
                                    <option value="Basketball (BB-004)">Basketball (BB-004)</option>
                                    <option value="Tennis Racket (TR-005)">Tennis Racket (TR-005)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Reason</label>
                                <select class="form-select" id="penaltyReason" required>
                                    <option value="">Select Reason</option>
                                    <option value="late">Late Return</option>
                                    <option value="damage">Damage</option>
                                    <option value="lost">Lost Equipment</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Amount (₹)</label>
                                <input type="number" class="form-control" id="penaltyAmount" placeholder="Amount" min="0" step="50" required>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-danger w-100" type="submit" id="addPenaltyBtn">
                                <i class="fas fa-plus-circle me-2"></i>Add Penalty
                            </button>
                        </div>
                    </div>
                    <div class="row mt-3" id="customAmountSection" style="display:none;">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Custom Amount (₹)</label>
                                <input type="number" class="form-control" id="customAmount" placeholder="Enter custom amount">
                            </div>
                        </div>
                        <div class="col-md-8 d-flex align-items-end">
                            <div class="form-text">
                                <i class="fas fa-info-circle text-info me-1"></i>
                                Standard rates: Late Return (₹100/day), Damage (₹300-₹1000), Lost (Equipment cost)
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Penalty Records -->
        <div class="card fade-in">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-list me-2"></i>Penalty Records
                </div>
                <div class="d-flex">
                    <input type="text" class="form-control me-2" placeholder="Search penalties..." style="width: 200px;" id="searchPenalty">
                    <button class="btn btn-outline-danger" id="exportBtn">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover" id="penaltyTable">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Equipment</th>
                                    <th>Reason</th>
                                    <th>Amount</th>
                                    <th>Date Issued</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="penaltyTableBody">
                                <!-- Penalty rows will be added dynamically -->
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
    <script src="admin1/js/penalty.js"></script>
</body>
</html>