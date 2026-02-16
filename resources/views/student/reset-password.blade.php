<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password | Premium Design</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/student/css/forgot-password.css') }}">
    <style>
        .reset-container {
            max-width: 450px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .reset-header { text-align: center; margin-bottom: 30px; }
        .reset-header i { font-size: 3rem; color: #4CAF50; margin-bottom: 15px; }
        .btn-reset {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-reset:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3); }
    </style>
</head>
<body>
    <div class="container">
        <!-- Reusing layout structure for consistency -->
        <div class="left-panel">
            <div class="brand">
                <i class="fas fa-lock-shield"></i>
                <h1>SecureAccess</h1>
            </div>
            <div class="illustration">
                <div class="illustration-circle"><i class="fas fa-shield-alt"></i></div>
                <h2>Secure Your Account</h2>
                <p>Please enter your new password below. Make sure it's strong and unique.</p>
            </div>
        </div>
        
        <div class="right-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>New Password</h2>
                    <p>Enter and confirm your new password to regain access</p>
                </div>

                @if($errors->any())
                    <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <form action="{{ route('student.reset-password.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="input-group">
                        <label for="password"><i class="fas fa-key"></i> New Password</label>
                        <input type="password" name="password" id="password" placeholder="Min. 5 characters" required>
                    </div>

                    <div class="input-group">
                        <label for="password_confirmation"><i class="fas fa-check-double"></i> Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repeat password" required>
                    </div>
                    
                    <button type="submit" class="btn-reset">
                        Update Password <i class="fas fa-save"></i>
                    </button>
                    
                    <div class="back-to-login">
                        <i class="fas fa-arrow-left"></i>
                        <a href="{{ route('student.login') }}">Return to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
