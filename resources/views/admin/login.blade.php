<?php
// admin_login.php
session_start();

// Demo admin credentials (use database in real project)
$admin_username = "admin@gmail.com";
$admin_password = "12345";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin'] = $username;
        $_SESSION['admin_login'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

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
    
    <style>
        :root {
            --primary-color: #2A5CAA;
            --secondary-color: #FF6B35;
            --accent-color: #00C9A7;
            --dark-color: #1A2B4A;
            --light-color: #F8F9FA;
            --gray-color: #6C757D;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --admin-color: #6A11CB;
            --admin-secondary: #2575FC;
            --shadow: 0 5px 15px rgba(0,0,0,0.08);
            --radius: 10px;
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: var(--dark-color);
        }
        
        /* Navbar Styling */
        .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
        }
        
        .navbar-brand span {
            color: var(--secondary-color);
        }
        
        .navbar {
            background-color: white !important;
            box-shadow: var(--shadow);
            padding: 15px 0;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark-color) !important;
            margin: 0 8px;
            transition: var(--transition);
            position: relative;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: var(--transition);
        }
        
        .nav-link:hover::after, .nav-link.active::after {
            width: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--admin-color) 0%, var(--admin-secondary) 100%) !important;
            border: none !important;
            padding: 12px 25px;
            font-weight: 600;
            border-radius: var(--radius);
            transition: var(--transition);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.3);
        }
        
        /* Login Container */
        .admin-login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, #f5f7fa 0%, #e3e7f1 100%);
            position: relative;
            overflow: hidden;
        }
        
        .admin-login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect fill="%236A11CB" fill-opacity="0.03" width="100" height="100"/><path d="M0,0 L100,100 M100,0 L0,100" stroke="%236A11CB" stroke-width="0.5" stroke-opacity="0.05"/></svg>');
        }
        
        .admin-login-card {
            background-color: white;
            border-radius: var(--radius);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
            border-top: 5px solid var(--admin-color);
        }
        
        .admin-login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
        }
        
        .admin-login-header {
            background: linear-gradient(135deg, var(--admin-color) 0%, var(--admin-secondary) 100%);
            color: white;
            padding: 35px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .admin-login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }
        
        .admin-login-icon {
            width: 90px;
            height: 90px;
            background-color: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            border: 3px solid rgba(255,255,255,0.3);
        }
        
        .admin-login-header h3 {
            color: white;
            margin-bottom: 10px;
            font-size: 1.8rem;
        }
        
        .admin-login-header p {
            opacity: 0.9;
            font-size: 0.95rem;
            max-width: 300px;
            margin: 0 auto;
        }
        
        .admin-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: rgba(255,255,255,0.2);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            backdrop-filter: blur(5px);
        }
        
        .admin-login-body {
            padding: 40px;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark-color);
        }
        
        .form-control {
            padding: 12px 15px;
            border-radius: var(--radius);
            border: 1px solid #ddd;
            transition: var(--transition);
            font-size: 16px;
        }
        
        .form-control:focus {
            border-color: var(--admin-color);
            box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.2);
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            color: var(--admin-color);
        }
        
        /* Alert Styling */
        .alert {
            border-radius: var(--radius);
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }
        
        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }
        
        /* Demo Credentials Box */
        .demo-credentials {
            background-color: #f8f9fa;
            border-radius: var(--radius);
            padding: 18px;
            margin-bottom: 25px;
            border-left: 4px solid var(--admin-color);
        }
        
        .demo-credentials h6 {
            color: var(--admin-color);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }
        
        .demo-credentials p {
            font-size: 0.85rem;
            margin-bottom: 6px;
            color: var(--gray-color);
        }
        
        .demo-credentials p strong {
            color: var(--dark-color);
        }
        
        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-color);
            cursor: pointer;
            z-index: 2;
        }
        
        .password-container {
            position: relative;
        }
        
        .admin-login-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 0.9rem;
            color: var(--gray-color);
        }
        
        .admin-login-footer a {
            color: var(--admin-color);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .admin-login-footer a:hover {
            text-decoration: underline;
        }
        
        /* Security Features */
        .security-features {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 25px;
            font-size: 0.8rem;
        }
        
        .security-item {
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--gray-color);
        }
        
        .security-item i {
            color: var(--accent-color);
        }
        
        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 20px 0;
            margin-top: auto;
        }
        
        .copyright {
            text-align: center;
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .admin-login-body {
                padding: 30px 20px;
            }
            
            .admin-login-header {
                padding: 25px 20px;
            }
            
            .security-features {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
        }
        
        /* Admin-specific styling */
        .admin-only {
            position: relative;
        }
        
        .admin-only::after {
            content: 'ADMIN';
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--admin-color);
            color: white;
            font-size: 0.6rem;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 700;
            letter-spacing: 1px;
        }
    </style>
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
            <?php if($error): ?>
            <div class="alert alert-danger fade-in">
                <i class="fas fa-exclamation-triangle"></i>
                <span><strong>Access Denied:</strong> <?php echo htmlspecialchars($error); ?></span>
            </div>
            <?php endif; ?>
            
            <!-- Demo Credentials -->
            {{-- <div class="demo-credentials fade-in">
                <h6><i class="fas fa-key"></i> Demo Admin Credentials</h6>
                <p><strong>Username:</strong> admin@gmail.com</p>
                <p><strong>Password:</strong> 12345</p>
            </div> --}}
            
            <form method="post" id="adminLoginForm">
                <div class="mb-4">
                    <label class="form-label">Admin Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user-tie"></i>
                        </span>
                        <input type="text" class="form-control" name="username" placeholder="Enter admin username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
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

<script>
    // Password Toggle Visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('adminPassword');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
    
    // Form validation
    document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
        const username = this.querySelector('input[name="username"]').value;
        const password = this.querySelector('input[name="password"]').value;
        
        if (!username || !password) {
            e.preventDefault();
            showAlert('Please fill in all required fields.', 'warning');
        }
    });
    
    // Auto-fill demo credentials
    document.querySelectorAll('.demo-credentials p').forEach(item => {
        item.addEventListener('click', function() {
            const text = this.textContent;
            if (text.includes('Username:')) {
                document.querySelector('input[name="username"]').value = 'admin@gmail.com';
            } else if (text.includes('Password:')) {
                document.getElementById('adminPassword').value = '12345';
            }
        });
    });
    
    // Show alert function
    function showAlert(message, type) {
        // Create alert element
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'warning' ? 'warning' : 'danger'} fade-in`;
        alertDiv.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 400px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        `;
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-circle"></i>
            <span>${message}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left: auto;"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Remove alert after 4 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 4000);
    }
    
    // Focus on username field
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('input[name="username"]').focus();
        
        // Add security warning for admin access
        console.log('%c⚠️ SECURITY WARNING ⚠️', 'color: #dc3545; font-size: 18px; font-weight: bold;');
        console.log('%cThis is a restricted admin portal. Unauthorized access attempts will be logged and reported.', 'color: #ffc107; font-size: 14px;');
    });
    
    // Auto-logout warning
    let idleTimer;
    function resetIdleTimer() {
        clearTimeout(idleTimer);
        idleTimer = setTimeout(() => {
            if (document.querySelector('input[name="username"]').value || 
                document.querySelector('input[name="password"]').value) {
                showAlert('For security, session will expire due to inactivity.', 'warning');
            }
        }, 300000); // 5 minutes
    }
    
    // Reset timer on user activity
    ['mousemove', 'keypress', 'click'].forEach(event => {
        document.addEventListener(event, resetIdleTimer);
    });
    
    // Initialize idle timer
    resetIdleTimer();
</script>
</body>
</html>