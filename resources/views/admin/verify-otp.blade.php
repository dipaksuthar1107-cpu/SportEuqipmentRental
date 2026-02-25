<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Verify OTP | Secure Access</title>
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
                <div class="illustration-circle"><i class="fas fa-fingerprint"></i></div>
                <h2>Admin Verification</h2>
                <p>Security check required. Enter the 6-digit code sent to your admin account.</p>
            </div>
        </div>
        
        <div class="right-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>Security OTP</h2>
                    <p>Verifying: <strong>{{ $email }}</strong></p>
                </div>

                @if($errors->any())
                    <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <form action="{{ route('admin.verify-otp.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    <div class="otp-inputs">
                        <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d" required>
                        <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d" required>
                        <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d" required>
                        <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d" required>
                        <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d" required>
                        <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="\d" required>
                    </div>
                    
                    <button type="submit" class="submit-btn" style="width: 100%;">
                        Verify Admin Account <i class="fas fa-shield-alt"></i>
                    </button>
                    
                    <div class="back-to-login">
                        <a href="javascript:void(0)" id="resend-link" onclick="resendOtp()">Request New Code</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Admin Recovery JS -->
    <script>
        window.routes = {
            resendOtp: "{{ route('admin.resend-otp') }}"
        };
    </script>
    <script src="{{ asset('assets/admin/js/recovery.js') }}"></script>
</body>
</html>
