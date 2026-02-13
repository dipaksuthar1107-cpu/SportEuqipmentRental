<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Equipment Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/equipment.css') }}">
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
                    <h3 id="totalEquipment">{{ $equipment->sum('quantity') }}</h3>
                    <p>Total Equipment</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-2">
                    <i class="fas fa-check-circle"></i>
                    <h3 id="availableEquipment">{{ $equipment->sum('available') }}</h3>
                    <p>Available Now</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-3">
                    <i class="fas fa-tools"></i>
                    <h3 id="maintenanceEquipment">0</h3>
                    <p>Under Maintenance</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-4">
                    <i class="fas fa-users"></i>
                    <h3 id="rentedEquipment">{{ $equipment->sum('quantity') - $equipment->sum('available') }}</h3>
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
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Equipment Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter equipment name" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category" required>
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
                                <label class="form-label">Total Qty</label>
                                <input type="number" class="form-control" name="quantity" placeholder="Qty" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Deposit (₹)</label>
                                <input type="number" class="form-control" name="deposit" placeholder="₹" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Daily Rate (₹)</label>
                                <input type="number" class="form-control" name="daily_rate" placeholder="₹" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Icon Class</label>
                                <input type="text" class="form-control" name="icon" placeholder="fas fa-dumbbell">
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100" id="addEquipmentBtn">
                                <i class="fas fa-plus-circle me-2"></i>Add
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
                            @foreach($equipment as $item)
                            <tr id="equipment-{{ $item->id }}">
                                <td>{{ $item->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="{{ $item->icon ?? 'fas fa-dumbbell' }}"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $item->name }}</strong>
                                            <div class="text-muted small">ID: {{ $item->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ ucfirst($item->category) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->available }}</td>
                                <td>
                                    <span class="status-badge status-{{ $item->available > 0 ? 'excellent' : 'average' }}">
                                        {{ $item->available > 0 ? 'Available' : 'Out of Stock' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1 edit-btn" onclick="editEquipment({{ $item->id }})" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger me-1 delete-btn" onclick="deleteEquipment({{ $item->id }})" data-bs-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info view-btn" onclick="viewEquipment({{ $item->id }})" data-bs-toggle="tooltip" title="View Details">
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

    <!-- Edit Equipment Modal -->
    <div class="modal fade" id="editEquipmentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editEquipmentForm">
                        @csrf
                        <input type="hidden" name="id" id="editEquipmentId">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="editEquipmentName" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category" id="editEquipmentCategory" required>
                                    <option value="indoor">Indoor</option>
                                    <option value="outdoor">Outdoor</option>
                                    <option value="fitness">Fitness</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total Qty</label>
                                <input type="number" class="form-control" name="quantity" id="editEquipmentQuantity" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Deposit (₹)</label>
                                <input type="number" class="form-control" name="deposit" id="editEquipmentDeposit" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Daily Rate (₹)</label>
                                <input type="number" class="form-control" name="daily_rate" id="editEquipmentDailyRate" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="editEquipmentDescription" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Icon Class (e.g. fas fa-dumbbell)</label>
                                <input type="text" class="form-control" name="icon" id="editEquipmentIcon">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateEquipmentBtn">Save Changes</button>
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
        window.dbEquipment = @json($equipment);
    </script>
    <script src="{{ asset('assets/admin/js/equipment.js') }}"></script>
</body>
</html>