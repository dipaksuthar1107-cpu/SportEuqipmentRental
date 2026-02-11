<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration | Sports Rental Portal</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/student/css/register.css') }}">
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
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('student.register') }}">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Registration Container -->
<div class="register-container">
    <div class="register-card fade-in">
        <div class="register-header">
            <div class="register-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h3>Create Student Account</h3>
            <p>Join our sports equipment rental community</p>
        </div>
        
        <div class="register-body">
            <!-- Registration Steps -->
            <div class="registration-steps">
                <div class="step active">
                    <div class="step-circle">1</div>
                    <div class="step-label">Details</div>
                </div>
                <div class="step">
                    <div class="step-circle">2</div>
                    <div class="step-label">Account</div>
                </div>
                <div class="step">
                    <div class="step-circle">3</div>
                    <div class="step-label">Complete</div>
                </div>
            </div>
            
            @if ($errors->any())
            <div class="alert alert-danger fade-in">
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
            
            <form method="post" action="{{ route('student.register.submit') }}" id="registrationForm">
                @csrf
                <div class="row form-row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" name="fullname" placeholder="John Smith" required value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Email Address *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control" name="email" placeholder="student@university.edu" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row form-row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Student ID *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-id-card"></i>
                            </span>
                            <input type="text" class="form-control" name="student_id" placeholder="U12345678" required value="<?php echo isset($_POST['student_id']) ? htmlspecialchars($_POST['student_id']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Phone Number *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="tel" class="form-control" name="phone" placeholder="+1 (123) 456-7890" required value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Department</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-graduation-cap"></i>
                        </span>
                        <select class="form-control" name="department">
                            <option value="">Select Department</option>
                            <option value="computer_science" <?php echo (isset($_POST['department']) && $_POST['department'] == 'computer_science') ? 'selected' : ''; ?>>Computer Science</option>
                            <option value="engineering" <?php echo (isset($_POST['department']) && $_POST['department'] == 'engineering') ? 'selected' : ''; ?>>Engineering</option>
                            <option value="business" <?php echo (isset($_POST['department']) && $_POST['department'] == 'business') ? 'selected' : ''; ?>>Business Administration</option>
                            <option value="science" <?php echo (isset($_POST['department']) && $_POST['department'] == 'science') ? 'selected' : ''; ?>>Science</option>
                            <option value="arts" <?php echo (isset($_POST['department']) && $_POST['department'] == 'arts') ? 'selected' : ''; ?>>Arts & Humanities</option>
                        </select>
                    </div>
                </div>
                
                <div class="row form-row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Create Password *</label>
                        <div class="password-container">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Minimum 6 characters" required>
                            </div>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="password-strength-bar" id="passwordStrengthBar"></div>
                        </div>
                        <div class="password-requirements" id="passwordRequirements">
                            <div class="requirement invalid" id="reqLength">
                                <i class="fas fa-circle"></i>
                                <span>At least 6 characters</span>
                            </div>
                            <div class="requirement invalid" id="reqUppercase">
                                <i class="fas fa-circle"></i>
                                <span>One uppercase letter</span>
                            </div>
                            <div class="requirement invalid" id="reqNumber">
                                <i class="fas fa-circle"></i>
                                <span>One number</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Confirm Password *</label>
                        <div class="password-container">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Re-enter password" required>
                            </div>
                            <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback" id="passwordMatchError" style="display: none;">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Passwords do not match</span>
                        </div>
                    </div>
                </div>
                
                <!-- Terms and Conditions -->
                <div class="terms-container">
                    <h6>Terms and Conditions</h6>
                    <p>By creating an account, you agree to the Sports Equipment Rental Portal terms of service. Equipment must be returned on time and in good condition. Late returns will incur penalties. You are responsible for any damage to rented equipment. Your personal information will be used solely for rental purposes and will not be shared with third parties.</p>
                </div>
                
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="agreeTerms" name="agree_terms" required>
                    <label class="form-check-label" for="agreeTerms">
                        I agree to the <a href="#" class="text-decoration-none">Terms and Conditions</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-success w-100 mb-3">
                    <i class="fas fa-user-plus me-2"></i> Create Account
                </button>
                
                <div class="register-footer">
                    <p>Already have an account? <a href="{{ route('student.login') }}">Sign In</a></p>
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
<!-- Custom JS -->
    <script src="{{ asset('assets/student/js/register.js') }}"></script>
</body>
</html>