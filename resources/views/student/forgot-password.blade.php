<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Password Recovery | Premium Design</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/student/css/forgot-password.css') }}">

</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="brand">
                <i class="fas fa-lock-shield"></i>
                <h1>SecureAccess</h1>
            </div>
            
            <div class="illustration">
                <div class="illustration-circle">
                    <i class="fas fa-key"></i>
                </div>
                <h2>Reset Your Password</h2>
                <p>Enter your email address and we'll send you instructions to reset your password.</p>
            </div>
            
            <div class="security-tips">
                <h3><i class="fas fa-shield-alt"></i> Security Tips</h3>
                <ul>
                    <li>Never share your password with anyone</li>
                    <li>Use a combination of letters, numbers & symbols</li>
                    <li>Change your password regularly</li>
                    <li>Check for phishing attempts in emails</li>
                </ul>
            </div>
        </div>
        
        <div class="right-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>Forgot Password?</h2>
                    <p>Don't worry, we'll help you regain access to your account</p>
                </div>
                
                <form id="forgotPasswordForm">
                    <div class="input-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            placeholder="Enter your registered email" 
                            required
                        >
                        <div class="error-message" id="emailError"></div>
                    </div>
                    
                    <div class="verification-method">
                        <p>Select verification method:</p>
                        <div class="method-options">
                            <label class="method-option">
                                <input type="radio" name="verification" value="email" checked>
                                <div class="option-content">
                                    <i class="fas fa-envelope-open-text"></i>
                                    <span>Email Verification</span>
                                </div>
                            </label>
                            <label class="method-option">
                                <input type="radio" name="verification" value="sms">
                                <div class="option-content">
                                    <i class="fas fa-sms"></i>
                                    <span>SMS Verification</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" id="submitBtn" class="submit-btn">
                        <span class="btn-text">Send Reset Link</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                    
                    <div class="back-to-login">
                        <i class="fas fa-arrow-left"></i>
                        <a href="{{ route('student.login') }}">Back to Login</a>
                    </div>
                </form>
                
                <div class="success-message" id="successMessage">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Reset Link Sent!</h3>
                    <p>We've sent a password reset link to <span id="userEmail"></span>. Please check your inbox and follow the instructions.</p>
                    <p class="note"><i class="fas fa-clock"></i> The link will expire in 30 minutes for security reasons.</p>
                    <button id="resendBtn" class="resend-btn">Resend Link</button>
                </div>
            </div>
            
             <!-- Footer -->
        <div class="footer">
            <p class="mb-0">© <?php echo date("Y"); ?> Sports Equipment Rental Portal | Forgot Password</p>
        </div>
        </div>
    </div>

    <script src="{{ asset('/assets/student/js/forgot-password.js') }}"></script>
</body>
</html>