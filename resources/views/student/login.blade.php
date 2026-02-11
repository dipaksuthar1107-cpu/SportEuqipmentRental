
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Login | Sports Rental Portal</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Student Login CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/student/css/login.css') }}">
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
                    <a class="nav-link active" href="{{ route('student.login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.register') }}">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Login Container -->
<div class="login-container">
    <div class="login-card fade-in">
        <div class="login-header">
            <div class="login-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h3>Student Login</h3>
            <p>Access your sports equipment rental account</p>
        </div>
        
        <div class="login-body">
            <!-- Error handling using Laravel Blade -->
            @if ($errors->any())
            <div class="alert alert-danger fade-in">
                <i class="fas fa-exclamation-circle"></i>
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
            
            @if(request()->has('registered') && request()->get('registered') == 'success')
            <div class="alert alert-success fade-in">
                <i class="fas fa-check-circle"></i>
                <span>Registration successful! Please login with your credentials.</span>
            </div>
            @endif
            
            <!-- Demo Credentials -->
            <!-- <div class="demo-credentials fade-in">
                <h6><i class="fas fa-info-circle"></i> Demo Credentials</h6>
                <p><strong>Email:</strong> student@gmail.com</p>
                <p><strong>Password:</strong> 12345</p>
            </div> -->
            
            <form method="POST" action="{{ route('student.login') }}" id="loginForm">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Email Address / Student ID</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="text" class="form-control" name="email" placeholder="student@gmail.com" required value="{{ old('email') }}">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="password-container">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="login-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <a href="{{ route('student.forgot-password') }}" class="text-decoration-none">Forgot password?</a>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i> Login to Account
                </button>
                
                <div class="login-footer">
                    <p>Don't have an account? <a href="{{ route('student.register') }}">Create Account</a></p>
                    <p class="small text-muted mt-2">By logging in, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></p>
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
<!-- Student Login JS -->
<script src="{{ asset('/assets/student/js/login.js') }}"></script>
</body>
</html>