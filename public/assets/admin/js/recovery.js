document.addEventListener('DOMContentLoaded', function () {
    // --- Forgot Password Logic ---
    const forgotForm = document.getElementById('forgotPasswordForm');
    if (forgotForm) {
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const submitBtn = document.getElementById('submitBtn');
        const successMessage = document.getElementById('successMessage');

        forgotForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const email = emailInput.value.trim();
            const verification = document.querySelector('input[name="verification"]:checked').value;
            const csrfToken = document.querySelector('input[name="_token"]').value;

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;

            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, verification })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            forgotForm.style.display = 'none';
                            successMessage.style.display = 'block';
                            showNotification(data.message || 'Reset link sent!', 'success');
                        }
                    } else {
                        showNotification(data.message || 'Error occurred', 'danger');
                    }
                })
                .catch(() => showNotification('Failed to connect', 'danger'))
                .finally(() => {
                    submitBtn.innerHTML = '<span class="btn-text">Send Instructions</span> <i class="fas fa-paper-plane"></i>';
                    submitBtn.disabled = false;
                });
        });
    }

    // --- OTP Verification Logic ---
    const otpInputs = document.querySelectorAll('.otp-input');
    if (otpInputs.length > 0) {
        otpInputs.forEach((input, index, inputs) => {
            input.addEventListener('input', (e) => {
                if (e.inputType === 'deleteContentBackward') return;
                if (input.value && index < inputs.length - 1) inputs[index + 1].focus();
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) inputs[index - 1].focus();
            });
        });
    }

    // --- Notification Helper ---
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;

        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? 'linear-gradient(to right, #4CAF50, #8BC34A)' : 'linear-gradient(to right, #f44336, #e91e63)'};
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 1000;
            transition: all 0.3s ease;
            max-width: 400px;
        `;

        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(20px)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Export showNotification if needed globally
    window.showNotification = showNotification;
});

// Resend OTP Function (Global for onclick)
function resendOtp() {
    const btn = document.getElementById('resend-link');
    if (!btn) return;

    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Resending...';
    btn.style.pointerEvents = 'none';

    fetch(window.routes.resendOtp, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
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
        .catch(() => alert('Failed to resend. Please try again.'))
        .finally(() => {
            btn.innerHTML = originalText;
            btn.style.pointerEvents = 'auto';
        });
}
