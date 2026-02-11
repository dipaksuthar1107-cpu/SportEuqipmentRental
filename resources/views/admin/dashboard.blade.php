<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Sports Equipment Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --danger-color: #f72585;
            --dark-color: #0f172a;
            --sidebar-width: 260px;
            --sidebar-collapsed: 80px;
        }
        
        body {
            background: linear-gradient(135deg, #eef2f7 0%, #dfe7f2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--dark-color) 0%, #1e293b 100%);
            color: white;
            position: fixed;
            height: 100vh;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            z-index: 1000;
            box-shadow: 3px 0 20px rgba(0, 0, 0, 0.15);
            overflow-y: auto;
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }
        
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            position: relative;
        }
        
        .sidebar-header h4 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(to right, #4cc9f0, #4361ee);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            transition: all 0.3s;
        }
        
        .sidebar.collapsed .sidebar-header h4 {
            display: none;
        }
        
        .sidebar-header .logo-icon {
            font-size: 2.2rem;
            margin-bottom: 10px;
            color: #4cc9f0;
            display: none;
        }
        
        .sidebar.collapsed .sidebar-header .logo-icon {
            display: block;
        }
        
        .toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #4cc9f0;
        }
        
        .sidebar.collapsed .toggle-btn {
            position: relative;
            right: 0;
            top: 0;
            transform: none;
            margin: 10px auto;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            padding: 0;
            margin: 5px 15px;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .sidebar-menu a {
            color: #cbd5e1;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
            font-weight: 500;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: linear-gradient(to right, rgba(67, 97, 238, 0.2), rgba(76, 201, 240, 0.1));
            color: white;
            border-left: 4px solid #4cc9f0;
            transform: translateX(5px);
        }
        
        .sidebar-menu a i {
            margin-right: 15px;
            font-size: 1.3rem;
            width: 25px;
            text-align: center;
            transition: all 0.3s;
        }
        
        .sidebar.collapsed .sidebar-menu a span {
            display: none;
        }
        
        .sidebar.collapsed .sidebar-menu a i {
            margin-right: 0;
            font-size: 1.4rem;
        }
        
        .sidebar.collapsed .sidebar-menu a {
            justify-content: center;
            padding: 16px;
        }
        
        .sidebar.collapsed .sidebar-menu li {
            margin: 5px 10px;
        }
        
        .user-profile {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
            text-align: center;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4cc9f0, #4361ee);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 1.5rem;
            color: white;
            font-weight: bold;
        }
        
        .user-name {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .user-role {
            font-size: 0.85rem;
            color: #94a3b8;
        }
        
        .sidebar.collapsed .user-profile {
            padding: 15px 5px;
        }
        
        .sidebar.collapsed .user-name,
        .sidebar.collapsed .user-role {
            display: none;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            min-height: 100vh;
        }
        
        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }
        
        /* Topbar */
        .topbar {
            background: white;
            border-radius: 15px;
            padding: 20px 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slideDown 0.5s ease-out;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .topbar h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .date-display {
            color: #64748b;
            font-weight: 500;
        }
        
        .notification-btn {
            background: none;
            border: none;
            font-size: 1.4rem;
            color: #64748b;
            position: relative;
            transition: all 0.3s;
        }
        
        .notification-btn:hover {
            color: var(--primary-color);
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Stats Cards */
        .stats-card {
            border-radius: 16px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            overflow: hidden;
            margin-bottom: 25px;
            border: none;
            height: 100%;
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .stats-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .stats-card .card-body {
            padding: 25px;
            text-align: center;
        }
        
        .stats-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }
        
        .stats-card-1 .stats-icon {
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
        }
        
        .stats-card-2 .stats-icon {
            background: linear-gradient(135deg, #f8961e, #f3722c);
        }
        
        .stats-card-3 .stats-icon {
            background: linear-gradient(135deg, #4cc9f0, #4895ef);
        }
        
        .stats-card-4 .stats-icon {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
        }
        
        .stats-card-5 .stats-icon {
            background: linear-gradient(135deg, #f72585, #b5179e);
        }
        
        .stats-card-6 .stats-icon {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
        }
        
        .stats-card h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 10px 0;
        }
        
        .stats-card p {
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0;
        }
        
        .stats-trend {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .trend-up {
            color: #2ecc71;
        }
        
        .trend-down {
            color: #e74c3c;
        }
        
        .trend-icon {
            margin-right: 5px;
        }
        
        /* Charts Section */
        .chart-card {
            border-radius: 16px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            border: none;
            margin-bottom: 25px;
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .chart-card .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 18px 25px;
            font-weight: 700;
            color: #334155;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .chart-card .card-body {
            padding: 20px;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        /* Tables */
        .table-card {
            border-radius: 16px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            border: none;
            overflow: hidden;
            animation: fadeIn 1s ease-out;
        }
        
        .table-card .card-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 16px 16px 0 0 !important;
            padding: 18px 25px;
            font-weight: 600;
            border: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .table-card .card-body {
            padding: 0;
        }
        
        .table-container {
            border-radius: 0 0 16px 16px;
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            color: #475569;
            font-weight: 700;
            padding: 15px;
            vertical-align: middle;
        }
        
        .table tbody tr {
            transition: all 0.2s;
        }
        
        .table tbody tr:hover {
            background-color: #f8fafc;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-pending {
            background-color: rgba(248, 150, 30, 0.15);
            color: #c5760a;
        }
        
        .status-approved {
            background-color: rgba(46, 204, 113, 0.15);
            color: #27ae60;
        }
        
        .status-collected {
            background-color: rgba(67, 97, 238, 0.15);
            color: #2d4bc4;
        }
        
        .status-returned {
            background-color: rgba(155, 89, 182, 0.15);
            color: #8e44ad;
        }
        
        /* Buttons */
        .btn {
            border-radius: 10px;
            padding: 8px 18px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(67, 97, 238, 0.3);
        }
        
        .btn-success {
            background: linear-gradient(to right, #2ecc71, #27ae60);
        }
        
        .btn-warning {
            background: linear-gradient(to right, #f8961e, #f3722c);
        }
        
        .btn-danger {
            background: linear-gradient(to right, #f72585, #b5179e);
        }
        
        /* Quick Actions */
        .quick-actions {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            animation: fadeInUp 0.7s ease-out;
        }
        
        .quick-actions h5 {
            font-weight: 700;
            color: #334155;
            margin-bottom: 20px;
        }
        
        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 15px;
            border-radius: 12px;
            background: #f8fafc;
            color: #475569;
            text-decoration: none;
            transition: all 0.3s;
            text-align: center;
            height: 100%;
        }
        
        .action-btn:hover {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
        }
        
        .action-btn i {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        
        .action-btn span {
            font-weight: 600;
            font-size: 0.9rem;
        }
        /* Footer */
        .footer {
            background-color: rgba(11, 10, 10, 0.9);
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
        }
        
        .footer.expanded {
            margin-left: var(--sidebar-collapsed);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: var(--sidebar-collapsed);
            }
            
            .sidebar .sidebar-header h4,
            .sidebar .sidebar-menu a span,
            .sidebar .user-name,
            .sidebar .user-role {
                display: none;
            }
            
            .sidebar .sidebar-header .logo-icon {
                display: block;
            }
            
            .sidebar .sidebar-menu a {
                justify-content: center;
                padding: 16px;
            }
            
            .sidebar .sidebar-menu a i {
                margin-right: 0;
                font-size: 1.4rem;
            }
            
            .main-content {
                margin-left: var(--sidebar-collapsed);
            }
            
            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .topbar-actions {
                width: 100%;
                display: flex;
                justify-content: space-between;
            }
        }
        
        /* Animations for cards */
        .stats-card:nth-child(1) { animation-delay: 0.1s; }
        .stats-card:nth-child(2) { animation-delay: 0.2s; }
        .stats-card:nth-child(3) { animation-delay: 0.3s; }
        .stats-card:nth-child(4) { animation-delay: 0.4s; }
        .stats-card:nth-child(5) { animation-delay: 0.5s; }
        .stats-card:nth-child(6) { animation-delay: 0.6s; }
        
        .chart-card:nth-child(1) { animation-delay: 0.3s; }
        .chart-card:nth-child(2) { animation-delay: 0.5s; }
        
        .quick-actions { animation-delay: 0.2s; }
        .table-card { animation-delay: 0.7s; }
    </style>
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
                <a href="{{ route('admin.dashboard') }}" class="active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.equipment') }}">
                    <i class="fas fa-dumbbell"></i>
                    <span>Equipment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.booking') }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Bookings</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.report') }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.penalty') }}">
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
            <div class="user-name">{{ session('admin_name', 'Admin User') }}</div>
            <div class="user-role">Super Administrator</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Topbar -->
        <div class="topbar">
            <div>
                <h2>Sports Equipment Rental Dashboard</h2>
                <div class="date-display" id="currentDate"></div>
            </div>
            <div class="topbar-actions">
                <button class="notification-btn" id="notificationBtn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">5</span>
                </button>
                <span class="badge bg-primary fs-6 px-3 py-2">Admin</span>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h5>Quick Actions</h5>
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <a href="{{ route('admin.equipment') }}" class="action-btn">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Equipment</span>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('admin.booking') }}" class="action-btn">
                        <i class="fas fa-calendar-plus"></i>
                        <span>New Booking</span>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('admin.report') }}" class="action-btn">
                        <i class="fas fa-file-export"></i>
                        <span>Generate Report</span>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('admin.penalty') }}" class="action-btn">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Add Penalty</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="stats-card stats-card-1">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <h3>156</h3>
                        <p>Total Equipment</p>
                        <div class="stats-trend trend-up">
                            <i class="fas fa-arrow-up trend-icon"></i>
                            <span>12% from last month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-card-2">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <h3>12</h3>
                        <p>Pending Requests</p>
                        <div class="stats-trend trend-down">
                            <i class="fas fa-arrow-down trend-icon"></i>
                            <span>5% from last week</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-card-3">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3>62</h3>
                        <p>Approved Today</p>
                        <div class="stats-trend trend-up">
                            <i class="fas fa-arrow-up trend-icon"></i>
                            <span>18% from yesterday</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-card-4">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-undo-alt"></i>
                        </div>
                        <h3>80</h3>
                        <p>Items Returned</p>
                        <div class="stats-trend trend-up">
                            <i class="fas fa-arrow-up trend-icon"></i>
                            <span>8% from last week</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats Cards -->
        <div class="row g-4 mt-0">
            <div class="col-md-3">
                <div class="stats-card stats-card-5">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>128</h3>
                        <p>Active Users</p>
                        <div class="stats-trend trend-up">
                            <i class="fas fa-arrow-up trend-icon"></i>
                            <span>22% from last month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card stats-card-6">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <h3>₹4,850</h3>
                        <p>Penalty Collected</p>
                        <div class="stats-trend trend-up">
                            <i class="fas fa-arrow-up trend-icon"></i>
                            <span>15% from last month</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Charts Row -->
            <div class="col-md-6">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="chart-card">
                            <div class="card-header">
                                <span>Booking Trends</span>
                                <select class="form-select form-select-sm w-auto d-inline-block">
                                    <option>Last 7 Days</option>
                                    <option>Last 30 Days</option>
                                    <option>Last 3 Months</option>
                                </select>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="bookingTrendChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="row g-4">
            <div class="col-md-8">
                <div class="chart-card">
                    <div class="card-header">
                        <span>Equipment Usage Distribution</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="equipmentUsageChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-card">
                    <div class="card-header">
                        <span>Status Overview</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Booking Requests -->
        <div class="table-card">
            <div class="card-header">
                <span>Recent Booking Requests</span>
                <a href="booking.html" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Equipment</th>
                                <th>Category</th>
                                <th>Qty</th>
                                <th>Booking Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#001</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <strong>Amit Patel</strong>
                                            <div class="text-muted small">STU002</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Football</td>
                                <td>Outdoor</td>
                                <td>1</td>
                                <td>10-Feb-2026</td>
                                <td>
                                    <span class="status-badge status-pending">Pending</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success me-1" onclick="updateBookingStatus('001', 'approved')">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="updateBookingStatus('001', 'rejected')">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>#002</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <strong>Rahul Sharma</strong>
                                            <div class="text-muted small">STU001</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Cricket Bat</td>
                                <td>Outdoor</td>
                                <td>2</td>
                                <td>09-Feb-2026</td>
                                <td>
                                    <span class="status-badge status-approved">Approved</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="viewBookingDetails('002')">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>#003</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <strong>Neha Verma</strong>
                                            <div class="text-muted small">STU003</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Badminton Racket</td>
                                <td>Indoor</td>
                                <td>1</td>
                                <td>08-Feb-2026</td>
                                <td>
                                    <span class="status-badge status-collected">Collected</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-secondary" onclick="updateBookingStatus('003', 'returned')">
                                        <i class="fas fa-undo-alt"></i> Mark Returned
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>#004</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <strong>Priya Singh</strong>
                                            <div class="text-muted small">STU004</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Basketball</td>
                                <td>Outdoor</td>
                                <td>1</td>
                                <td>07-Feb-2026</td>
                                <td>
                                    <span class="status-badge status-returned">Returned</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="completeBooking('004')">
                                        <i class="fas fa-flag-checkered"></i> Complete
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>#005</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <strong>Raj Kumar</strong>
                                            <div class="text-muted small">STU005</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Tennis Racket</td>
                                <td>Outdoor</td>
                                <td>1</td>
                                <td>06-Feb-2026</td>
                                <td>
                                    <span class="status-badge status-pending">Pending</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success me-1" onclick="updateBookingStatus('005', 'approved')">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="updateBookingStatus('005', 'rejected')">
                                        <i class="fas fa-times"></i> Reject
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
    
    <script>
        // Sidebar toggle functionality
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            // Change icon based on state
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-chevron-right');
            } else {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-bars');
            }
        });
        
        // Set current date
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
        
        // Initialize charts
        let bookingTrendChart, equipmentUsageChart, statusChart;
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            
            // Notification button click
            document.getElementById('notificationBtn').addEventListener('click', function() {
                showAlert('You have 5 new notifications', 'info');
            });
        });
        
        function initializeCharts() {
            // Booking Trend Chart
            const trendCtx = document.getElementById('bookingTrendChart').getContext('2d');
            bookingTrendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Bookings',
                        data: [12, 19, 8, 15, 22, 18, 25],
                        borderColor: '#4361ee',
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        }
                    }
                }
            });
            
            // Equipment Usage Chart
            const usageCtx = document.getElementById('equipmentUsageChart').getContext('2d');
            equipmentUsageChart = new Chart(usageCtx, {
                type: 'bar',
                data: {
                    labels: ['Cricket', 'Football', 'Badminton', 'Basketball', 'Tennis', 'Other'],
                    datasets: [{
                        label: 'Times Used',
                        data: [45, 38, 28, 22, 18, 12],
                        backgroundColor: [
                            'rgba(67, 97, 238, 0.7)',
                            'rgba(76, 201, 240, 0.7)',
                            'rgba(248, 150, 30, 0.7)',
                            'rgba(247, 37, 133, 0.7)',
                            'rgba(46, 204, 113, 0.7)',
                            'rgba(155, 89, 182, 0.7)'
                        ],
                        borderColor: [
                            '#4361ee',
                            '#4cc9f0',
                            '#f8961e',
                            '#f72585',
                            '#2ecc71',
                            '#9b59b6'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        }
                    }
                }
            });
            
            // Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Approved', 'Collected', 'Returned'],
                    datasets: [{
                        data: [12, 62, 28, 80],
                        backgroundColor: [
                            'rgba(248, 150, 30, 0.7)',
                            'rgba(46, 204, 113, 0.7)',
                            'rgba(67, 97, 238, 0.7)',
                            'rgba(155, 89, 182, 0.7)'
                        ],
                        borderColor: [
                            '#f8961e',
                            '#2ecc71',
                            '#4361ee',
                            '#9b59b6'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
        
        function updateBookingStatus(bookingId, status) {
            const statusMap = {
                'approved': {class: 'status-approved', text: 'Approved'},
                'rejected': {class: 'status-danger', text: 'Rejected'},
                'collected': {class: 'status-collected', text: 'Collected'},
                'returned': {class: 'status-returned', text: 'Returned'}
            };
            
            // Find the booking row (in real app, this would be dynamic)
            showAlert(`Booking #${bookingId} status updated to ${statusMap[status]?.text || status}`, 'success');
            
            // Update stats cards (simulated)
            if (status === 'approved') {
                updateStatCard(3, '+1'); // Approved count
                updateStatCard(2, '-1'); // Pending count
            } else if (status === 'returned') {
                updateStatCard(4, '+1'); // Returned count
            }
        }
        
        function updateStatCard(cardIndex, change) {
            const cards = document.querySelectorAll('.stats-card h3');
            if (cards[cardIndex]) {
                let currentValue = parseInt(cards[cardIndex].textContent);
                if (change.startsWith('+')) {
                    currentValue += parseInt(change.substring(1));
                } else if (change.startsWith('-')) {
                    currentValue = Math.max(0, currentValue - parseInt(change.substring(1)));
                }
                cards[cardIndex].textContent = currentValue;
            }
        }
        
        function viewBookingDetails(bookingId) {
            showAlert(`Viewing details for Booking #${bookingId}`, 'info');
        }
        
        function completeBooking(bookingId) {
            if (confirm('Mark this booking as completed?')) {
                showAlert(`Booking #${bookingId} marked as completed`, 'success');
            }
        }
        
        function showAlert(message, type) {
            // Remove any existing alert
            const existingAlert = document.querySelector('.alert-toast');
            if (existingAlert) {
                existingAlert.remove();
            }
            
            // Create new alert
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-toast position-fixed`;
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(alertDiv);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 3000);
        }
    </script>
</body>
</html>