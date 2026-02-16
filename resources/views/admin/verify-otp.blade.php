<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Verify OTP | Secure Access</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/student/css/forgot-password.css') }}">
    <style>
        .otp-inputs { display: flex; justify-content: center; gap: 10px; margin: 30px 0; }
        .otp-input {
            width: 50px; height: 60px; text-align: center; font-size: 1.5rem;
            font-weight: bold; border: 2px solid #e1e5ee; border-radius: 10px;
            transition: all 0.3s ease;
        }
        .otp-input:focus { border-color: #333; outline: none; }
    </style>
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
                    
                    <button type="submit" class="submit-btn" style="width: 100%; background: #333; color: white; border: none; padding: 12px; border-radius: 10px; cursor: pointer;">
                        Verify Admin Account <i class="fas fa-shield-alt"></i>
                    </button>
                    
                    <div class="back-to-login">
                        <a href="javascript:void(0)" id="resend-link" onclick="resendOtp()">Request New Code</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
            input.addEventListener('input', (e) => {
                if (e.inputType === 'deleteContentBackward') return;
                if (input.value && index < inputs.length - 1) inputs[index + 1].focus();
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) inputs[index - 1].focus();
            });
        });

        function resendOtp() {
            const btn = document.getElementById('resend-link');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Resending...';
            btn.style.pointerEvents = 'none';

            fetch("{{ route('admin.resend-otp') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => alert('Failed to resend. Please try again.'))
            .finally(() => {
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            });
        }
    </script>
</body>
</html>
