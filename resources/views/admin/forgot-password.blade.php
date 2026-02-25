<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Password Recovery | Sports Rental</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Admin Recovery CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/recovery.css') }}">
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="brand">
                <i class="fas fa-user-shield"></i>
                <h1>AdminPortal</h1>
            </div>
            <div class="illustration">
                <div class="illustration-circle"><i class="fas fa-key"></i></div>
                <h2>Admin Recovery</h2>
                <p>Enter your administrator email to receive reset instructions.</p>
            </div>
        </div>
        
        <div class="right-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>Forgot Password?</h2>
                    <p>Administrative accounts recovery</p>
                </div>
                
                <form id="forgotPasswordForm">
                    @csrf
                    <div class="input-group">
                        <label for="email"><i class="fas fa-envelope"></i> Work Email</label>
                        <input type="email" id="email" placeholder="admin@example.com" required>
                        <div class="error-message" id="emailError"></div>
                    </div>
                    
                    <div class="verification-method">
                        <p>Select verification method:</p>
                        <div class="method-options">
                            <label class="method-option">
                                <input type="radio" name="verification" value="email" checked>
                                <div class="option-content">
                                    <i class="fas fa-envelope-open-text"></i>
                                    <span>Email</span>
                                </div>
                            </label>
                            <label class="method-option">
                                <input type="radio" name="verification" value="sms">
                                <div class="option-content">
                                    <i class="fas fa-sms"></i>
                                    <span>SMS</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" id="submitBtn" class="submit-btn" style="background: #333;">
                        <span class="btn-text">Send Instructions</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                    
                    <div class="back-to-login">
                        <i class="fas fa-arrow-left"></i>
                        <a href="{{ route('admin.login') }}">Back to Admin Login</a>
                    </div>
                </form>
                
                <div class="success-message" id="successMessage" style="display:none;">
                    <div class="success-icon"><i class="fas fa-check-circle"></i></div>
                    <h3>Instructions Sent!</h3>
                    <p>Follow the link in your email to reset your admin password.</p>
                    <button id="resendBtn" class="resend-btn">Resend Link</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Admin Recovery JS -->
    <script src="{{ asset('assets/admin/js/recovery.js') }}"></script>
</body>
</html>
