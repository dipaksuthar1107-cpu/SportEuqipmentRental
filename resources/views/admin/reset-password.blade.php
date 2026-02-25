<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reset Password | Secure Portal</title>
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
                <h1>AdminPanel</h1>
            </div>
            <div class="illustration">
                <div class="illustration-circle"><i class="fas fa-lock"></i></div>
                <h2>Admin Recovery</h2>
                <p>System administrator password reset portal. Please use a high-security password.</p>
            </div>
        </div>
        
        <div class="right-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>Admin Reset</h2>
                    <p>Enter your new administrative password</p>
                </div>

                @if($errors->any())
                    <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <form action="{{ route('admin.reset-password.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="input-group">
                        <label for="password"><i class="fas fa-key"></i> New Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <div class="input-group">
                        <label for="password_confirmation"><i class="fas fa-check-double"></i> Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        Update Admin Password <i class="fas fa-shield-alt"></i>
                    </button>
                    
                    <div class="back-to-login">
                        <i class="fas fa-arrow-left"></i>
                        <a href="{{ route('admin.login') }}">Back to Admin Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Admin Recovery JS -->
    <script src="{{ asset('assets/admin/js/recovery.js') }}"></script>
</body>
</html>
