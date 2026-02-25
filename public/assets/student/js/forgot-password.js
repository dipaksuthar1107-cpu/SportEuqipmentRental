// script.js
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('forgotPasswordForm');
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const submitBtn = document.getElementById('submitBtn');
    const successMessage = document.getElementById('successMessage');
    const userEmailSpan = document.getElementById('userEmail');
    const resendBtn = document.getElementById('resendBtn');

    // Initially hide the success message
    successMessage.style.display = 'none';

    // Email validation function
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Show error function
    function showError(element, message) {
        element.textContent = message;
        element.style.display = 'block';
    }

    // Hide error function
    function hideError(element) {
        element.textContent = '';
        element.style.display = 'none';
    }

    // Handle form submission
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const email = emailInput.value.trim();
        let isValid = true;

        // Reset previous errors
        hideError(emailError);

        // Validate email
        if (!email) {
            showError(emailError, 'Email address is required');
            emailInput.style.borderColor = '#ff3860';
            isValid = false;
        } else if (!validateEmail(email)) {
            showError(emailError, 'Please enter a valid email address');
            emailInput.style.borderColor = '#ff3860';
            isValid = false;
        } else {
            emailInput.style.borderColor = '#4CAF50';
        }

        if (isValid) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;

            const verification = document.querySelector('input[name="verification"]:checked').value;
            const csrfToken = document.querySelector('input[name="_token"]').value;

            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    verification: verification
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            form.style.display = 'none';
                            userEmailSpan.textContent = email;
                            successMessage.querySelector('p').textContent = data.message || `We've sent a password reset OTP to ${email}. Please check your inbox.`;
                            successMessage.style.display = 'block';
                            showNotification(data.message || 'OTP sent successfully!');
                        }
                    } else {
                        showError(emailError, data.message || 'Something went wrong. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError(emailError, 'Failed to send reset link. Please check your connection.');
                })
                .finally(() => {
                    submitBtn.innerHTML = '<span class="btn-text">Send Reset Link</span><i class="fas fa-paper-plane"></i>';
                    submitBtn.disabled = false;
                });
        }
    });

    // Real-time email validation
    emailInput.addEventListener('input', function () {
        const email = emailInput.value.trim();

        if (!email) {
            hideError(emailError);
            emailInput.style.borderColor = '#e1e5ee';
            return;
        }

        if (validateEmail(email)) {
            emailInput.style.borderColor = '#4CAF50';
            hideError(emailError);
        } else {
            emailInput.style.borderColor = '#ff9800';
        }
    });

    // Handle resend button click
    resendBtn.addEventListener('click', function () {
        resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Resending...';
        resendBtn.disabled = true;

        const email = userEmailSpan.textContent.trim() || emailInput.value.trim();
        const verificationInput = document.querySelector('input[name="verification"]:checked');
        const verification = verificationInput ? verificationInput.value : 'email';
        const csrfToken = document.querySelector('input[name="_token"]').value;

        fetch('/student/resend-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email: email, verification: verification })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message || 'New OTP sent successfully!');
                } else {
                    showNotification('Error: ' + (data.message || 'Could not resend OTP.'));
                }
            })
            .catch(() => showNotification('Failed to resend. Please try again.'))
            .finally(() => {
                resendBtn.innerHTML = 'Resend Link';
                resendBtn.disabled = false;
            });
    });

    // Notification function
    function showNotification(message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-check-circle"></i>
                <span>${message}</span>
            </div>
        `;

        // Add styles
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(to right, #4CAF50, #8BC34A);
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
            max-width: 400px;
        `;

        // Create keyframes for animation
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);

        document.body.appendChild(notification);

        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out forwards';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Add focus effect to input fields
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('focus', function () {
            this.parentElement.style.transform = 'translateY(-2px)';
        });

        input.addEventListener('blur', function () {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });

    // Animation for verification options
    const methodOptions = document.querySelectorAll('.method-option');
    methodOptions.forEach(option => {
        option.addEventListener('click', function () {
            methodOptions.forEach(opt => {
                opt.querySelector('.option-content').style.transform = 'scale(1)';
            });

            this.querySelector('.option-content').style.transform = 'scale(1.02)';
        });
    });
});