<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile | Sports Rental</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/student/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/student/css/register.css') }}">
    <style>
        .profile-container { margin-top: 50px; }
        .profile-card { padding: 30px; background: white; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    </style>
</head>
<body style="background-color: #f8f9fa;">
    <!-- Mobile Toggle -->
    <button class="mobile-toggle" id="mobileToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('student.profile') }}" class="student-info" style="text-decoration: none; color: inherit; display: block; cursor: pointer; transition: transform 0.2s;">
                <div class="student-avatar">
                    {{ strtoupper(substr($student_name ?? 'Student', 0, 2)) }}
                </div>
                <h5>{{ $student_name ?? 'Student' }}</h5>
                <p>Student Account</p>
            </a>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('student.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.profile') }}" class="active">
                    <i class="fas fa-user-edit"></i>
                    <span>My Profile</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.equipment-list') }}">
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
                <a href="{{ route('student.booking-history') }}">
                    <i class="fas fa-history"></i>
                    <span>Booking History</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.filter') }}">
                    <i class="fas fa-filter"></i>
                    <span>Filter Equipment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.request-book') }}">
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
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="welcome-text">
                <h4>My Profile</h4>
                <p>Update your personal details below</p>
            </div>
            <div class="date-time">
                <div class="current-date" id="currentDate"></div>
            </div>
        </div>

        <div class="container profile-container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="profile-card fade-in">
                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                <div>
                                    <strong>Please fix the following errors:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('student.profile.update') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label">Full Name *</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email Address *</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label">Student ID *</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input type="text" class="form-control" name="student_id" value="{{ old('student_id', $user->student_id) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number *</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="tel" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Department *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                    <select class="form-control" name="department" required>
                                        <option value="">Select Department</option>
                                        <option value="computer_science" {{ (old('department', $user->department) == 'computer_science') ? 'selected' : '' }}>Computer Science</option>
                                        <option value="engineering" {{ (old('department', $user->department) == 'engineering') ? 'selected' : '' }}>Engineering</option>
                                        <option value="business" {{ (old('department', $user->department) == 'business') ? 'selected' : '' }}>Business Administration</option>
                                        <option value="science" {{ (old('department', $user->department) == 'science') ? 'selected' : '' }}>Science</option>
                                        <option value="arts" {{ (old('department', $user->department) == 'arts') ? 'selected' : '' }}>Arts & Humanities</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer mt-5">
            <p>&copy; <?php echo date("Y"); ?> Sports Equipment Rental Portal</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/student/js/dashboard.js') }}"></script>
</body>
</html>
