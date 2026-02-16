<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP | Premium Design</title>
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
        .otp-input:focus { border-color: #4CAF50; outline: none; box-shadow: 0 0 10px rgba(76, 175, 80, 0.2); transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="brand">
                <i class="fas fa-shield-check"></i>
                <h1>SecureAccess</h1>
            </div>
            <div class="illustration">
                <div class="illustration-circle"><i class="fas fa-lock-open"></i></div>
                <h2>Verify Identity</h2>
                <p>We've sent a 6-digit code to your email/SMS. Please enter it below to continue.</p>
            </div>
        </div>
        
        <div class="right-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>Enter OTP</h2>
                    <p>OTP sent to: <strong>{{ $email }}</strong></p>
                </div>

                @if($errors->any())
                    <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <form action="{{ route('student.verify-otp.submit') }}" method="POST">
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
                    
                    <button type="submit" class="submit-btn" style="width: 100%; background: #4CAF50; color: white; border: none; padding: 12px; border-radius: 10px; cursor: pointer; font-weight: 600;">
                        Verify & Continue <i class="fas fa-arrow-right"></i>
                    </button>
                    
                    <div class="back-to-login">
                        <i class="fas fa-redo"></i>
                        <a href="javascript:void(0)" id="resend-link" onclick="resendOtp()">Resend OTP</a>
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

            fetch("{{ route('student.resend-otp') }}", {
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
