

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | Sports Rental Portal</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Admin Login CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/login.css') }}">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="/index.php">Sport<span>Rental</span></a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.login') }}">
                        <i class="fas fa-user-graduate me-1"></i> Student Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active admin-only" href="{{ route('admin.login') }}">
                        <i class="fas fa-user-cog me-1"></i> Admin Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Admin Login Container -->
<div class="admin-login-container">
    <div class="admin-login-card fade-in">
        <div class="admin-login-header">
            <div class="admin-badge">RESTRICTED ACCESS</div>
            <div class="admin-login-icon pulse">
                <i class="fas fa-user-shield"></i>
            </div>
            <h3>Admin Portal</h3>
            <p>Sports Department Staff Access Only</p>
        </div>
        
        <div class="admin-login-body">
            @if ($errors->any())
            <div class="alert alert-danger fade-in">
                <i class="fas fa-exclamation-triangle"></i>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success fade-in">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif
            
            <!-- Demo Credentials -->
            <!-- <div class="demo-credentials fade-in">
                <h6><i class="fas fa-key"></i> Demo Admin Credentials</h6>
                <p><strong>Username:</strong> admin@gmail.com</p>
                <p><strong>Password:</strong> 12345</p>
            </div> -->
            
            <form method="POST" action="{{ route('admin.login') }}" id="adminLoginForm">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Admin Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user-tie"></i>
                        </span>
                        <input type="email" class="form-control" name="email" placeholder="Enter admin email" required value="{{ old('email') }}">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Admin Password</label>
                    <div class="password-container">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="adminPassword" name="password" placeholder="Enter admin password" required>
                        </div>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="rememberAdmin" name="remember">
                    <label class="form-check-label" for="rememberAdmin">
                        Remember this device
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mb-4">
                    <i class="fas fa-sign-in-alt me-2"></i> Access Admin Dashboard
                </button>
                
                <div class="admin-login-footer">
                    <p class="mt-2">Having trouble? <a href="mailto:support@sportrental.edu">Contact System Administrator</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="copyright">
            <p>&copy; <?php echo date("Y"); ?> Sports Equipment Rental Portal.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Admin Login JS -->
    <script src="{{ asset('assets/admin/js/login.js') }}"></script>
</body>
</html>