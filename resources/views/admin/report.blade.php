<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports & Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/report.css') }}">
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
                    <h4 class="mb-0"><i class="fas fa-chart-bar text-primary me-2"></i> Reports & Analytics</h4>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary fs-6 px-3 py-2">Admin</span>
                </div>
            </div>
        </nav>

        <!-- Date Range Filter -->
        <div class="filters-card fade-in">
            <h5 class="mb-3"><i class="fas fa-calendar-alt me-2"></i>Select Date Range</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-control" id="fromDate" value="2026-01-01">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-control" id="toDate" value="2026-02-28">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Report Type</label>
                    <select class="form-select" id="reportType">
                        <option value="monthly">Monthly Summary</option>
                        <option value="weekly">Weekly Analysis</option>
                        <option value="daily">Daily Report</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100" id="generateReport">
                        <i class="fas fa-sync-alt me-2"></i>Generate Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4 fade-in">
            <div class="col-md-4">
                <div class="stats-card stats-1">
                    <i class="fas fa-dumbbell"></i>
                    <h3 id="totalEquipment">{{ $totalEquipmentCount }}</h3>
                    <p>Total Equipment</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card stats-2">
                    <i class="fas fa-calendar-check"></i>
                    <h3 id="totalBookings">{{ $totalBookingsCount }}</h3>
                    <p>Total Bookings</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card stats-3">
                    <i class="fas fa-undo-alt"></i>
                    <h3 id="returnedItems">{{ $returnedItemsCount }}</h3>
                    <p>Returned Items</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card stats-4">
                    <i class="fas fa-rupee-sign"></i>
                    <h3 id="totalPenalty">₹{{ number_format($totalPenaltyAmount) }}</h3>
                    <p>Total Penalty</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card stats-5">
                    <i class="fas fa-users"></i>
                    <h3 id="activeUsers">{{ $activeUsersCount }}</h3>
                    <p>Active Users</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card stats-6">
                    <i class="fas fa-percentage"></i>
                    <h3 id="returnRate">{{ number_format($returnRate, 1) }}%</h3>
                    <p>Return Rate</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        ... [existing HTML for charts] ...

        <!-- Most Used Equipment -->
        <div class="row mb-4 fade-in">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-trophy me-2"></i>Most Used Equipment
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table table-hover" id="equipmentTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Equipment</th>
                                        <th>Category</th>
                                        <th>Times Rented</th>
                                        <th>Usage %</th>
                                    </tr>
                                </thead>
                                <tbody id="equipmentTableBody">
                                    @foreach($mostUsedEquipment as $index => $usage)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $usage->equipment->name ?? 'N/A' }}</strong></td>
                                        <td>{{ $usage->equipment->category ?? 'N/A' }}</td>
                                        <td>{{ $usage->rentals }}</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-primary" style="width: {{ ($usage->rentals / max(1, $totalBookingsCount)) * 100 }}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Top Borrowers -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-crown me-2"></i>Top Borrowers
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table table-hover" id="borrowersTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Rentals</th>
                                    </tr>
                                </thead>
                                <tbody id="borrowersTableBody">
                                    @foreach($topBorrowers as $index => $borrower)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $borrower->user->name ?? 'N/A' }}</td>
                                        <td><span class="badge bg-info">{{ $borrower->rentals }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Reports -->
        <div class="card fade-in">
            <div class="card-header">
                <i class="fas fa-download me-2"></i>Export Reports
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6>Select Report Format</h6>
                        <div class="export-options mt-3">
                            <button class="btn btn-success export-btn" id="exportExcel">
                                <i class="fas fa-file-excel me-2"></i>Excel Report
                            </button>
                            <button class="btn btn-danger export-btn" id="exportPDF">
                                <i class="fas fa-file-pdf me-2"></i>PDF Report
                            </button>
                            <button class="btn btn-info export-btn" id="exportCSV">
                                <i class="fas fa-file-csv me-2"></i>CSV Data
                            </button>
                            <button class="btn btn-warning export-btn" id="exportPrint">
                                <i class="fas fa-print me-2"></i>Print Report
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6>Quick Stats Export</h6>
                        <div class="mt-3">
                            <button class="btn btn-outline-primary w-100 mb-2" id="exportBookings">
                                <i class="fas fa-calendar-check me-2"></i>Bookings Data
                            </button>
                            <button class="btn btn-outline-success w-100 mb-2" id="exportEquipment">
                                <i class="fas fa-dumbbell me-2"></i>Equipment Data
                            </button>
                            <button class="btn btn-outline-warning w-100" id="exportUsers">
                                <i class="fas fa-users me-2"></i>Users Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer" id="footer">
        © <span id="currentYear"></span> Sports Equipment Rental Portal 
    </footer>

    <!-- PDF Export Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.reportData = {
            bookings: @json($bookingsChartData),
            categories: @json($categoryChartData),
            usage: @json($usageChartData),
            revenue: @json($revenueChartData)
        };
    </script>
    <script src="{{ asset('assets/admin/js/report.js') }}"></script>
</body>
</html>