<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Equipment Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../admin1/css/equipment.css">
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
                    <h4 class="mb-0"><i class="fas fa-dumbbell text-primary me-2"></i> Equipment Management</h4>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary fs-6 px-3 py-2">Admin</span>
                </div>
            </div>
        </nav>

        <!-- Stats Cards -->
        <div class="row mb-4 fade-in">
            <div class="col-md-3">
                <div class="stats-card stats-1">
                    <i class="fas fa-dumbbell"></i>
                    <h3 id="totalEquipment">156</h3>
                    <p>Total Equipment</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-2">
                    <i class="fas fa-check-circle"></i>
                    <h3 id="availableEquipment">128</h3>
                    <p>Available Now</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-3">
                    <i class="fas fa-tools"></i>
                    <h3 id="maintenanceEquipment">18</h3>
                    <p>Under Maintenance</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-4">
                    <i class="fas fa-users"></i>
                    <h3 id="rentedEquipment">42</h3>
                    <p>Active Rentals</p>
                </div>
            </div>
        </div>

        <!-- Add Equipment -->
        <div class="card mb-4 fade-in">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2"></i>Add New Equipment
            </div>
            <div class="card-body">
                <form id="addEquipmentForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Equipment Name</label>
                                <input type="text" class="form-control" id="equipmentName" placeholder="Enter equipment name" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select class="form-select" id="equipmentCategory" required>
                                    <option value="">Select Category</option>
                                    <option value="indoor">Indoor</option>
                                    <option value="outdoor">Outdoor</option>
                                    <option value="fitness">Fitness</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="equipmentQuantity" placeholder="Qty" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Condition</label>
                                <select class="form-select" id="equipmentCondition">
                                    <option value="excellent">Excellent</option>
                                    <option value="good">Good</option>
                                    <option value="average">Average</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100" id="addEquipmentBtn">
                                <i class="fas fa-plus-circle me-2"></i>Add Equipment
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Equipment Table -->
        <div class="card fade-in">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-list me-2"></i>Equipment List
                </div>
                <div class="d-flex">
                    <input type="text" class="form-control me-2" id="searchEquipment" placeholder="Search equipment..." style="width: 200px;">
                    <button class="btn btn-outline-primary" id="exportBtn">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-hover" id="equipmentTable">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Available</th>
                                <th>Condition</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="equipmentTableBody">
                            <tr id="equipment-1">
                                <td>1</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-baseball-bat-ball"></i>
                                        </div>
                                        <div>
                                            <strong>Cricket Bat</strong>
                                            <div class="text-muted small">BAT-001</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Outdoor</td>
                                <td>20</td>
                                <td>15</td>
                                <td>
                                    <span class="status-badge status-good">Good</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="1" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger me-1 delete-btn" data-id="1" data-bs-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info view-btn" data-id="1" data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr id="equipment-2">
                                <td>2</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-futbol"></i>
                                        </div>
                                        <div>
                                            <strong>Football</strong>
                                            <div class="text-muted small">FB-002</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Outdoor</td>
                                <td>15</td>
                                <td>10</td>
                                <td>
                                    <span class="status-badge status-excellent">Excellent</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger me-1 delete-btn" data-id="2">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info view-btn" data-id="2">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr id="equipment-3">
                                <td>3</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-table-tennis-paddle-ball"></i>
                                        </div>
                                        <div>
                                            <strong>Tennis Racket</strong>
                                            <div class="text-muted small">TR-003</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Indoor</td>
                                <td>12</td>
                                <td>8</td>
                                <td>
                                    <span class="status-badge status-average">Average</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger me-1 delete-btn" data-id="3">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info view-btn" data-id="3">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr id="equipment-4">
                                <td>4</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-basketball"></i>
                                        </div>
                                        <div>
                                            <strong>Basketball</strong>
                                            <div class="text-muted small">BB-004</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Outdoor</td>
                                <td>18</td>
                                <td>12</td>
                                <td>
                                    <span class="status-badge status-good">Good</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="4">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger me-1 delete-btn" data-id="4">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info view-btn" data-id="4">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr id="equipment-5">
                                <td>5</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-dumbbell"></i>
                                        </div>
                                        <div>
                                            <strong>Dumbbell Set</strong>
                                            <div class="text-muted small">DB-005</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Fitness</td>
                                <td>25</td>
                                <td>20</td>
                                <td>
                                    <span class="status-badge status-excellent">Excellent</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="5">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger me-1 delete-btn" data-id="5">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info view-btn" data-id="5">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
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
    <script src="admin1/js/equipment.js"></script>
</body>
</html>