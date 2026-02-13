<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Penalty Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/penalty.css') }}">
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
                    <h3 id="totalPenalties">₹{{ number_format($penalties->sum('amount')) }}</h3>
                    <p>Total Penalties</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-2">
                    <i class="fas fa-clock"></i>
                    <h3 id="pendingPenalties">₹{{ number_format($penalties->where('status', 'unpaid')->sum('amount')) }}</h3>
                    <p>Pending Payment</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-3">
                    <i class="fas fa-check-circle"></i>
                    <h3 id="collectedPenalties">₹{{ number_format($penalties->where('status', 'paid')->sum('amount')) }}</h3>
                    <p>Amount Collected</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-4">
                    <i class="fas fa-users"></i>
                    <h3 id="studentsWithPenalties">{{ $penalties->pluck('user_id')->unique()->count() }}</h3>
                    <p>Students with Penalties</p>
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
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Student</label>
                                <select class="form-select" name="user_id" required>
                                    <option value="">Select Student</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Equipment</label>
                                <select class="form-select" name="equipment_id" required>
                                    <option value="">Select Equipment</option>
                                    @foreach($equipment as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Reason</label>
                                <select class="form-select" name="reason" required>
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
                                <input type="number" class="form-control" name="amount" placeholder="Amount" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-danger w-100" type="submit" id="addPenaltyBtn">
                                <i class="fas fa-plus-circle me-2"></i>Add
                            </button>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Details</label>
                            <textarea class="form-control" name="reason_details" rows="1" placeholder="Enter details..."></textarea>
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
                                    <th>Issued</th>
                                    <th>Due</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="penaltyTableBody">
                                @foreach($penalties as $penalty)
                                <tr>
                                    <td>{{ $penalty->id }}</td>
                                    <td>
                                        <strong>{{ $penalty->user->name ?? 'N/A' }}</strong>
                                        <div class="small text-muted">{{ $penalty->user->email ?? '' }}</div>
                                    </td>
                                    <td>{{ $penalty->equipment->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ ucfirst($penalty->reason) }}</span>
                                        <div class="small text-muted">{{ $penalty->reason_details }}</div>
                                    </td>
                                    <td><strong>₹{{ number_format($penalty->amount) }}</strong></td>
                                    <td>{{ $penalty->issued_date }}</td>
                                    <td>{{ $penalty->due_date }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $penalty->status }}">{{ ucfirst($penalty->status) }}</span>
                                    </td>
                                    <td>
                                        @if($penalty->status == 'unpaid')
                                        <button class="btn btn-sm btn-success" onclick="updatePenaltyStatus({{ $penalty->id }}, 'paid')" title="Mark as Paid">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                        <button class="btn btn-sm btn-info" onclick="viewPenalty({{ $penalty->id }})" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
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
    <script>
        window.dbPenalties = @json($penalties);
    </script>
    <script src="{{ asset('assets/admin/js/penalty.js') }}"></script>
</body>
</html>